<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1️⃣ Validación
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // 2️⃣ Buscar usuario
        $user = User::where('email', $request->email)->first();

        // 3️⃣ Verificar credenciales
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas.',
                'data' => null,
            ], 401);
        }

        // 4️⃣ Crear token Sanctum
        $token = $user->createToken('api-token')->plainTextToken;

        // 5️⃣ Respuesta estándar PRO
        return response()->json([
            'success' => true,
            'message' => 'Login correcto.',
            'data' => [
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ],
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout correcto.',
            'data' => null,
        ], 200);
    }
}
