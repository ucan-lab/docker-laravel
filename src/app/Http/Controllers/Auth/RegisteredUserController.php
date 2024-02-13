<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Repositories\{
    UserRepository\UserRepositoryInterface,
};
use App\Services\{
    RegisteredUserService\RegisteredUserServiceInterface,
};

class RegisteredUserController extends Controller
{
    public function __construct(
        public readonly UserRepositoryInterface $userRepo,
        public readonly RegisteredUserServiceInterface $registeredUserServ
    ) {
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        try {
            $validationResult = $request->validate([
                'group_name' => ['required', 'string', 'max:255'],
                'display_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
        } catch (\Throwable $th) {
            return response([
                'status' => 'failure',
                'errors' => [$th->getMessage()]
            ], 400);
        }

        // トランザクションを開始する
        DB::beginTransaction();
        try {
            $user = $this->userRepo->createUser([
                'display_name' => $request->display_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $this->registeredUserServ->registerContractUser($user, $request->group_name);

            DB::commit();
        } catch (\Throwable $e) {
            // 例外が発生した場合はロールバックする
            DB::rollback();
            throw $e;
        }

        event(new Registered($user));

        Auth::login($user);

        return response([
            'status' => 'success',
        ], 200);
    }
}
