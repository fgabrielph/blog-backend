<?php

namespace App\Http\Controllers;

class LogoutController extends Controller
{
    public function __invoke()
    {
        auth()->user()->tokens()->delete();

        return 'Logged out successfully';
    }
}
