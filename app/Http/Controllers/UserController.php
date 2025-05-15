<?php

// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Mostrar perfil
    public function show()
    {
        return view('user.profile');
    }

    // Mostrar formulario para editar perfil
    public function edit()
    {
        return view('user.edit');
    }

    // Actualizar perfil
    public function update(Request $request, User $user)
    {
        // Asegúrate de que solo el usuario que está logueado pueda editar su perfil
        if ($user->id != Auth::id()) {
            abort(403);
        }

        // Validar los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'bio' => 'nullable|string|max:1000',
        ]);

        // Actualizar los campos
        $user->update($request->all());

        // Redirigir con mensaje de éxito
        return redirect()->route('user.profile')->with('success', 'Perfil actualizado correctamente.');
    }
}
