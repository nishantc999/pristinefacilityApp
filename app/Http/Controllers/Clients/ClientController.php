<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;

use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        $projectManagers = User::where('role_id', 1)->where('status', 1)->where('is_assigned', 0)->get();
        return view('clients.create', compact('projectManagers'));
    }

    public function store(Request $request)
    {
        $steps = [
            1 => [
                'rules' => [
                    'client_name' => 'required|string|max:255',
                    'username' => 'required|string|max:255|unique:clients',
                    'password' => 'required|string|min:8',
                ],
                'store' => function ($data) {
                    return Client::create([
                        'client_name' => $data['client_name'],
                        'username' => $data['username'],
                        'password' => bcrypt($data['password']),
                    ]);
                }
            ],
            2 => [
                'rules' => [
                    'project_manager_id' => 'nullable|exists:users,id',
                ],
                'store' => function ($data, $client) {
                    if (!empty($data['project_manager_id'])) {
                        $client->projects()->create([
                            'project_manager_id' => $data['project_manager_id'],
                        ]);
                        $manager = User::find($data['project_manager_id']);
                        $manager->is_assigned = 1;
                        $manager->save();
                    }
                }
            ],
        ];

        $step = $request->input('step');
        $validator = Validator::make($request->all(), $steps[$step]['rules']);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $client = $steps[$step]['store']($request->all());

        return response()->json(['client' => $client]);
    }

    public function checkUsername(Request $request)
    {
        $username = $request->input('username');
        $exists = Client::where('username', $username)->exists();
        return response()->json(['exists' => $exists]);
    }
}
