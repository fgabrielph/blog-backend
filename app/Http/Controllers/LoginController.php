<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            return 'Invalid credentials';
        }
        $token = auth()->user()->createToken('API Token')->plainTextToken;

        return $token;
    }
}
