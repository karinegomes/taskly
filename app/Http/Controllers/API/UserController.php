<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserDropdownResource;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = UserDropdownResource::collection(User::orderBy('name')->get());

        return $users;
    }
}
