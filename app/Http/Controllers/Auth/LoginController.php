<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8',
        ]);

        if (RateLimiter::tooManyAttempts($throttleKey = $this->getThrottleKey($request), 5)) {
            event(new Lockout($request));

            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'email' => [trans('auth.throttle', ['seconds' => $seconds])],
            ]);
        }

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            RateLimiter::hit($throttleKey);

            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        RateLimiter::clear($throttleKey);

        $token = JWTAuth::fromUser(Auth::user());

        return response()->json([
            'user' => Auth::user(),
            'token' => $token,
        ]);

    }




    /**
     * Get the throttle key for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function getThrottleKey(Request $request)
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }


    public function logout(Request $request)
    {
        $authHeader = $request->header('Authorization');
        if (!$authHeader) {
            return response()->json(['message' => 'No authorization header provided'], 401);
        }

        $token = str_replace('Bearer ', '', $authHeader);
        if (!$token) {
            return response()->json(['message' => 'No token provided'], 401);
        }

        try {
            JWTAuth::setToken($token); // Set the token first
            if (!JWTAuth::check()) { // Then check its validity
                return response()->json(['message' => 'Invalid token'], 401);
            }

            JWTAuth::invalidate($token); // Invalidate the token
            return response()->json(['message' => 'User successfully logged out']);
        } catch (JWTException $e) {
            return response()->json(['message' => 'Failed to logout, please try again.', 'error' => $e->getMessage()], 500);
        }
    }

}