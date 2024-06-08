<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

use Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request)
    {
      $rules=[
            'email' => 'required',
            'password' => 'required',
        ];

        $validated = Validator::make($request->all(),$rules);
        if ($validated->fails()){
            return $validated->errors();
        }



        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('auth')->accessToken;
                $response = ['token' => $token,'user'=>$user];
                // Auth::setUser($user);
                Auth::guard('apigaurd')->setUser($user);

                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'User does not exist'];
            return response($response, 422);
        }
    }

 
}
