<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseResponseController;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseResponseController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function login(Request $request): Response
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('phone', 'password');
        Auth::attempt($credentials);
        $user = Auth::user();
        $token = $user->createToken('authToken');
        if (!$token->accessToken) {
            return $this->responseUnAuthorize();
        }
        return $this->responseToken($token);
    }

    public function register(Request $request): Response
    {
        $request->validate([
            'phone' => 'required|unique:users,phone',
            'email' => 'required|unique:users,email',
            'nick_name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
//        $inputValues['phone'] = $request->phone;
//        $inputValues['email'] = $request->email;
        // checking if email exists in ‘email’ in the ‘users’ table
//        $rules = array(
//            'phone' => 'unique:users,phone',
//            'email' => 'unique:users,email',
//        );
//        $validator = Validator::make($inputValues, $rules);
//
//        if ($validator->fails()) {
//            return Response(['Message' => 'The phone already exists'], 200);
//        }
        $user = User::create([
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'nick_name' => $request->nick_name,
            'email' => $request->email ?? '',
            'referral' => $request->referral_code,
        ]);
        $token = $user->createToken('authToken');
        return $this->responseToken($token);
    }

    public function logout(): Response
    {
        $user = Auth::user()->token();
        $user->revoke();
        return $this->responseSuccess(null);
    }

    public function refresh(): Response
    {
        return $this->responseToken(auth('api')->refresh());
    }
    protected function responseToken($token): Response
    {
        $data = [
            'Authorization' => [
                'access_token' => $token->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($token->token->expires_at)->toDateString(),
            ]
        ];
        return $this->responseSuccess($data, 0, 201);
    }

}
