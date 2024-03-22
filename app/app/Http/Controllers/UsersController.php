<?php

namespace App\Http\Controllers;

use App\Features\Balance\FetchCurrentBalance;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function getAuthUser(): ?Authenticatable
    {
        return Auth::user();
    }

    public function balance(FetchCurrentBalance $fetchCurrentBalance): JsonResponse
    {
        $balance = $fetchCurrentBalance(Auth::id());

        return response()->json(compact('balance'));
    }
}
