<?php


namespace App\Services\Auth;


use App\Enums\UserRoles;
use App\Enums\UserStatus;
use App\Models\PasswordReset;
use App\Models\User;
use App\Models\UserDetail;
use App\Services\BaseService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;



class AuthService extends BaseService
{
    public function createUser($data, $autoVerified = false)
    {
        $user = new User();
        $user->fill($data);
        $user->password = Hash::make($data['password']);
        $user->email_verified_at = Carbon::now();
        $user->save();

        return $user;
    }


    public function getProfile()
    {
        $id = auth()->id();
        return User::where('id', $id)->first();
    }

    public function allProfile()
    {
        return User::all();
    }
}
