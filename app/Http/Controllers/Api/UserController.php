<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(RegisterRequest $requet)
    {
        $validatedData = $requet->validated();

    }   

    
}
