<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetController extends Controller
{
    public function get()
    {
        return ['data' => 'get'];
    }

    public function user()
    {

    }

    public function login(Request $request)
    {

        if (!\Auth::attempt($request->input())) {
            return response()->json(['message' => $request->user()], 401);
        }
        /** @var User $user */
        $user = $request->user();
        $token = $user->createToken('api')->plainTextToken;
        return ['user' => \Auth::user(), 'token' => $token];
    }
}
