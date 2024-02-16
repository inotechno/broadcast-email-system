<?php

namespace App\Actions;

use App\Models\Company;
use App\Models\Recruiter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Login
{
    public function handle($request)
    {
        $remember_me = $request['remember_me'] ? true : false;
        // return $remember_me;

        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']], $remember_me)) {
            session()->regenerate();
            return true;
        } else {
            return false;
        }
    }
}
