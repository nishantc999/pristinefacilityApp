<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;
use App\Models\State;
use App\Models\ClientDetail;
use App\Models\Shift;

use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with('detail')->get();

        $count = 1;
        return view('clients.index', compact('clients','count'));
    }

    public function create()
    {
        // $projectManagers = User::where('role_id', 1)->where('status', 1)->where('is_assigned', 0)->get();
        $projectManagers = User::where('role_id', 1)->where('status', 1)->get();
        $states=State::orderBy('state_title')->get();
        return view('clients.create', compact('projectManagers','states'));
    }

    public function store(Request $request)
    {
       // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:clients,username|max:255',
            'email' => 'required|string|email|unique:clients,email|max:255',
            'password' => 'required|string|min:8|max:255',
            'address' => 'nullable|string|max:500',
            'mobile' => 'nullable|string|digits:10',
            'city_id' => 'nullable|exists:city,id',
            'district_id' => 'nullable|exists:district,id',
            'state_id' => 'nullable|exists:state,id',
        ]);

        // Create a new client instance
        $client = new Client();

        // Assign validated data to the client instance
        $client->name = $validatedData['name'];
        $client->username = $validatedData['username'];
        $client->email = $validatedData['email'];
        $client->password = bcrypt($validatedData['password']);

        // Save the client instance
        $client->save();

        // Create a new client detail instance
        $clientDetail = new ClientDetail();

        // Assign validated data to the client detail instance
        $clientDetail->client_id = $client->id; // Assign the client ID
        $clientDetail->address = $validatedData['address'];
        $clientDetail->mobile_no = $validatedData['mobile'];
        $clientDetail->city_id = $validatedData['city_id'];
        $clientDetail->district_id = $validatedData['district_id'];
        $clientDetail->state_id = $validatedData['state_id'];

        // Save the client detail instance
        $clientDetail->save();

        // Redirect the user to a success page or wherever appropriate
        return redirect()->route('clients.index')->with('success', 'Client created successfully!');
    }

    public function checkUsername(Request $request)
    {
        $username = $request->input('username');
        $exists = Client::where('username', $username)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function profile($id){

        return view('clients.profile.profile', compact('id'));
    }

    // Profile
    public function dashboard($id)
    {
        return view('clients.profile.dashboard', compact('id'));
    }

    // Business Details Function
    public function businessDetails($id)
    {
        return view('business-details', compact('id'));
    }

    // Shifts Function
    public function shifts($id)
    {
        $count = 1;
        $shifts = Shift::get();
        // $shifts = Shift::where('client_id', $id)->get();
        return view('clients.profile.shifts.shifts', compact('shifts','id', 'count'));
    }
    public function storeShift(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'weekday' => 'required|array',
            'shift_hr' => 'required|in:8,12',
        ]);

        $shift = new Shift();
        $shift->name = $request->name;
        $shift->description = $request->description;
        $shift->start_time = $request->start_time;
        $shift->end_time = $request->end_time;
        $shift->weekdays = implode(',', $request->weekday); // store as comma-separated values
        $shift->shift_hr = $request->shift_hr;
        $shift->save();

        return redirect()->route('shifts')->with('success', 'Shift created successfully.');
    }

    // Areas Function
    public function areas($id)
    {
        return view('clients.areas.index', compact('id'));
    }

    // Lines and Floors Function
    public function linesFloors($id)
    {
        return view('lines-floors', compact('id'));
    }
}
