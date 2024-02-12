<?php

namespace App\Services\StoreSalesService;

use App\Services\StoreSalesService\StoreSalesServiceInterface;
use App\Models\{
    Attendance,
    Store,
    BusinessDate
};
use App\Repositories\{
    BillRepository\BillRepositoryInterface,
    BillPaymentRepository\BillPaymentRepositoryInterface,
    PaymentMethodRepository\PaymentMethodRepositoryInterface,
    NumberOfCustomerRepository\NumberOfCustomerRepositoryInterface,
    RoleRepository\RoleRepositoryInterface,
    AttendanceRepository\AttendanceRepositoryInterface,
    UserRepository\UserRepositoryInterface,
    CashRegisterRepository\CashRegisterRepositoryInterface
};
use Illuminate\Support\Collection;

class StoreSalesService implements StoreSalesServiceInterface
{
    public function __construct(
        public readonly BillRepositoryInterface $billRepo,
        public readonly BillPaymentRepositoryInterface $billPaymentRepo,
        public readonly PaymentMethodRepositoryInterface $paymentMethodRepo,
        public readonly NumberOfCustomerRepositoryInterface $numberOfCustomerRepo,
        public readonly RoleRepositoryInterface $roleRepo,
        public readonly UserRepositoryInterface $userRepo,
        public readonly AttendanceRepositoryInterface $attendanceRepo,
        public readonly CashRegisterRepositoryInterface $cashRegisterRepo,
    ) {
    }

    /**
     * @param Store $store
     * @param BusinessDate $businessDate
     * @return
     */
    public function getBusinessDayReport(Store $store, BusinessDate $businessDate)
    {
        // 伝票
        $bills = $this->billRepo->getBusinessDateBills($store, $businessDate);

        // 合計売上と支払い種別ごとの売上
        $businessDaySales = $this->getBusinessDaySales($store, $bills);

        // 客数
        $numberOfCustomers = $this->numberOfCustomerRepo->getBillsNumberOfCustomer($bills->pluck('id')->toArray());

        // 客単価
        $averageRevenuePerCustomer = $this->getAverageRevenuePerCustomer($businessDaySales['totalSalesAmount'], $numberOfCustomers);

        // ロール別出勤者数を取得
        $userAttendanceNumberByRole = $this->getUserAttendanceNumberByRole($store, $businessDate);

        // 前渡し、全額日払いの取得
        $fullDayAndAdvancePayment = $this->getBusinessDateFullDayAndAdvancePayment($store, $businessDate);

        // 釣り銭
        $cashAtOpening = $this->cashRegisterRepo->getBusinessDateCashRegister($businessDate)->cash_at_opening;

        return [
            'businessDaySales' => $businessDaySales,
            'numberOfCustomers' => $numberOfCustomers,
            'averageRevenuePerCustomer' => $averageRevenuePerCustomer,
            'userAttendanceNumberByRole' => $userAttendanceNumberByRole,
            'fullDayAndAdvancePayment' => $fullDayAndAdvancePayment,
            'cashAtOpening' => $cashAtOpening,
        ];
    }

    private function getBusinessDaySales(Store $store, ?Collection $bills)
    {
        // 売上
        $totalSalesAmount = 0;

        if (is_null($bills)) {
            return [
                'totalSalesAmount' => $totalSalesAmount,
                'paymentMethodsSalesTotalAmountList' => []
            ];
        }

        // 支払い種別
        $paymentMethods = $this->paymentMethodRepo->getStorePaymentMethods($store);

        // 支払い種別ごとの売上金
        $paymentMethodsSalesTotalAmountList = [];
        foreach ($paymentMethods as $paymentMethod) {
            $paymentMethodsSalesTotalAmountList[$paymentMethod->id] = [
                'sysPaymentMethodCategoryId' => $paymentMethod->sys_payment_method_category_id,
                'name' => $paymentMethod->name,
                'totalAmount' => 0
            ];
        }

        foreach ($bills as $bill) {
            $billPayments = $this->billPaymentRepo->getBillPayments($bill);
            foreach ($billPayments as $billPayment) {
                // 売上
                $totalSalesAmount += $billPayment->total_amount;

                // 支払い種別ごとの売上金
                $paymentMethodsSalesTotalAmountList[$billPayment->payment_method_id]['totalAmount'] += $billPayment->total_amount;
            }
        }

        return [
            'totalSalesAmount' => $totalSalesAmount,
            'paymentMethodsSalesTotalAmountList' => $paymentMethodsSalesTotalAmountList
        ];
    }

    private function getAverageRevenuePerCustomer($totalSalesAmount, $numberOfCustomers)
    {
        if ($numberOfCustomers === 0) {
            return 0;
        }

        return (int) floor($totalSalesAmount / $numberOfCustomers);
    }

    private function getUserAttendanceNumberByRole(Store $store, BusinessDate $businessDate)
    {
        // 店舗に属するストアロール一覧を取得
        $storeRoles = $this->roleRepo->getStoreRolesByStore($store);

        // ロール別出勤者数を取得
        $userAttendanceNumberByRole = [];
        foreach ($storeRoles as $storeRole) {
            // ユーザー一覧取得
            $users = $this->userRepo->getAttendanceUsersByStoreRole($storeRole, $businessDate);

            $userAttendanceNumberByRole[$storeRole->role_id] = [
                'attendanceNumber' => $users->count(),
                'roleName' => $storeRole->role->name,
            ];
        }

        return $userAttendanceNumberByRole;
    }

    private function getBusinessDateFullDayAndAdvancePayment(Store $store, BusinessDate $businessDate)
    {
        // 店舗ごとの出勤情報一覧取得
        $attendances = $this->attendanceRepo->getBusinessDateAttendances($businessDate);

        // 前渡しの総額
        $advancePaymentAmount = [
            'cashRegister' => 0,
            'other' => 0
        ];

        // 全額日払いの総額
        $fullDayPaymentAmount = [
            'cashRegister' => 0,
            'other' => 0
        ];

        foreach ($attendances as $attendance) {
            if ($attendance->payment_type === Attendance::PAYMENT_TYPE['ADVANCE']) {
                if ($attendance->payment_source === Attendance::PAYMENT_SOURCE['CASH_REGISTER']) {
                    $advancePaymentAmount['cashRegister'] += $attendance->payment_amount;
                } else if ($attendance->payment_source === Attendance::PAYMENT_SOURCE['OTHER']) {
                    $advancePaymentAmount['other'] += $attendance->payment_amount;
                }
            } else if ($attendance->payment_type === Attendance::PAYMENT_TYPE['FULL_DAY']) {
                if ($attendance->payment_source === Attendance::PAYMENT_SOURCE['CASH_REGISTER']) {
                    $fullDayPaymentAmount['cashRegister'] += $attendance->payment_amount;
                } else if ($attendance->payment_source === Attendance::PAYMENT_SOURCE['OTHER']) {
                    $fullDayPaymentAmount['other'] += $attendance->payment_amount;
                }
            }
        }

        return [
            'advancePaymentAmount' => $advancePaymentAmount,
            'fullDayPaymentAmount' => $fullDayPaymentAmount
        ];
    }
}
