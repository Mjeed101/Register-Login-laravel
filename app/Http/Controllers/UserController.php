<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // return json file for all users
        $users = User::all();
        return response()->json($users);
    }
}
