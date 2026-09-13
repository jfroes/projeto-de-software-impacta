<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authenticate(Request $request) : RedirectResponse
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

    public function logout()
    {
        session()->invalidate();
        session()->regenerateToken();
        Auth::logout();
        return redirect()->route('login');
    }

    public function newUserConfirmation(Request $request, $token){
        $user = User::where('token', $token)->first();

        if (! $user) {
            return redirect()->route('login');
        }

        $user->email_verified_at = now();
        $user->token = null;
        $user->status = 'ativo';
        $user->save();

        Auth::login($user);

        return view('auth.new-user-confirmation', ['user' => $user]);
    }

    public function changePassword()
    {
        return view('auth.change-password');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ],[
            'password.required' => 'Senha é obrigatória',
            'password.min' => 'Senha deve ter no mínimo 8 caracteres',
            'password.confirmed' => 'As senhas não coincidem',
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->must_change_password = false;
        $user->save();

        return redirect()->route('home')->with('success', 'Senha alterada com sucesso.');
    }

}
