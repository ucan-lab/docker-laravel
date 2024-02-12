<?php

namespace App\Services\AttendanceService;

use Illuminate\Support\{
    Collection,
    Carbon,
};
use App\Models\{
    Attendance,
    BusinessDate,
    Store
};

interface AttendanceServiceInterface
{
    /**
     * 勤退情報を一括登録する
     *
     */
    public function updateOrInsertAttendances($request, $store);

    /**
     * 遅刻欠勤情報を登録する
     * @param $request
     * @param Store $store
     */
    public function updateOrInsertTardyAbsenceInfo($request, Store $store);

    /**
     * 現金支給情報を登録する
     * @param $request
     * @param Store $store
     */
    public function updateOrInsertPayrollPaymentInfo($request, Store $store);

    /**
     * 出退勤登録向けに整形した勤退情報を取得
     * @param Collection $users
     * @param BusinessDate $businessDate
     * @param Store $store
     * @return Collection
     */
    public function getFormattedAttendanceInfo(Collection $users, BusinessDate $businessDate, Store $store): Collection;
}
