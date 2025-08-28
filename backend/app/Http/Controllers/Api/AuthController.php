<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Usuario;

class AuthController extends Controller
{
    // Registro
    public function register(Request $request)
    {
        $request->validate([
            'empresa' => 'nullable|string|max:255',
            'responsable' => 'nullable|string|max:255',
            'usuario_id' => 'required|string|unique:usuarios,usuario_id',
            'password' => 'required|string|min:6|confirmed', // si usas password_confirmation
        ]);

        $usuario = Usuario::create([
            'empresa' => $request->empresa,
            'responsable' => $request->responsable,
            'usuario_id' => $request->usuario_id,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Usuario registrado', 'usuario' => $usuario], 201);
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|string',
            'password' => 'required|string',
        ]);

        $usuario = Usuario::where('usuario_id', $request->usuario_id)->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        // Si quieres JWT o sesión de Laravel
        Auth::login($usuario);

        return response()->json(['message' => 'Login exitoso', 'usuario' => $usuario]);
    }
}
