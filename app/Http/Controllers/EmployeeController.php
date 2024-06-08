<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Employee,
    Shift,
    User,
    Pivit,
    Site,
    Area
};
use Illuminate\Support\Facades\Validator;
class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::get();
        return view('employeemanagement.index', compact('employees'));
    }

    public function create()
    {
        $shifts = Shift::get();
        $clients=User::where('role_id',1)->where('status',1)->orderBy('name')->get();
        $EmpCode=Employee::orderBy('id', 'desc')->value('emp_code')??1000;
        return view('employeemanagement.create',compact('shifts','clients','EmpCode'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'emp_code' => 'nullable|string|max:255',
            'site_id' => 'nullable|integer',
            'area_id' => 'nullable|integer',
            'shift_id' => 'nullable|integer',
            'client_id' => 'nullable|integer',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'age' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string|max:255',
            'nominee_name' => 'nullable|string|max:255',
            'registration_status' => 'nullable|boolean',
            'dob' => 'required|date',
            'date_of_joining' => 'required|date',
            'mobile_no' => 'nullable|string|max:255',
            'p_address' => 'required|string|max:700',
            'c_address' => 'required|string|max:700',
            'total_experience' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'designation' => 'required|string|max:255',
            'expertise' => 'nullable|string|max:255',
            'salary' => 'required|numeric',
            'family_detail' => 'required|array|min:1',
            'family_detail.*.name' => 'required|string|max:255',
            'family_detail.*.dob' => 'required|date',
            'family_detail.*.age' => 'required|string|max:255',
            'family_detail.*.sex' => 'required|string|max:255',
            'family_detail.*.relationship' => 'required|string|max:255',       
            'documents.adhar_card' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'documents.pan_card' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'documents.passbook' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'documents.policy_verification' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'documents.medical' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }
        $data=$request->all();
        $uploadedDocuments = [];
        if(!is_null($request->documents) && is_array($request->documents)){
            foreach ($request->documents as $documentType => $file) {
                if ($file) {
                    $fileName = time() . '_' . $documentType . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('documents', $fileName, 'public');
                    $uploadedDocuments[$documentType] = $filePath;
                }
            }
        }
   

        $data['documents'] = $uploadedDocuments;
        Employee::create($data);
        return redirect()->route('employeemanagement.index')->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        return view('employeemanagement.show', compact('employee'));
    }

    public function edit(string $id)
    {
        $employee=Employee::whereId($id)->first();
        $shifts=Shift::get();
       if($employee->client_id!=null){
        $siteIds = Pivit::where('client_id', $request->client_id)
        ->where('shift_id', $request->shift_id)
        ->pluck('site_id');

        $sites = Site::whereIn('id', $siteIds)->get();  
       }else{
        $sites = [];
       }
       
        $areas = $employee->site_id ? Area::where('site_id', $employee->site_id)->get() : collect();
        $clients=User::where('role_id',1)->where('status',1)->orderBy('name')->get();
        return view('employeemanagement.edit', compact('shifts','clients','employee','sites','areas'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'emp_code' => 'nullable|string|max:255',
            'site_id' => 'nullable|integer',
            'area_id' => 'nullable|integer',
            'shift_id' => 'nullable|integer',
            'client_id' => 'nullable|integer',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'age' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string|max:255',
            'nominee_name' => 'nullable|string|max:255',
            'registration_status' => 'nullable|boolean',
            'dob' => 'required|date',
            'date_of_joining' => 'required|date',
            'mobile_no' => 'nullable|string|max:255',
            'p_address' => 'required|string|max:700',
            'c_address' => 'required|string|max:700',
            'total_experience' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'designation' => 'required|string|max:255',
            'expertise' => 'nullable|string|max:255',
            'salary' => 'required|numeric',
            'family_detail' => 'required|array|min:1',
            'family_detail.*.name' => 'required|string|max:255',
            'family_detail.*.dob' => 'required|date',
            'family_detail.*.age' => 'required|string|max:255',
            'family_detail.*.sex' => 'required|string|max:255',
            'family_detail.*.relationship' => 'required|string|max:255',       
            'documents.adhar_card' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'documents.pan_card' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'documents.passbook' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'documents.policy_verification' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'documents.medical' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $employee = Employee::whereId($id)->first();
        $data=$request->all();

    // Handle document uploads
    $uploadedDocuments = [];
    if(!is_null($request->documents) && is_array($request->documents)){
        foreach ($request->documents as $documentType => $file) {
            if ($file) {
                $fileName = time() . '_' . $documentType . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('documents', $fileName, 'public');
                $uploadedDocuments[$documentType] = $filePath;
            }
        }
    }else{
        unset($data['documents']);
    }
 
    // Merge uploaded documents with existing documents
    



    $data['documents'] = array_merge($employee->documents ?? [], $uploadedDocuments);
 
    Employee::whereId($id)->update($data);
        return redirect()->route('employeemanagement.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employeemanagement.index')->with('success', 'Employee deleted successfully.');
    }
    public function getSiteByClientAndShift(Request $request )
    {
        $clientId= $request->clientId;
        $shiftId= $request->shiftId;
        $client = User::findOrFail($clientId);
        $shift = Shift::findOrFail($shiftId);




        $siteIds = Pivit::where('client_id', $request->clientId)
                            ->where('shift_id', $request->shiftId)
                            ->pluck('site_id');

        $sites = Site::whereIn('id', $siteIds)->get();

       

        // Fetch sites associated with the client and shift
        // $sites = $client->sites()
        //                 ->whereHas('shifts', function ($query) use ($shiftId) {
        //                     $query->where('shifts.id', $shiftId);
        //                 })
        //                 ->get();
        //                 dd($sites);
        if ($sites) {
            return response()->json($sites, 200);
        } else {
            return response()->json(['message' => 'No site found for this client and shift.'], 404);
        }
    }
    public function getAreaSiteWise(Request $request )
    {
      


        $areas = Area::where('site_id', $request->site_id)->get();
                            

        if ($areas) {
            return response()->json($areas, 200);
        } else {
            return response()->json(['message' => 'No site found for this client and shift.'], 404);
        }
    }
}
