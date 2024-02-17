<?php

namespace App\Services\AttendanceService;


use App\Services\AttendanceService\AttendanceServiceInterface;

use App\Repositories\{
    AttendanceRepository\AttendanceRepositoryInterface,
    RoleRepository\RoleRepositoryInterface,
    BusinessDateRepository\BusinessDateRepositoryInterface,
};
use App\Utils\TimeUtility;
use Illuminate\Support\{
    Carbon,
    Collection
};
use App\Models\{
    Attendance,
    BusinessDate,
    Store
};

class AttendanceService implements AttendanceServiceInterface
{
    /** フロントと共通のため編集禁止 */
    const TARDY_ABSENCE_TYPE = [
        'TARDY' => '1',
        'ABSENCE' => '2',
        'UNAUTHORIZED_ABSENCE' => '3'
    ];

    public function __construct(
        public readonly AttendanceRepositoryInterface $attendanceRepo,
        public readonly RoleRepositoryInterface $roleRepo,
        public readonly BusinessDateRepositoryInterface $businessDateRepo,
    ) {
    }

    /**
     * 勤退情報を一括登録する
     *
     */
    public function updateOrInsertAttendances($request, $store)
    {
        $requestAttendances = $request->attendances;
        foreach ($requestAttendances as $requestAttendance) {

            // 営業日付の取得
            $businessDate = $this->businessDateRepo->findBusinessDate($request->business_date_id);
            $attendanceData = [];

            // 出退勤時間を計算
            $attendanceData['working_start_at'] = TimeUtility::caluculateDateTime(
                $businessDate,
                $requestAttendance['working_start_at_hh'],
                $requestAttendance['working_start_at_mm']
            );
            $attendanceData['working_end_at'] = TimeUtility::caluculateDateTime(
                $businessDate,
                $requestAttendance['working_end_at_hh'],
                $requestAttendance['working_end_at_mm']
            );

            // 休憩時間
            $attendanceData['break_total_minute'] = $requestAttendance['break_total_minute'];

            // 勤退情報の親レコードを作成
            // 以下のコードは、既存データを削除せず、受け取ったすべてのレコードを作成、または更新する。
            $this->attendanceRepo->updateOrInsertAttendance(
                $requestAttendance['user_id'],
                $request->business_date_id,
                $attendanceData
            );
        }
    }

    /**
     * 遅刻欠勤情報を登録する
     * @param $request
     * @param Store $store
     */
    public function updateOrInsertTardyAbsenceInfo($request, Store $store)
    {
        $requestAttendance = $request->attendance;

        if ($requestAttendance['tardy_absence_type'] === self::TARDY_ABSENCE_TYPE['TARDY']) {
            $attendanceStoreData['late_total_minute'] = $requestAttendance['late_total_minute'];
            $attendanceStoreData['absence'] = false;
            $attendanceStoreData['unauthorized_absence'] = false;
        } elseif ($requestAttendance['tardy_absence_type'] === self::TARDY_ABSENCE_TYPE['ABSENCE']) {
            $attendanceStoreData['absence'] = true;
            $attendanceStoreData['unauthorized_absence'] = false;
            $attendanceStoreData['late_total_minute'] = 0;
        } elseif ($requestAttendance['tardy_absence_type'] === self::TARDY_ABSENCE_TYPE['UNAUTHORIZED_ABSENCE']) {
            $attendanceStoreData['unauthorized_absence'] = true;
            $attendanceStoreData['absence'] = false;
            $attendanceStoreData['late_total_minute'] = 0;
        }

        $this->attendanceRepo->updateOrInsertAttendance(
            $requestAttendance['user_id'],
            $request->business_date_id,
            $attendanceStoreData
        );
    }

