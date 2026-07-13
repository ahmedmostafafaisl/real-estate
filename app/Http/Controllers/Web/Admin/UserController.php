<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('user_type', 'customer')
            ->when($request->q, fn ($q, $v) => $q->where('name', 'like', "%{$v}%"))
            ->withCount('favorites')->latest()->paginate(15)->withQueryString();

        return view('admin.users', compact('users'));
    }

    public function toggleActive(User $user)
    {
        $user->update(['is_active' => ! $user->is_active]);
        return back()->with('status', $user->is_active ? 'Account activated.' : 'Account suspended.');
    }
}
