<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => __('auth.bad_credentials')])->onlyInput('email');
        }

        // Auth::attempt() only checks email/password — it has no idea about our
        // own is_active flag. Without this, the admin "Suspend" button flips a
        // database column that nothing ever actually enforces.
        if (! Auth::user()->is_active) {
            Auth::logout();

            return back()->withErrors(['email' => __('auth.account_suspended')])->onlyInput('email');
        }

        $request->session()->regenerate();
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect()->intended(route('admin.dashboard'));
        }

        if ($user->hasRole('service_provider')) {
            return redirect()->intended(route('provider.dashboard'));
        }

        // Customers have no back-office dashboard — they browse the public site.
        return redirect()->intended(route('home'));
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
