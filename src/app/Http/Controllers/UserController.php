<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function get(Request $request)
    {
        // if文はサンプルで実装しただけで本来不要
        // if ($request->user()) {
        //     $userModel = new User();
        //     $user = $userModel->find($request->user()->id);

        //     if ($user) {
        //         return response()->json([
        //             'message' => 'User found successfully.',
        //             'data' => $user
        //         ], 200); // HTTP ステータスコード 200
        //     }

        //     // ユーザーが見つからなかった場合
        //     return response()->json([
        //         'message' => 'User not found.'
        //     ], 404); // HTTP ステータスコード 404
        // }

        return $request->user();
    }
}
