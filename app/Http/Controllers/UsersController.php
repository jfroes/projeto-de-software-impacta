<?php

namespace App\Http\Controllers;

use App\Mail\NewUserConfirmation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->must_change_password = true;
        $user->status = 'inativo';
        $user->token = Str::random(64);

        $confirmationLink = route('users.confirm', ['token' => $user->token]);

        $result = Mail::to($user->email)->send(new NewUserConfirmation($user->name, $confirmationLink));

        if(! $result) {
            return back()->withInput()->with([
                'server_error' => 'Erro ao enviar o e-mail de confirmação.',
                ]);
        }

        $user->save();
        return view('auth.email-sent', ['user' => $user]);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required',
            'status' => 'required',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->status = $request->status;

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:8',
            ]);
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso.');
    }


    public function show(User $user)
    {
        return view('admin.delete', compact('user'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (Auth::id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'Você não pode deletar seu próprio usuário.');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuário deletado com sucesso.');
    }
}
