<?php

namespace App\Http\Controllers;

use App\Http\Requests\Attendance\AttendanceRequest;
use App\Http\Requests\StoreIdRequest;
use Illuminate\Support\Facades\DB;
use App\Log\CustomLog;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Repositories\{
    UserRepository\UserRepositoryInterface,
    BusinessDateRepository\BusinessDateRepositoryInterface,
    AttendanceRepository\AttendanceRepositoryInterface,
    RoleRepository\RoleRepositoryInterface,
    StoreRepository\StoreRepositoryInterface,
};
use App\Services\{
    AttendanceService\AttendanceServiceInterface,
};
use Illuminate\Auth\Access\AuthorizationException;


class AttendanceController extends Controller
{
    public function __construct(
        public readonly UserRepositoryInterface $userRepo,
        public readonly BusinessDateRepositoryInterface $businessDateRepo,
        public readonly AttendanceRepositoryInterface $attendanceRepo,
        public readonly RoleRepositoryInterface $roleRepo,
        public readonly StoreRepositoryInterface $storeRepo,

        public readonly AttendanceServiceInterface $attendanceServ,
    ) {
    }

    public function get(StoreIdRequest $request)
    {
        // ストアの取得
        $store = $this->storeRepo->findStore($request->storeId);
        if (is_null($store)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['ストア情報の読み込みができませんでした']
            ], 404);
        }

        // Policy確認
        try {
            $this->authorize('viewAny', [Attendance::class, $store]);
        } catch (AuthorizationException $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['この操作を実行する権限がありません']
            ], 403);
        }

        // 営業日付を取得
        $businessDate = $this->businessDateRepo->getCurrentBusinessDate($store);
        if (!$businessDate) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['営業情報の読み込みができませんでした']
            ], 404);
        }

        // ストアに紐づくユーザー一覧を取得
        $users = $this->userRepo->getStoreUsers($store);

        // ユーザーに紐づく勤怠情報を取得
        $usersWithAttendance = $this->attendanceServ->getFormattedAttendanceInfo($users, $businessDate, $store);

        return response()->json([
            'status' => 'success',
            'data' => [
                'usersWithAttendance' => $usersWithAttendance,
                'store' => $store
            ]
        ], 200);
    }

    public function bulkUpdate(AttendanceRequest $request)
    {
        // ストアの取得
        $store = $this->storeRepo->findStore($request->store_id);
        if (is_null($store)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['ストア情報の読み込みができませんでした']
            ], 404);
        }

        // Policy確認
        try {
            $this->authorize('update', [Attendance::class, $store, $request->store_id]);
        } catch (AuthorizationException $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['この操作を実行する権限がありません']
            ], 403);
        }

        // トランザクションを開始する
        DB::beginTransaction();

        try {
            $this->attendanceServ->updateOrInsertAttendances($request, $store);

            DB::commit();
        } catch (\Throwable $e) {
            // 例外が発生した場合はロールバックする
            DB::rollback();
            // ログの出力
            CustomLog::error($e);

            return response()->json([
                'status' => 'failure',
                'errors' => [$e->getMessage()]
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => []
        ], 200);
    }

    public function updateTardyAbsence(Request $request)
    {
        // ストアの取得
        $store = $this->storeRepo->findStore($request->store_id);
        if (is_null($store)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['ストア情報の読み込みができませんでした']
            ], 404);
        }

        // TODO: Policy確認
        // try {
        //     $this->authorize('update', [Attendance::class, $store, $request->store_id]);
        // } catch (AuthorizationException $e) {
        //     return response()->json([
        //         'status' => 'failure',
        //         'errors' => ['この操作を実行する権限がありません']
        //     ], 403);
        // }

        // トランザクションを開始する
        DB::beginTransaction();

        try {
            $this->attendanceServ->updateOrInsertTardyAbsenceInfo($request, $store);

            DB::commit();
        } catch (\Throwable $e) {
            // 例外が発生した場合はロールバックする
            DB::rollback();
            // ログの出力
            CustomLog::error($e);

            return response()->json([
                'status' => 'failure',
                'errors' => [$e->getMessage()]
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => []
        ], 200);
    }

    public function updatePayrollPayment(Request $request)
    {
        // ストアの取得
        $store = $this->storeRepo->findStore($request->store_id);
        if (is_null($store)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['ストア情報の読み込みができませんでした']
            ], 404);
        }

        // TODO: Policy確認
        // try {
        //     $this->authorize('update', [Attendance::class, $store, $request->store_id]);
        // } catch (AuthorizationException $e) {
        //     return response()->json([
        //         'status' => 'failure',
        //         'errors' => ['この操作を実行する権限がありません']
        //     ], 403);
        // }

        // トランザクションを開始する
        DB::beginTransaction();

        try {
            $this->attendanceServ->updateOrInsertPayrollPaymentInfo($request, $store);

            DB::commit();
        } catch (\Throwable $e) {
            // 例外が発生した場合はロールバックする
            DB::rollback();
            // ログの出力
            CustomLog::error($e);

            return response()->json([
                'status' => 'failure',
                'errors' => [$e->getMessage()]
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => []
        ], 200);
    }
}
