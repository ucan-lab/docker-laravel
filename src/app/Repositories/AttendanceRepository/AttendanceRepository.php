<?php

namespace App\Repositories\AttendanceRepository;

use App\Models\{
    Attendance,
    BusinessDate,
    User,
};
use Illuminate\Support\Collection;

class AttendanceRepository implements AttendanceRepositoryInterface
{
    private $model;

    public function __construct(Attendance $attendance)
    {
        $this->model = $attendance;
    }

    /***********************************************************
     * Create系
     ***********************************************************/

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * ユーザーに紐づく指定の店舗の勤怠情報を取得
     * @param User $user
     * @param BusinessDate $businessDate
     * @return ?Attendance
     */
    public function getStoreUserAttendance(User $user, BusinessDate $businessDate): ?Attendance
    {
        return $user->attendances()
            ->where('business_date_id', $businessDate->id)
            ->first();
    }

    /**
     * 営業日に紐づく出退勤一覧取得
     * @param BusinessDate $businessDate
     *
     * @return Collection
     */
    public function getBusinessDateAttendances(BusinessDate $businessDate): Collection
    {
        return $this->model->where('business_date_id', $businessDate->id)->get();
    }

    /***********************************************************
     * Update系
     ***********************************************************/
    /**
     * 勤退情報を作成または、更新する
     * @param int $user_id
     * @param int $business_date_id
     * @param array $data
     */
    public function updateOrInsertAttendance(int $user_id, int $business_date_id, array $data)
    {
        $this->model->updateOrInsert(
            [
                'user_id' => $user_id,
                'business_date_id' => $business_date_id
            ],
            [
                ...$data,
                'updated_at' => now(),
            ]
        );
    }

    /***********************************************************
     * Delete系
     ***********************************************************/

    /***********************************************************
     * その他
     ***********************************************************/
}