    /**
     * 現金支給情報を登録する
     * @param $request
     * @param Store $store
     */
    public function updateOrInsertPayrollPaymentInfo($request, Store $store)
    {
        $requestAttendance = $request->attendance;

        $attendanceData = [];

        $attendanceData['payment_amount'] = $requestAttendance['payment_amount'];
        $attendanceData['payment_source'] =
            ($requestAttendance['payment_source'])
            ? 'other'
            : 'cash_register';
        $attendanceData['payment_type'] = $requestAttendance['payment_type'];

        $this->attendanceRepo->updateOrInsertAttendance(
            $requestAttendance['user_id'],
            $request->business_date_id,
            $attendanceData
        );
    }


    /**
     * 出退勤登録向けに整形した勤退情報を取得
     * @param Collection $users
     * @param BusinessDate $businessDate
     * @param Store $store
     * @return Collection
     */
    public function getFormattedAttendanceInfo(Collection $users, BusinessDate $businessDate, Store $store): Collection
    {
        $formattedUsers = collect();
        foreach ($users as $key => $user) {
            $formattedUser = [];
            $formattedUser['id'] = $user->id;
            $formattedUser['display_name'] = $user->display_name;

            // ユーザーの属するロール取得
            $storeRoles = $this->roleRepo->getUserStoreRoles($user, $store->id);
            foreach ($storeRoles as $roleKey => $storeRole) {
                $formattedUser['roles'][$roleKey]['id'] = $storeRole->role->id;
                $formattedUser['roles'][$roleKey]['name'] = $storeRole->role->name;
            }

            // 勤退情報取得
            $attendance = $this->attendanceRepo->getStoreUserAttendance(
                $user,
                $businessDate
            );

            // attendance情報なしの場合
            if (is_null($attendance)) {
                $formattedUser['attendance']['working_start_at_hh'] = null;
                $formattedUser['attendance']['working_start_at_mm'] = null;
                $formattedUser['attendance']['working_end_at_hh'] = null;
                $formattedUser['attendance']['working_end_at_mm'] = null;
                $formattedUser['attendance']['working_start_at'] = null;
                $formattedUser['attendance']['working_end_at'] = null;
                $formattedUser['attendance']['break_total_minute'] = null;
                $formattedUsers->push($formattedUser);
                continue;
            }

            // attendance情報ありの場合
            $formattedUser['attendance']['working_start_at'] = $attendance->working_start_at;
            $formattedUser['attendance']['working_end_at'] = $attendance->working_end_at;

            $formattedUser['attendance']['working_start_at_hh'] =
                $attendance->working_start_at
                ? TimeUtility::getBusinessDateBasedHour36hFormat(
                    $businessDate,
                    $attendance->working_start_at
                )
                : null;

            $formattedUser['attendance']['working_start_at_mm'] =
                $attendance->working_start_at
                ? date('i', strtotime($attendance->working_start_at))
                : null;

            $formattedUser['attendance']['working_end_at_hh'] =
                $attendance->working_end_at
                ? TimeUtility::getBusinessDateBasedHour36hFormat(
                    $businessDate,
                    $attendance->working_end_at
                )
                : null;

            $formattedUser['attendance']['working_end_at_mm'] =
                $attendance->working_end_at
                ? date('i', strtotime($attendance->working_end_at))
                : null;

            $formattedUser['attendance']['break_total_minute'] = $attendance->break_total_minute;

            $formattedUser['attendance']['late_total_minute'] = $attendance->late_total_minute;

            if ($attendance->absence) {
                $formattedUser['attendance']['tardy_absence_type'] = self::TARDY_ABSENCE_TYPE['ABSENCE'];
            } else if ($attendance->unauthorized_absence) {
                $formattedUser['attendance']['tardy_absence_type'] = self::TARDY_ABSENCE_TYPE['UNAUTHORIZED_ABSENCE'];
            } else {
                $formattedUser['attendance']['tardy_absence_type'] = self::TARDY_ABSENCE_TYPE['TARDY'];
            }

            $formattedUser['attendance']['payment_amount'] = $attendance->payment_amount;
            $formattedUser['attendance']['payment_type'] = $attendance->payment_type;
            $formattedUser['attendance']['payment_source'] = $attendance->payment_source;


            $formattedUsers->push($formattedUser);
        }

        return $formattedUsers;
    }
}
