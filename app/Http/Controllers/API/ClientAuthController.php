<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class ClientAuthController extends Controller
{
    use HasApiTokens;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:clients',
            'email' => 'required|string|email|max:255|unique:clients',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $client = Client::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Client registered successfully'], 201);
    }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'username' => 'required|string',
    //         'password' => 'required|string',
    //     ]);

    //     $client = Client::where('username', $request->username)->first();

    //     if (!$client || !Hash::check($request->password, $client->password)) {
    //         return response()->json(['message' => 'Invalid credentials'], 401);
    //     }

    //     $token = $client->createToken('client')->accessToken;

    //     return response()->json(['token' => $token,'user'=>$client], 200);
    // }

    public function login(Request $request)
    {
        // Rate limiting to prevent brute force attacks
        $rateLimitResponse = $this->rateLimit($request);
        if ($rateLimitResponse) {
            return $rateLimitResponse;
        }

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->all()
            ], 400);
        }

        $client = Client::where('username', $request->username)->first();

        if (!$client || !Hash::check($request->password, $client->password)) {
            // Log the failed login attempt
            Log::warning('Failed login attempt', ['username' => $request->username]);

            // Increment rate limiter
            RateLimiter::hit($this->throttleKey($request));

            // Check if rate limit is exceeded
            $rateLimitResponse = $this->rateLimit($request);
            if ($rateLimitResponse) {
                return $rateLimitResponse;
            }

            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        if ($client->status === 0) {
            return response()->json(['message' => 'User is Deactivated'], 403);
        }

        // Clear rate limiter on successful login
        RateLimiter::clear($this->throttleKey($request));

        $token = $client->createToken('client')->accessToken;

        return response()->json(['token' => $token, 'user' => $client], 200);
    }


    protected function rateLimit(Request $request)
    {
        $key = $this->throttleKey($request);
        if (RateLimiter::tooManyAttempts($key, 5)) {
            // Return JSON response with 429 status code (Too Many Requests)
            return response()->json([
                'message' => 'Too many login attempts. Please try again in ' . RateLimiter::availableIn($key) . ' seconds.'
            ], 429);
        }
    }


protected function throttleKey(Request $request)
{
    return strtolower($request->input('username')).'|'.$request->ip();
}

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
