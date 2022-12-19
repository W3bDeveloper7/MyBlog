<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
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
        $row = User::where(function ($q) use ($username) {
            $q->where('username', $username);
        })->first();
        if ($row) {
            if ($row->status == 0) {
                return redirect()->back()->with('message', 'Your account has been disabled, get in touch with Admin');
            }
            //check device uuid
            if (!empty($row->fingerprint) && $request->fingerprint() !== $row->fingerprint) {
                return redirect()->back()->with('message',
                    'Please Login from your verified device, login limited by one device');
            }

            if (Hash::check($request->password, $row->password)) {
                if (empty($row->fingerprint)) {
                    $row->fingerprint = $request->fingerprint();
                    $row->save();
                }
                auth()->login($row, $request->remember);

                return redirect()->intended('/');
            }
        }

        return redirect()->back()->with('message', 'Error Your Credential is Wrong');
    }

    public function logout()
    {
        auth()->logout();

        return back();
    }
}
