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
        $usuarios = User::all(); // Traemos a todos para la tabla
        return view('usuarios.index', compact('usuarios'));
    }

    // Muestra el formulario para crear un nuevo usuario ✨
    public function create()
    {
        return view('usuarios.create');
    }

    // Guarda el nuevo usuario (tu código original) 💾
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

    // Muestra los detalles de un usuario específico 🔍
    public function show(User $usuario)
    {
        return view('usuarios.show', compact('usuario'));
    }

    // Muestra el formulario para editar ✏️
    public function edit(User $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    // Actualiza los datos en la base de datos 🔄
    public function update(Request $request, User $usuario)
    {
        // Aquí irá la lógica de actualización que haremos luego
    }
    // Opcional: Para eliminar un asistente si el Doctor lo decide 🗑️
    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado del sistema.');
    }
}