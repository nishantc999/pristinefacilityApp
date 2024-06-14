<?php

namespace App\Http\Controllers\API\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\ClientDetail;
use App\Models\Site;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function registerEmployee(Request $request){

        $userId = Auth::guard('clientapi')->id();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'username' => 'required|string|unique:clients',
            'password' => 'required|string|min:6',
            'email' => 'required|email|unique:clients',
            'mobile' => 'required|string',
            'lines' => 'nullable',
            // Add validation rules for other fields
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $lines = json_decode($request->input('lines'));


        // Example check: Assuming lines data is in JSON format
        $linesBelongToUser = Site::whereIn('id', $lines)
                                    ->where('client_id', $userId)
                                    ->exists();

        if (!$linesBelongToUser) {
            return response()->json(['error' => 'Sites data does not belong to the authenticated user'], 403);
        }
            $employee = new Client();
            $employee->name = $request->input('name');
            $employee->username = $request->input('username');
            $employee->password = Hash::make($request->input('password'));
            $employee->email = $request->input('email');
            $employee->client_id = $userId;
            $employee->is_employee = 1;
            $employee->lines = $request->input('lines'); // Convert lines array to JSON
            // $employee->lines = json_encode($request->input('lines')); // Convert lines array to JSON
            $employee->save();

            // Create ClientDetail record
            $details = new ClientDetail();
            $details->client_id = $employee->id; // Assign client_id
            $details->address = $request->input('address');
            $details->mobile_no = $request->input('mobile');
            $details->save();

        return response()->json([
            'message' => 'Employee registered successfully',
            'employee' => $employee,
            'details' => $details,
        ], 201);

    }

    public function checkUsernameAvailability(Request $request){
        $username = $request->input('username');

        // Validate the request input
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid input.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if the username exists in the database
        $exists = Client::where('username', $username)->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Username is already taken.',
                'available' => false
            ], 200);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Username is available.',
                'available' => true
            ], 200);
        }
    }
}
