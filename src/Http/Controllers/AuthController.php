<?php

namespace Mysic\LaravelAdminApization\Http\Controllers;

use Mysic\LaravelAdminApization\ResponseMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Encore\Admin\Controllers\AuthController as ParentAuthController;

class AuthController extends ParentAuthController
{
    use ResponseMessage;

    public function postLogin(Request $request)
    {
        $rules = [
            $this->username() => 'required',
            'password' => 'required',
        ];

        $validResult = Validator::make($request->post(), $rules, []);
        if($validResult->fails()) {
            return $this->error([],implode(',',$validResult->messages()->all()));
        }
        $credentials = $request->only([$this->username(), 'password']);
        $remember = $request->get('remember', false);

        if ($this->guard()->attempt($credentials, $remember)) {
            return $this->success();
        }
        return $this->error();
    }

    public function getLogout(Request $request)
    {
        $this->guard()->logout();
        if($request->session()->invalidate()) {
            return $this->success();
        }
        return $this->error();
    }

}
