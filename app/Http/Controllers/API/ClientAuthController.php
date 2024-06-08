<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\HasApiTokens;
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

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $client = Client::where('username', $request->username)->first();

        if (!$client || !Hash::check($request->password, $client->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $client->createToken('client')->accessToken;

        return response()->json(['token' => $token,'user'=>$client], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
