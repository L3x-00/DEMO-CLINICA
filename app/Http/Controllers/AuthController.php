<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Mostrar formulario de Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Lógica de Inicio de Sesión
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Intentar autenticar con JWT
        if (!$token = auth()->attempt($credentials)) {
            return back()->withErrors(['error' => 'Credenciales inválidas']);
        }

        // Si es correcto, guardamos el token en una cookie o sesión para la web
        // En este caso, para simplificar la muestra, usaremos la sesión de Laravel
        return redirect()->route('pacientes.index')->with('success', 'Bienvenido al sistema');
    }

    // Mostrar formulario de Registro
    public function showRegister()
    {
        return view('auth.register');
    }

    // Lógica de Registro
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Usuario registrado, ya puedes iniciar sesión');
    }

    // Cerrar Sesión
    public function logout()
    {
    // Esto limpia la sesión de Laravel y el token de JWT
    auth()->logout();
    
    // Invalida la sesión actual en el navegador
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
    }
}