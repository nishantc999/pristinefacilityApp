<?php

namespace App\Http\Controllers\API\UserAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class UserAuthController extends Controller
{
    use HasApiTokens;





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

        $user = User::where('username', $request->username)->first();
        if($user->role->role_type==1|| $user->role_id==0){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        if (!$user || !Hash::check($request->password, $user->password)) {
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
        if ($user->status === 0) {
            return response()->json(['message' => 'User is Deactivated'], 403);
        }

        // Clear rate limiter on successful login
        RateLimiter::clear($this->throttleKey($request));
        $token = $user->createToken('user')->accessToken;
  
     
        Auth::guard('userapi')->setUser($user);
        return response()->json(['token' => $token, 'user' => $user], 200);
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
