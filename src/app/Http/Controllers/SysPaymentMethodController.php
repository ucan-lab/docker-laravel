<?php

namespace App\Http\Controllers;

use App\Models\SysPaymentMethodCategory;

class SysPaymentMethodController extends Controller
{
    public function getAll()
    {
        return response()->json([
            'status' => 'success',
            'data' => SysPaymentMethodCategory::get()
        ], 200);
    }
}
