<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getUsers(Request $request) {
        $user = User::all();
        return $user;
    }

    public function createUser(Request $request) {
        $user = User::create([
            "name" => $request->name,
            "nickname" => $request->nickname,
            "email" => $request->email,
            "password" => $request->password,
        ]);
        return $user;
    }
}
