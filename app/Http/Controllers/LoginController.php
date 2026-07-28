<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['Invalid email or password.']
            ]);
        }
        $token = auth()->user()->createToken('API Token')->plainTextToken;

        return [
            'token' => $token,
            'user' => auth()->user()
        ];
    }
}
