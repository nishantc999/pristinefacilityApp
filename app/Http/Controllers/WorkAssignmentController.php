<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\User;
use App\Models\State;
use App\Models\District;
use App\Models\City;
use App\Models\UserDetail;
use App\Models\Client;
use App\Models\Site;
use App\Models\Employee;
use App\Models\Shift;
use App\Models\UserAssignment;
use App\Models\EmployeeAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WorkAssignmentController extends Controller
{
    public function __construct()
    {

        $this->middleware('permission:work assignment,create')->only(['create', 'store']);
        $this->middleware('permission:work assignment,delete')->only(['destroy']);
        $this->middleware('permission:work assignment,show')->only(['index','show']);
        $this->middleware('permission:work assignment,update')->only(['edit', 'update', 'status']);

    }
    public function index()
    {
        $clients = Client::where('is_employee', 0)
        ->withCount('sites')
        ->with(['shifts' => function ($query) {
            
                $query->with('sites');
            }])
        ->latest()
        ->get();
        // $clients = Client::where('is_employee', 0)
        // ->with(['shifts' => function ($query) {
            
        //         $query->with('sites');
        //     }])
       
        
        // ->latest()
        // ->get();
    //   dd($clients);

    // $areaCounts = DB::table('site_shift_area')
    // ->select('client_id', 'shift_id', DB::raw('COUNT(DISTINCT area_id) as area_count'))
    // ->where('client_id',$client->id)
    // ->where('shift_id', $client->shifts[1]->id)
    // ->groupBy('client_id', 'shift_id')
    // ->get();
    // dd($areaCounts)
       $count = 1;
       return view('workassignment.index', compact('clients','count'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Client::where('is_employee', 0)->where('id',$id)->first();
        $count = 1;
        return view('workassignment.show', compact('client','count'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function removeProjectManager($clientId)
    {
        $client = Client::findOrFail($clientId);
        $client->project_manager_id = null;
        $client->save();

        return redirect()->back()->with('success', 'Project Manager removed successfully.');
    }

    public function addProjectManager(Request $request, $clientId)
    {
        $client = Client::findOrFail($clientId);
        $client->project_manager_id = $request->input('user_id');
        $client->save();
        User::whereId($request->input('user_id'))->update(['occupied'=>1]);

        return redirect()->back()->with('success', 'Project Manager added successfully.');
    }

    public function getSites($clientId, $shiftId)
    {
        // @foreach ($client->shifts as $shifts )
        // {{$shifts->sites->unique('id')->count()}}
        $client = Client::findOrFail($clientId);
        $shift = Shift::findOrFail($shiftId);
        $sites = $shift->sites->unique('id');

        return response()->json(['sites' => $sites]);
    }

    public function getSI()
{
    
    $users = User::where('status',1)->where('role_id',2)->where('occupied',0)->latest()->get();

    return response()->json(['users' => $users]);
}


public function addUsers(Request $request, $clientId, $siteId, $shiftId)
{
    $client = Client::findOrFail($clientId);
    $site = Site::findOrFail($siteId);
    $shift = Shift::findOrFail($shiftId);
    $userIds = $request->input('user_id');
    
    // Attach selected users to the site and shift
    // $site->users()->attach($userIds, ['shift_id' => $shift->id]);
    foreach($userIds as $userId){
        UserAssignment::create([
            'client_id' => $clientId,
            'site_id' => $siteId,
            'shift_id' => $shiftId,
            'user_id' => $userId,
        ]);
    }
     User::whereIn('id',$userIds)->update(['occupied'=>1]);
    return response()->json(['message' => 'Users added successfully.']);
}

    public function getAssignedUsers($clientId, $siteId,$shiftId)
    {
        
        // $client = Client::findOrFail($clientId);
        $shift = Shift::findOrFail($shiftId);
        $site = Site::findOrFail($siteId);
    //    dd($site->users->where('role_id',2)->unique('id'));
    // dd($site->users()->where('role_id',2)->wherePivot('shift_id', $shiftId)->distinct()
    // ->get());
        // $assignedUsers = $site->users->where('role_id',2)->wherePivot('shift_id', $shiftId)->unique('id');
        $assignedUsers = $site->users()->where('role_id',2)->wherePivot('shift_id', $shiftId)->distinct()
    ->get();
        return response()->json(['assignedUsers' => $assignedUsers]);
    }

    public function removeUser(Request $request, $clientId, $siteId, $shiftId)
    {
        $userId = $request->input('user_id');
        UserAssignment::
                where('client_id' , $clientId)->
                where('site_id' , $siteId)->
                where('shift_id' , $shiftId)->
                where('user_id' , $userId)->delete();
                User::whereId($userId)->update(['occupied'=>0]);
        return response()->json(['message' => 'User removed successfully']);
    }

    public function removeUsers(Request $request, $clientId, $siteId, $shiftId)
    {
        $userIds = $request->input('assigned_user_id');
        foreach($userIds as $userId){
            UserAssignment::
                where('client_id' , $clientId)->
                where('site_id' , $siteId)->
                where('shift_id' , $shiftId)->
                where('user_id' , $userId)->delete();
         
        }
        User::whereIn('id',$userIds)->update(['occupied'=>0]);
        return response()->json(['message' => 'Users removed successfully']);
    }





public function getAvaliableSupervisior()
{
    
    $users = User::where('status',1)->where('role_id',3)->where('occupied',0)->latest()->get();

    return response()->json(['users' => $users]);
}
public function getAssignedSupervisor($clientId, $siteId,$shiftId)
{
    
      // $client = Client::findOrFail($clientId);
      $shift = Shift::findOrFail($shiftId);
      $site = Site::findOrFail($siteId);

      $assignedUsers = $site->users()->where('role_id',3)->wherePivot('shift_id', $shiftId)->distinct()
  ->get();
      return response()->json(['assignedUsers' => $assignedUsers]);
}
// public function addSupervisor(Request $request, $clientId, $siteId, $shiftId)
// {
//     $client = Client::findOrFail($clientId);
//     $site = Site::findOrFail($siteId);
//     $shift = Shift::findOrFail($shiftId);
//     $userIds = $request->input('user_id');
    
//     // Attach selected users to the site and shift
//     // $site->users()->attach($userIds, ['shift_id' => $shift->id]);
//     foreach($userIds as $userId){
//         UserAssignment::create([
//             'client_id' => $clientId,
//             'site_id' => $siteId,
//             'shift_id' => $shiftId,
//             'user_id' => $userId,
//         ]);
//     }

//     return response()->json(['message' => 'Users added successfully.']);
// }
// In your Laravel Controller
// employee
    public function getSites1($clientId, $shiftId)
    {
        // @foreach ($client->shifts as $shifts )
        // {{$shifts->sites->unique('id')->count()}}
        $client = Client::findOrFail($clientId);
        $shift = Shift::findOrFail($shiftId);
        $sites = $shift->sites->unique('id');
    return view('workassignment.partial.site', compact('sites'));
}



// public function getAreas(Request $request, $clientId, $siteId, $shiftId)
// {
//     $client = Client::findOrFail($clientId);
//     $site = Site::findOrFail($siteId);
//     $shift = Shift::findOrFail($shiftId);
//     // $areas= $site->areas->unique('id');
//     $areas = $site->areas()->wherePivot('shift_id', $shiftId)->distinct()->get();
//     return view('workassignment.partial.area', compact('areas'));
//     // return response()->json(['areas' => $areas]);
// }



// employee

  // Ajax request to get supervisors based on client, shift, and site
  public function getSupervisors($clientId, $shiftId, $siteId)
  {
    $shift = Shift::findOrFail($shiftId);
    $site = Site::findOrFail($siteId);

    $supervisors = $site->users()->where('role_id',3)->wherePivot('shift_id', $shiftId)->distinct()->get();
    // return response()->json(['assignedUsers' => $assignedUsers]);
    return view('workassignment.partial.supervisors', compact('supervisors'));
   
  }

  // Ajax request to get assigned employees based on client, shift, site, and supervisor
  public function getAssignedEmployees($clientId, $shiftId, $siteId, $supervisorId)
  {
    //   $employees = Employee::where('client_id', $clientId)
    //                        ->where('shift_id', $shiftId)
    //                        ->where('site_id', $siteId)
    //                        ->where('supervisor_id', $supervisorId)
    //                        ->get();
    $supervisior=User::findOrFail($supervisorId);
    $site=Site::findOrFail($siteId);
    // dd($site->employees->unique('id'));
    // $employees = $site->employees()->wherePivot('shift_id', $shiftId)->wherePivot('user_id', $supervisorId)->wherePivot('client_id', $clientId)->distinct('employee_id')
    // ->get();
    $employees = Employee::whereHas('clients', function ($query) use ($clientId, $shiftId, $siteId, $supervisorId) {
        $query->where('user_id', $supervisorId);
    })
    ->whereHas('sites', function ($query) use ($siteId) {
        $query->where('site_id', $siteId);
    })
    ->whereHas('shifts', function ($query) use ($shiftId) {
        $query->where('shift_id', $shiftId);
    })
    ->get();
      return response()->json(['employees' => $employees]);
  }

  // Ajax request to get available employees based on client, shift, site, and supervisor
  public function getAvailableEmployees()
  {
      // Example query to get available employees (replace with your logic)
      $availableEmployees = Employee::where('occupied', 0)->get();

    

      return response()->json(['employees' => $availableEmployees]);
  }

  // Ajax request to assign employees to supervisor
  public function assignEmployees(Request $request)
  {
      $supervisorId = $request->supervisor_id;
      $employeeIds = $request->employee_ids;
     
    
      $shiftId= $request->shiftId;
      $siteId= $request->siteId;
      $clientId= $request->clientId;
    $supervisior=User::findOrFail($supervisorId);
      $supervisior->employees()->attach($employeeIds, ['client_id' => $clientId, 'shift_id' => $shiftId,'site_id'=>$siteId]);
    //   foreach ($employeeIds as $employeeId) {
    //       // Assign employee to supervisor (update supervisor_id in Employee model)
    //       $employee = Employee::findOrFail($employeeId);
    //       $employee->supervisor_id = $supervisorId;
    //       $employee->save();
    //   }
    Employee::whereIn('id',$employeeIds)->update(['occupied'=>1]);
      return response()->json(['success' => true]);
  }

  // Ajax request to remove assigned employees
  public function removeEmployees(Request $request)
  {
      $employeeIds = $request->employee_ids;
        foreach($employeeIds as $employeeId){
            EmployeeAssignment::where('employee_id',$employeeId)->delete();
           
        }
        Employee::whereIn('id',$employeeIds)->update(['occupied'=>0]);
      // Example code to remove employees (replace with your logic)
     

      return response()->json(['success' => true]);
  }






}
