<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class AutenticacionController extends Controller
{
    public function mostrarLogin()
    {
        return view('login');
    }

    public function iniciarSesion(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingrese un correo válido.',
            'password.required' => 'La contraseña es obligatoria.'
        ]);

        $usuario = Usuario::where('correo', $request->email)->first();

        if (!$usuario || !Hash::check($request->password, $usuario->contraseña)) {
            return back()->with('login_error', 'Cuenta no registrada o contraseña incorrecta.');
        }

        // Iniciar sesión solo aquí
        Auth::login($usuario);
        $request->session()->regenerate();

        return match($usuario->rol) {
            'cliente' => redirect()->intended('/panel-cliente'),
            'recepcionista' => redirect()->intended('/panel-recepcionista'),
            default => redirect()->intended('/panel-admin')
        };
    }

    public function registrarCuenta(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,correo',
            'password' => 'required|min:6|confirmed'
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'Ingrese un correo válido.',
            'email.unique' => 'El correo ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'La contraseña y la confirmación no coinciden.'
        ]);

        // Crear el usuario
        Usuario::create([
            'nombre' => $request->name,
            'correo' => $request->email,
            'contraseña' => Hash::make($request->password),
            'rol' => 'cliente',
            'fecha_creacion' => now()
        ]);

        // MEJORA: No iniciamos sesión. Redirigimos al login con mensaje.
        return redirect()->route('login')->with('success', '¡Cuenta creada con éxito! Ahora puedes iniciar sesión.');
    }

    public function cerrarSesion(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}