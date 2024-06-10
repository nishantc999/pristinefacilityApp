<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Employee,
    Shift,
    User,
    Pivit,
    Site,
    Area,
    EmployeeDetail,
    Client,
    State,
    City,
    District,
};
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::latest()->get();
        
        $count = 1;
        return view('employeemanagement.index', compact('employees','count'));
    }

    public function create()
    {
       
        $clients=Client::where('is_employee',0)->where('status',1)->orderBy('name')->get();
        $EmpCode=Employee::orderBy('id', 'desc')->value('emp_code')??1000;
        $states = State::get();
        return view('employeemanagement.create',compact('states','clients','EmpCode'));
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
            'mobile_no' => 'nullable|string|max:255|unique:employees,mobile_no',
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
            'aadhar_card' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'pan_card' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'passbook' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'police_verification' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'medical' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'state_id' => 'required|exists:state,id',
            'city_id' => 'required|exists:city,id',
            'district_id' => 'required|exists:district,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }
        // $data=$request->all();
        // $uploadedDocuments = [];
        // if(!is_null($request->documents) && is_array($request->documents)){
        //     foreach ($request->documents as $documentType => $file) {
        //         if ($file) {
        //             $fileName = time() . '_' . $documentType . '.' . $file->getClientOriginalExtension();
        //             $filePath = $file->storeAs('documents', $fileName, 'public');
        //             $uploadedDocuments[$documentType] = $filePath;
        //         }
        //     }
        // }
   

        // $data['documents'] = $uploadedDocuments;

        $data=  $request->only([
            'name',
            'email',
            'emp_code',
            'site_id',
            'area_id',
            'shift_id',
            'client_id',
            'father_name',
            'mother_name',
            'gender',
            'age',
            'blood_group',
            'nominee_name',
            'registration_status',
            'dob',
            'date_of_joining',
            'mobile_no',
            'total_experience',
            'qualification',
            'designation',
            'expertise',
            'salary',
            'family_detail'
        ]);

       $employee= Employee::create($data);
      
       $employeeDetail = new EmployeeDetail();
       $employeeDetail->employee_id = $employee->id;
       if ($request->hasFile('aadhar_card')) {
        $imageName = time() . uniqid() . '.' . $request->aadhar_card->extension();
        $request->aadhar_card->move('assets/images/aadhar_card', $imageName);
        $employeeDetail->aadhar_card = 'aadhar_card/'.$imageName;
        $employeeDetail->aadhar_card_status = 'approved';

        }
       if ($request->hasFile('pan_card')) {
        $imageName = time() . uniqid() . '.' . $request->pan_card->extension();
        $request->pan_card->move('assets/images/pan_card', $imageName);
        $employeeDetail->pan_card = 'pan_card/'.$imageName;
        $employeeDetail->pan_card_status = 'approved';

        }
       if ($request->hasFile('passbook')) {
        $imageName = time() . uniqid() . '.' . $request->passbook->extension();
        $request->passbook->move('assets/images/passbook', $imageName);
        $employeeDetail->passbook = 'passbook/'.$imageName;
        $employeeDetail->passbook_status = 'approved';

        }
       if ($request->hasFile('police_verification')) {
        $imageName = time() . uniqid() . '.' . $request->police_verification->extension();
        $request->police_verification->move('assets/images/police_verification', $imageName);
        $employeeDetail->police_verification = 'police_verification/'.$imageName;
        $employeeDetail->police_verification_status = 'approved';

        }
       if ($request->hasFile('medical')) {
        $imageName = time() . uniqid() . '.' . $request->medical->extension();
        $request->medical->move('assets/images/medical', $imageName);
        $employeeDetail->medical = 'medical/'.$imageName;
        $employeeDetail->medical_status = 'approved';

        }
        $employeeDetail->p_address=$request->p_address;
        $employeeDetail->c_address=$request->c_address;
        $employeeDetail->state_id=$request->state_id;
        $employeeDetail->city_id=$request->city_id;
        $employeeDetail->district_id=$request->district_id;
        $employeeDetail->save();
        return redirect()->route('employeemanagement.index')->with('success', 'Employee created successfully.');
    }

    public function show($id)
    {
        $employee=Employee::whereId($id)->first();
        return view('employeemanagement.show', compact('employee'));
    }

    public function edit(string $id)
    {
        $employee=Employee::whereId($id)->first();
 
       if($employee->client_id!=null){
       
        $shifts = Shift::where('client_id', $employee->client_id)->get();
        $siteIds = Pivit::where('client_id', $employee->client_id)
        ->where('shift_id', $employee->shift_id)
        ->pluck('site_id');

        $sites = Site::whereIn('id', $siteIds)->get();  
       }else{
        $sites = [];
        $shifts = [];
       }
       
        $areas = $employee->site_id ? Area::where('site_id', $employee->site_id)->get() : collect();
        $clients=Client::where('is_employee',0)->where('status',1)->orderBy('name')->get();
        $states = State::get();
        $districts = District::where('state_id',$employee->employeeDetail->state_id)->get();
        $cities = City::where('districtid',$employee->employeeDetail->district_id)->get();
        return view('employeemanagement.edit', compact('clients','employee','sites','areas','shifts','states','districts','cities'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            // 'emp_code' => 'nullable|string|max:255',
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
            'mobile_no' => ['nullable','string','max:255',Rule::unique('employees')->ignore($id),],
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
            'aadhar_card' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'pan_card' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'passbook' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'police_verification' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'medical' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'state_id' => 'required|exists:state,id',
            'city_id' => 'required|exists:city,id',
            'district_id' => 'required|exists:district,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $employee = Employee::whereId($id)->first();
        $employeeDetail = EmployeeDetail::where('employee_id', $employee->id)->first();
        $data=  $request->only([
            'name',
            'email',
            // 'emp_code',
            'site_id',
            'area_id',
            'shift_id',
            'client_id',
            'father_name',
            'mother_name',
            'gender',
            'age',
            'blood_group',
            'nominee_name',
            'registration_status',
            'dob',
            'date_of_joining',
            'mobile_no',
            'total_experience',
            'qualification',
            'designation',
            'expertise',
            'salary',
            'family_detail'
        ]);

    // Handle document uploads
    // $uploadedDocuments = [];
    // if(!is_null($request->documents) && is_array($request->documents)){
    //     foreach ($request->documents as $documentType => $file) {
    //         if ($file) {
    //             $fileName = time() . '_' . $documentType . '.' . $file->getClientOriginalExtension();
    //             $filePath = $file->storeAs('documents', $fileName, 'public');
    //             $uploadedDocuments[$documentType] = $filePath;
    //         }
    //     }
    // }else{
    //     unset($data['documents']);
    // }
 
    // Merge uploaded documents with existing documents
    



    // $data['documents'] = array_merge($employee->documents ?? [], $uploadedDocuments);
 
    Employee::whereId($id)->update($data);
    if ($request->hasFile('aadhar_card')) {
        $imageName = time() . uniqid() . '.' . $request->aadhar_card->extension();
        $request->aadhar_card->move('assets/images/aadhar_card', $imageName);
        $employeeDetail->aadhar_card = 'aadhar_card/'.$imageName;
        $employeeDetail->aadhar_card_status = 'approved';

        }
       if ($request->hasFile('pan_card')) {
        $imageName = time() . uniqid() . '.' . $request->pan_card->extension();
        $request->pan_card->move('assets/images/pan_card', $imageName);
        $employeeDetail->pan_card = 'pan_card/'.$imageName;
        $employeeDetail->pan_card_status = 'approved';

        }
       if ($request->hasFile('passbook')) {
        $imageName = time() . uniqid() . '.' . $request->passbook->extension();
        $request->passbook->move('assets/images/passbook', $imageName);
        $employeeDetail->passbook = 'passbook/'.$imageName;
        $employeeDetail->passbook_status = 'approved';

        }
       if ($request->hasFile('police_verification')) {
        $imageName = time() . uniqid() . '.' . $request->police_verification->extension();
        $request->police_verification->move('assets/images/police_verification', $imageName);
        $employeeDetail->police_verification = 'police_verification/'.$imageName;
        $employeeDetail->police_verification_status = 'approved';

        }
       if ($request->hasFile('medical')) {
        $imageName = time() . uniqid() . '.' . $request->medical->extension();
        $request->medical->move('assets/images/medical', $imageName);
        $employeeDetail->medical = 'medical/'.$imageName;
        $employeeDetail->medical_status = 'approved';

        }
        $employeeDetail->p_address=$request->p_address;
        $employeeDetail->c_address=$request->c_address;
        $employeeDetail->state_id=$request->state_id;
        $employeeDetail->city_id=$request->city_id;
        $employeeDetail->district_id=$request->district_id;
        $employeeDetail->save();

        return redirect()->route('employeemanagement.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employeemanagement.index')->with('success', 'Employee deleted successfully.');
    }

    public function getShifts($client_id)
    {
        $shifts = Shift::where('client_id', $client_id)->get(); // Assuming you have a Shift model
        
        $formattedShifts = $shifts->map(function($shift) {
            return [
                'id' => $shift->id,
                'name' => $shift->name,
                'start_time' => $shift->start_time->format('h:i A'), // Format the start_time
                'end_time' => $shift->end_time->format('h:i A'), // Format the start_time
            ];
        });
    
        return response()->json($formattedShifts);
        
        // return response()->json($shifts);
    }
    public function getSiteByClientAndShift(Request $request )
    {
        $clientId= $request->clientId;
        $shiftId= $request->shiftId;
        $client = Client::findOrFail($clientId);
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

    public function status(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        Employee::whereId($id)->update(['status' => $status]);
    }
}
