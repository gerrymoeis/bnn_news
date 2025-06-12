<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->where('id', '!=', Auth::id())->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function approve(User $user)
    {
        $user->update(['approved_at' => now()]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil disetujui.');
    }

}
