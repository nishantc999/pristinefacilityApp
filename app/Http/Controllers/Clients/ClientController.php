<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Checklist;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;
use App\Models\State;
use App\Models\ClientDetail;
use App\Models\Shift;
use App\Models\Site;
use App\Models\Variables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
            'client_id' => 'required|exists:clients,id',
            'description' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'weekday' => 'required|array',
            'shift_hr' => 'required|in:8,12',
        ]);



        $data = $request->all();
        Shift::create($data);

        $clientId = $request->client_id;

    // Redirect to the shifts route with the client_id as parameter
    return redirect()->route('shifts', ['id' => $clientId]);
    }

    // Areas Function
    public function areas($id)
    {
        $count = 1;
        $areas = Area::where('client_id', $id)->get();
        return view('clients.profile.areas.index', compact('id','count', 'areas'));
    }
    public function Areastatus(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        Area::whereId($id)->update(['status' => $status]);
    }

    public function storeArea(Request $request){
        $request->validate([
            'name' => 'required|string|unique:areas,name|max:255',
            'client_id' => 'required|exists:clients,id',

        ]);



            $data = $request->all();
            Area::create($data);

            $clientId = $request->client_id;

        // Redirect to the shifts route with the client_id as parameter
        return redirect()->route('areas', ['id' => $clientId]);
    }

    public function AreaDelete($id){

            Area::whereId($id)->delete();
            return response()->json(['success' => true, 'message' => 'Area deleted successfully']);

    }

    // Lines and Floors Function
    public function linesFloors($id)
    {
        return view('lines-floors', compact('id'));
    }


    // Checklists Variable

    public function variables($id){

        $count = 1;
        $variables = Variables::where('client_id', $id)->get();
        return view('clients.profile.variables.index', compact('id', 'variables', 'count'));
    }

    public function storeVariables(Request $request){
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('variables')->where(function ($query) use ($request) {
                    return $query->where('client_id', $request->client_id);
                })
            ],
            'description' => 'string|max:255',
            'client_id' => 'required|exists:clients,id',

        ]);

            $data = $request->all();
            Variables::create($data);

            $clientId = $request->client_id;

        // Redirect to the shifts route with the client_id as parameter
        return redirect()->route('variables', ['id' => $clientId]);
    }

    public function VariableStatus(Request $request){
        $id = $request->id;
        $status = $request->status;
        Variables::whereId($id)->update(['status' => $status]);
    }

    public function VariablesDelete($id){
        Variables::whereId($id)->delete();
        return response()->json(['success' => true, 'message' => 'Variable deleted successfully']);
    }


    // Checklist
    public function checklist($id){

        $count = 1;
        $checklists = Checklist::where('client_id', $id)->with(['shift', 'area','site'])->get();

        $areas = Area::where('client_id', $id)->get();
        $shifts = Shift::where('client_id', $id)->get();
        $variables = Variables::where('client_id', $id)->get();
        return view('clients.profile.checklists.index', compact('id', 'checklists', 'count', 'areas', 'variables',  'shifts'));
    }

    public function storeChecklist(Request $request){
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('checklists')->where(function ($query) use ($request) {
                    return $query->where('client_id', $request->client_id);
                })
            ],
            'client_id' => 'required|exists:clients,id',
            'area_id' => 'required|exists:areas,id',
            'variables' => 'array',
            'variables.*' => 'exists:variables,id',
        ]);

        foreach ($request->shifts as $shift) {
            Checklist::create([
                'name' => $request->name,
                'area_id' => $request->area_id,
                'variables' => json_encode($request->variables),
                'client_id' => $request->client_id,
                'shift_id' => $shift,
            ]);
        }

            $clientId = $request->client_id;

        // Redirect to the shifts route with the client_id as parameter
        return redirect()->route('checklist', ['id' => $clientId]);
    }

    public function ChecklistStatus(Request $request){
        $id = $request->id;
        $status = $request->status;
        Checklist::whereId($id)->update(['status' => $status]);
    }
    public function editChecklist($id)
{
    $checklist = Checklist::findOrFail($id);
    $checklist->variables = json_decode($checklist->variables);

    return response()->json($checklist);
}
public function ChecklistUpdate(Request $request)
{
    $request->validate([
        'name' => [
            'required',
            'string',
            'max:255',
            // Rule::unique('checklists')->where(function ($query) use ($request) {
            //     return $query->where('client_id', $request->client_id);
            // })
        ],
        'area_id' => 'required|exists:areas,id',
        'variables' => 'array',
        'variables.*' => 'exists:variables,id',
        'client_id' => 'required|exists:clients,id',
    ]);

    $checklist = Checklist::findOrFail($request->checklist_id);
    $checklist->update([
        'name' => $request->name,
        'area_id' => $request->area_id,
        'variables' => json_encode($request->variables),
    ]);
    $clientId = $request->client_id;
    return redirect()->route('checklist', ['id' => $clientId]);
}

    public function ChecklistDelete($id){
        Checklist::whereId($id)->delete();
        return response()->json(['success' => true, 'message' => 'Checklist deleted successfully']);
    }

    // site/floors/lines


    public function site($id){

        $count = 1;
        $sites = Site::where('client_id', $id)->with(['shifts', 'areas'])->get();

        $areas = Area::where('client_id', $id)->get();
        $shifts = Shift::where('client_id', $id)->get();

        return view('clients.profile.lines.index', compact('id','count', 'shifts', 'areas','sites'));
    }

    public function storeSite(Request $request){
        // dd($request);
            // Accessing the request parameters
            $requestData = $request->all();

            // Extracting relevant data
            $siteName = $requestData['name'];
            $client_id = $requestData['client_id'];

            // Create a new site
            $site = new Site();
            $site->name = $siteName;
            $site->client_id = $client_id;
            $site->save();

            // Attach shifts and their areas to the site

           foreach ($requestData['shifts'] as $shiftId) {
            // Accessing areas for the current shift
            $shiftAreasKey = 'shift_' . $shiftId . '_areas';
            $areas = $requestData[$shiftAreasKey];


            // Attach areas to the shift
            foreach ($areas as $areaId) {
                $site->shifts()->attach($shiftId, ['client_id' => $client_id, 'area_id' => $areaId]);
            }
        }
            return redirect()->route('site', ['id' => $client_id]);
    }
}
