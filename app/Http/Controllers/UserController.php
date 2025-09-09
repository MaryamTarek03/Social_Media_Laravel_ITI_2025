<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(30);
        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('profile.show', compact('user'));
    }
}
