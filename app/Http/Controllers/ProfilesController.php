<?php

namespace App\Http\Controllers;

use App\Mail\NewUserConfirmation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ProfilesController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $user = Auth::user();

        $user->name = $request->name;


        if ($request->filled('current_password', 'password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ],[
                'password.required' => 'Senha é obrigatória',
                'password.min' => 'Senha deve ter no mínimo 8 caracteres',
                'password.confirmed' => 'As senhas não coincidem',
            ]);

            if(! password_verify($request->current_password, Auth::user()->password)) {
                return back()->withErrors(['current_password' => 'Senha atual incorreta.']);
            }

            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso.');
    }

}
