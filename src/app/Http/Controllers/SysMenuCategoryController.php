<?php

namespace App\Http\Controllers;

use App\Models\SysMenuCategory;

class SysMenuCategoryController extends Controller
{
    public function getAll()
    {
        return response()->json([
            'status' => 'success',
            'data' => SysMenuCategory::get()
        ], 200);
    }
}
