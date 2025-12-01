<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        // Nếu request muốn nhận JSON (API Login)
        if ($request->wantsJson()) {
            $user = auth()->user();

            // Tạo Sanctum Token
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token, // Trả về token cho client
                'user' => $user,
            ]);
        }

        // Mặc định cho Web (redirect về home)
        return redirect()->intended(config('fortify.home'));
    }
}
