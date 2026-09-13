<?php
namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) : RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ],[
            'email.required' => 'Email é obrigatório',
            'email.email' => 'Email inválido',
            'password.required' => 'Senha é obrigatória',
        ]);

        if (! Auth::attempt($credentials)) {
            return back()
                ->withErrors(['error' => 'Usuário ou senha invalidos.',])
                ->withInput($request->except('password'));
        }

        $request->session()->regenerate();
        Auth::user()->update(['last_login_at' => Carbon::now()]);
        return redirect()->intended(route('home'));
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
