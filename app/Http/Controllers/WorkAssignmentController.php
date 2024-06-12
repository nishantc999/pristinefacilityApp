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
use App\Models\Shift;
use App\Models\UserAssignment;
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

        return response()->json(['message' => 'Users removed successfully']);
    }





public function getAvaliableSupervisior()
{
    
    $users = User::where('status',1)->where('role_id',3)->where('occupied',0)->latest()->get();

    return response()->json(['users' => $users]);
}

}
