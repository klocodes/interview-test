<?php

namespace App\Http\Controllers;

use App\Features\Auth\Login;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class AuthController extends Controller
{
    public function signIn(): Response
    {
        return Inertia::render('SignIn');
    }

    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $request, Login $login): JsonResponse
    {
        $user = $login($request->getDto());

        return response()->json([
            'user' => $user,
        ]);
    }

    public function logout(): void
    {
        Auth::logout();
    }
}
