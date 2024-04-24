<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        try {
            $request->authenticate();

            $user = $request->user();
            $token = $user->createToken('token-name')->plainTextToken;
            return response()->json(['token' => $token, 'message' => 'Inicio de sesión exitoso', 'role' => 'Admin']);
        } catch (\Throwable $e) {
            Log::error('Error durante el inicio de sesión: ' . $e->getMessage());
            return response()->json(['message' => 'Correo electrónico o contraseña incorrectos. Por favor, verifica tus credenciales.'], 401);
        }
        
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        try {
            if ($request->user()) {
                $request->user()->tokens()->delete();
                Auth::guard('web')->logout();
                return response()->json(['message' => 'Cierre de sesión exitoso']);
            } else {
                return response()->json(['message' => 'Usuario no autenticado'], 401);
            }
        } catch (\Exception $e) {
            Log::error('Error durante el logout: ' . $e->getMessage());
            return response()->json(['message' => 'Error durante el logout'], 500);
        }
    }
}
