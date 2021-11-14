<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsersController extends Controller
{

    public function index(Request $request)
    {
        return Inertia::render('Admin/Users', [
            'users' => User::all(),
            'users_count' => User::count(),
        ]);
    }

    public function show(Request $request, User $user)
    {

        return Inertia::render('Admin/Users/Show', [
            'userData' => $user,
        ]);
    }

}
