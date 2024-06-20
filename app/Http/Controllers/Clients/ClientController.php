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
use App\Models\Employee;
use App\Models\Shift;
use App\Models\Site;
use App\Models\SiteShiftAreawithClient;
use App\Models\Variables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Intervention\Image\ImageManagerStatic as Image;


class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::where('is_employee', 0)->with('detail')->get();

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
        $shifts = Shift::where('client_id',$id)->get();
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
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = \DB::table('areas')
                        ->where('name', $value)
                        ->where('client_id', $request->input('client_id'))
                        ->exists();

                    if ($exists) {
                        $fail('The ' . $attribute . ' has already been taken for the given client.');
                    }
                }
            ],
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

        $areas = Area::where('client_id', $id)->where('checklist', 0)->get();
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
            Area::where('id', $request->area_id)->update(['checklist' =>1]);
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


            // SiteShiftAreawithClient::where('client_id', $client_id)
            //            ->where('area_id', $request->area_id)
            //            ->value('site_id');
            // Attach shifts and their areas to the site

           foreach ($requestData['shifts'] as $shiftId) {
            // Accessing areas for the current shift
            $shiftAreasKey = 'shift_' . $shiftId . '_areas';
            $areas = $requestData[$shiftAreasKey];


            // Attach areas to the shift
            foreach ($areas as $areaId) {
                $site->shifts()->attach($shiftId, ['client_id' => $client_id, 'area_id' => $areaId ]);

             // Check if checklist exists with site_id null
                $checklist = Checklist::where('client_id', $client_id)
                ->where('area_id', $areaId)
                ->where('shift_id', $shiftId)
                ->whereNull('site_id')
                ->first();

            if ($checklist) {
                // Update the existing checklist to set the site_id
                $checklist->update(['site_id' => $site->id]);
            } else {
                // Check if a checklist with the given site_id already exists
                $checklistWithSiteId = Checklist::where('client_id', $client_id)
                    ->where('area_id', $areaId)
                    ->where('shift_id', $shiftId)
                    ->where('site_id', $site->id)
                    ->first();

                    // If no checklist with the site_id exists, create a new one
                    if (!$checklistWithSiteId) {
                        $existingChecklist = Checklist::where('client_id', $client_id)
                        ->where('area_id', $areaId)
                        ->where('shift_id', $shiftId)
                        ->whereNull('site_id')
                        ->first();

                    $name = $existingChecklist ? $existingChecklist->name : $request->name;

                    Checklist::create([
                        'client_id' => $client_id,
                        'area_id' => $areaId,
                        'shift_id' => $shiftId,
                        'site_id' => $site->id,
                        'name' => $name,
                        'variables' => json_encode($request->variables),
                    ]);
                }
            }
            }
        }
            return redirect()->route('site', ['id' => $client_id]);
    }

    public function fetchAvailableEmployees()
    {
        $availableEmployees = Employee::where('occupied', 0)->get();
        return response()->json($availableEmployees);
    }

    public function assignEmployees(Request $request)
    {
        try {
            $siteId = $request->input('site_id');
            $employeeIds = $request->input('employees');

            // Check if $employeeIds is null or empty
            if (!is_array($employeeIds) || count($employeeIds) === 0) {
                return response()->json(['error' => 'No employees selected.'], 400);
            }
            $details = SiteShiftAreawithClient::where('site_id', $siteId)->first();
            // Fetch client_id, shift_id, and area_id from the pivot table site_shift_area
            $employees = Employee::whereIn('id', $employeeIds)->get();

            // Check if $employees is null or empty
            if ($employees->isEmpty()) {
                return response()->json(['error' => 'No valid employees found for the specified site.'], 400);
            }

            // Update the site ID for the selected employees
            foreach ($employees as $employee) {
                $employee->site_id = $siteId;
                $employee->client_id = $details->client_id;
                $employee->shift_id = $details->shift_id;
                $employee->area_id = $details->area_id;
                $employee->occupied = 1;
                $employee->save();
            }

            return response()->json(['message' => 'Employees assigned successfully']);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error assigning employees: ' . $e->getMessage());

            // Return an error response
            return response()->json(['error' => 'An error occurred while assigning employees.'], 500);
        }
    }

    public function generateQrCode($id)
    {
        $url = url("/checklist/{$id}");

        // Generate QR code
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($url)
            ->size(200)
            ->margin(10)
            ->build();

        // Save the QR code to a temporary file
        $filePath = storage_path("app/public/qr_codes/checklist_{$id}.png");
        $result->saveToFile($filePath);

        // Return the QR code as a downloadable response
        return response()->download($filePath, "checklist_{$id}.png")->deleteFileAfterSend(true);
    }

}
