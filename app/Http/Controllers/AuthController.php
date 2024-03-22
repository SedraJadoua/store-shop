<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\emailLoginRequest;
use App\Http\Requests\Auth\loginRequest;
use App\Http\Requests\Auth\registerRequest;
use App\Http\Requests\Auth\updateAccountRequest;
use App\Http\Requests\Auth\userNameLoginRequest;
use App\Models\account;
use App\Models\manger;
use App\Models\User;
use App\Trait\ResponseJson;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    use ResponseJson;
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'login_email', 'login_userName', 'register']]);
    }

    public function login(loginRequest $request)
    {
        $data = $request->validated();
        $account_email = account::where('email', $data['info'])->first();
        $account_userName = account::where('userName', $data['info'])->first();

        if ($account_email) {
            return $this->check($data, $account_email);
        } else if ($account_userName) {
            return $this->check($data, $account_userName);
        }
        return $this->returnError('something went wrong ');
    }

    public function login_email(emailLoginRequest $request)
    {
        $data = $request->validated();
        $account = account::where('email', $data['email'])->first();
        return $this->check($data, $account);
    }
    public function login_userName(userNameLoginRequest $request)
    {
        $data = $request->validated();
        $account = account::where('userName', $data['userName'])->first();
        return $this->check($data, $account);
    }

    protected function check($data, $account)
    {
        if (Hash::check($data['password'], $account->password)) {
            if ($account->type == 1) {
                $manger = manger::with('store')->where('account_id', $account->id)->first();
                if ($manger) {
                    $token = auth('api')->login($account);
                    $manger->token = $token;
                    return $this->sendResponse($manger, 'User Login Successfully ');
                }
            } else {
                $user = User::where('account_id', $account->id)->first();
                if ($user) {
                    $token = auth('api')->login($account);
                    $user->token = $token;
                    return $this->sendResponse($user, 'User Login Successfully ');
                }
            }
        }
        return $this->returnError('something went wrong ');
    }

    public function register(registerRequest $request)
    {
        $data = $request->validated();
        $account = new account();
        $account->email = $data['email'];
        $account->password = Hash::make($data['password']);
        $account->type = $data['type'];
        $account->userName = $data['userName'];
        $result = $account->save();

        if ($result) {
            $token =  auth('api')->login($account);
            $account->token = $token;
            return $this->returnSuccessMessage('account register successfully ', $account);
        }
        return $this->returnError('something went wrong , please try again');
    }

    public function profile()
    {
        return $this->sendResponse(auth()->user());
    }
    public function update(updateAccountRequest $request, $id)
    {

        $account = account::where('id', $id)->update([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
            'userName' => $request->userName,
        ]);
        if ($account) {
            $account = account::where('id', $id)->first();
            return $this->returnSuccessMessage('updated successfully', $account);
        }
        return $this->returnError('something went wrong , please try again');
    }

    public function logout()
    {
        Auth('api')->logout();
        return $this->sendResponse(auth()->user(), 'Successfully logged out');
    }
}
