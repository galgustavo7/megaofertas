<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function showLogin(Request $request): View|RedirectResponse
    {
        if ($request->user() && $request->user()->isSuperUser()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = (bool) $request->boolean('remember');

        if (! auth()->attempt($credentials, $remember)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Credenciales incorrectas. Verifica tu correo y contraseña.']);
        }

        $request->session()->regenerate();

        if (! $request->user()->isSuperUser()) {
            auth()->logout();

            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Esta cuenta no tiene permisos de super usuario.']);
        }

        return redirect()->intended(route('admin.dashboard'))
            ->with('status', 'Sesión iniciada correctamente.');
    }

    public function logout(Request $request): RedirectResponse
    {
        auth()->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('status', 'Sesión cerrada.');
    }
}
