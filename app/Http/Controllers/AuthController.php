<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    private $auth;

    public function __construct(AuthService $authService)
    {
        $this->auth = $authService;
    }


    public function register(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required | regex:/^[\pL\s\-]+$/u',
                    'email' => 'required|string|email|unique:users|max:255',
                    'password' => 'required|string|min:6|confirmed',
                    'password_confirmation' => 'required|string|min:6'
                ]
            );

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors(),'status_code' => 400]);
            }

            
            $user = $this->auth->createUser($request->all());

            DB::commit();
        
            if (isset($user) && !empty($user)) {
                return response()->json(['success' => $user,'status_code' => 200]);
            }

                      
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage(),'status_code' => 400]);
        }
    }

    

    public function login(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return response()->json(['error' => __('User not found !'),'status_code' => 401]);
        }

        if($user && !Hash::check($request->password,$user->password)) {
            return response()->json(['error' => __('Email or password is not matched!'),'status_code' => 401]);
        }

        return response()->json(['success' => $user,'status_code' => 200]);
    }



    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->flush();

        return redirect()->route('login.form');
    }

   
    public function myProfile() 
    {
        return $this->auth->getProfile();
    }
    public function allProfile()
    {
        return $this->auth->allProfile();
    }
}
