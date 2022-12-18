<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function getLogin()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $username = $request->username;
        $row = User::where(function ($q) use ($username){
            $q->where('username',$username);
        })->first();
        if ($row)
        {
            if ($row->status == 0)
            {
                return redirect()->back()->with('message','Your Account Is DisActive Back To Admin');
            }
            if (Hash::check($request->password,$row->password))
            {
                auth()->login($row,$request->remember);
                if(!auth()->user()->isAdmin()){
                    Auth::logoutOtherDevices($request->password);
                }
                return redirect()->intended('/');
            }
        }
        return redirect()->back()->with('message','Error Your Credential is Wrong');
    }

    public function getRegister()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->all());
        if ($user)
        {
            auth()->login($user);
            return redirect()->intended('/home');
        }
        return redirect()->back()->with('message','Error Happen try Again');
    }

    public function logout()
    {
        auth()->logout();
        return back();
    }
}
