<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request):JsonResponse
    {
        $credentials = $request->only('email', 'password');
        if(!$credentials) {
            return response()->json(['error'=>'Invalid credentials.'],422);
        }
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('app-token')->plainTextToken;
            return response()->json(['token'=> $token],200);
        }
        return response()->json(['error'=>'Token could not be created.'],500);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
