<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function show($id = null)
    {
        $user = $id ? User::findOrFail($id) : Auth::user();
        return view('user.profile', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|string|email|unique:users,email,'.$user->id,
            'bio'    => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')
                ->storeAs('images/avatars', $user->id.'.'.$request->avatar->extension(), 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);

        return redirect()->route('user.profile')
            ->with('success','Perfil actualizado correctamente.');
    }

    public function updateRole(Request $request, \App\Models\User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:user,editor,admin',
        ]);

        $user->role = $validated['role'];
        $user->save();
        return redirect()->back()->with('success', 'Rol actualizado correctamente.');
    }

}
