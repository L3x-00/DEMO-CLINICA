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

        // Al usar ->with() enviamos variables "Flash" a la sesión
        // Estas variables solo duran UNA carga de página (ideal para el Splash Screen)
        return redirect()->route('home')
            ->with('success', 'Bienvenido al sistema')
            ->with('mostrar_bienvenida', true);
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