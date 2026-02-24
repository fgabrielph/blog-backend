<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomeRequest;

class HomeController extends Controller
{
    public function index(HomeRequest $request): string
    {
        return 'HO HO';
    }
}
