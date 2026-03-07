<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    // Muestra la lista de todos los usuarios 📋
    public function index()
    {
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    // Muestra el formulario para crear un nuevo usuario ✨
    public function create()
    {
        return view('usuarios.create');
    }

    // Guarda el nuevo usuario 💾
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name . ' ' . $request->apellidos,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'asistente', 
        ]);

        return redirect()->route('usuarios.index')->with('success', '¡Usuario creado con éxito!');
    }

    // Muestra los detalles 🔍
    public function show(User $usuario)
    {
        return view('usuarios.show', compact('usuario'));
    }

    // CORREGIDO: Ahora muestra la vista de edición ✏️
    public function edit(User $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    // CORREGIDO: Lógica de actualización 🔄
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
            'password' => 'nullable|string|min:8|confirmed', // nullable permite que sea opcional
        ]);

        // Actualización de datos básicos
        $usuario->name = $request->name;
        $usuario->email = $request->email;

        // Solo actualizamos la clave si el usuario escribió algo
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', '¡Usuario actualizado correctamente!');
    }

    // Eliminar usuario 🗑️
    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado del sistema.');
    }
}