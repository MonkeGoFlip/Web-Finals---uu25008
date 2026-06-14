<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }
        $users = User::all();
        return view('admin.index', compact('users'));
    }

    public function toggleBlock(User $user)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot block yourself.');
        }
        $user->update([
            'is_blocked' => !$user->is_blocked
        ]);

        return back();
    }
}