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
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {

        $this->middleware('permission:user management,create')->only(['create', 'store']);
        $this->middleware('permission:user management,delete')->only(['destroy']);
        $this->middleware('permission:user management,show')->only(['index','show']);
        $this->middleware('permission:user management,update')->only(['edit', 'update', 'status']);

    }
    // public function index(Request $request)
    // {


      
 
    //     $search_feild['role_id'] = $request->role_id;
    //     $data = User::with('role')->whereNot('role_id', 0)

    //         ->where(function ($query) use ($request) {
    //             if ($request->role_id != null) {
    //                 $query->where('role_id', $request->role_id);
    //             }

    //         })

    //         ->latest()->get();

    //     $roles = Roles::whereNot('id', 0)
    //         ->where(function ($query) use ($request) {
    //         })

    //         ->get();
    //     $count = 1;
    //     return view('usermanagement.index', compact('data', 'count', 'roles', 'search_feild'));

    // }
    public function index(Request $request)
    {


           $roles = Roles::whereNot('id', 0)
            ->where(function ($query) use ($request) {
            })

            ->get();
 
        $search_feild['role_id'] = $request->role_id;
        if ($request->ajax()) {
            $data = User::with(['role', 'userDetail.city', 'userDetail.state'])
                ->whereNot('role_id', 0);
    
            if ($request->role_id) {
                $data->where('role_id', $request->role_id);
            }
    
            return Datatables::of($data)
                ->addIndexColumn()  // This adds the DT_RowIndex column
                ->addColumn('action', function ($row) {
                    $editUrl = route('usermanagement.edit', $row->id);
                    $deleteUrl = "javascript:;";
    
                    $actions = ' <div class="d-flex order-actions">';
                    if (ispermission('user management', 'update')) {
                        $actions .= "<a href='$editUrl' class='edit'><i class='bx bxs-edit'></i></a>";
                    }
                    if (ispermission('user management', 'delete')) {
                        $actions .= "<a href='$deleteUrl' class='delete ms-3' onclick='Deletedata({$row->id}, \"{$deleteUrl}\")'><i class='bx bxs-trash text-danger'></i></a>";
                    }
                     $actions .='</div>';
                    return $actions;
                })
                ->addColumn('status', function ($row) {
                    $checked = $row->status == 1 ? 'checked' : '';
                    $statusUrl = route('user.status');
                    return "<div class='form-check-primary form-check form-switch'>
                                <input class='form-check-input' type='checkbox' onclick='statuschange(this, \"$statusUrl\")' data-id='$row->id' $checked>
                            </div>";
                })
                
                ->addColumn('mobile_no', function ($row) {
                    return $row->userDetail->mobile_no ?? '';
                })
                ->addColumn('city', function ($row) {
                    return $row->userDetail->city->name ?? '';
                })
                ->addColumn('state', function ($row) {
                    return $row->userDetail->state->state_title ?? '';
                })
                ->addColumn('view', function ($row) {
                    $viewUrl = route('usermanagement.show', $row->id);
                    $view = "<a href='$viewUrl' class='btn btn-primary btn-sm radius-30 px-4'>View</a>";
                    return $view;
                })
                ->rawColumns(['action', 'status', 'view'])
                ->make(true);
        }
    
        return view('usermanagement.index', compact('roles', 'search_feild'));
       

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Roles::latest()->get();

        $count = 1;
        $states=State::orderBy('state_title')->get();
        $clients=Client::where('is_employee',0)->orderBy('name')->get();
        return view('usermanagement.create', compact('roles', 'count','states','clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = Roles::find($request->role_id);

        // Set up the validation rules
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'role_id' => ['required', 'exists:roles,id'],
            'password' => ['required', 'string', 'min:8'],
            'mobile_no' => ['required', 'numeric', 'digits:10'],
            'state_id' => ['required', 'exists:state,id'],
            'city_id' => ['required', 'exists:city,id'],
            'district_id' => ['required', 'exists:district,id'],
            'address' => ['required', 'string'],
        ];
    
        // If the role_type is 2, add the user_ids validation rule
        if ($role && $role->role_type == 2) {
            $rules['user_ids'] = ['required', 'array', 'min:1'];
        }
        if ($role && $role->role_type == 3 &&( $request->client_id!=null || $request->site_id!=null ||$request->shift_id!=null)) {
            $rules['client_id'] = ['required', 'exists:clients,id'];
            $rules['site_id'] = ['required', 'exists:sites,id'];
            $rules['shift_id'] = ['required', 'exists:shifts,id'];
        }  

        // Validate the request
        $validated = Validator::make($request->all(), $rules);
    
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }
       
       
        // dd($request->all());
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'role_id' => $request->role_id,
            'password' => bcrypt($request->password),
            
        ]);
    
        $user->userDetail()->create([
            'user_id' => $user->id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'district_id' => $request->district_id,
            'mobile_no' => $request->mobile_no,
            'address' => $request->address,
        ]);
    
        // If role_type is 2, attach the selected users
        if ($role && $role->role_type == 2) {
            $user->relatedUsers()->attach($request->user_ids);
        }    
        if ($role && $role->role_type == 3 &&( $request->client_id!=null || $request->site_id!=null ||$request->shift_id!=null)) {
            $assignment = UserAssignment::create([
                'client_id' => $request->client_id,
                'site_id' => $request->site_id,
                'shift_id' => $request->shift_id,
                'user_id' => $user->id,
            ]);
        }    

        return redirect()->route('usermanagement.index')->with('success', 'User Create Successfully');
    }

   
    public function show(string $id)
    {
        $user = User::with(['role', 'userDetail.state', 'userDetail.city', 'userDetail.district', 'relatedUsers'])->findOrFail($id);
        $client=null;
        if($user->role_id==1){
            $client=Client::where('project_manager_id',$id)->first();
        }

            return view('usermanagement.show', compact('user','client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $roles = Roles::latest()->get();

        $data = User::whereId($id)->first();
        $count = 1;


        $data = User::findOrFail($id);
        $states = State::all();
        
        $districts = District::where('state_id',$data->UserDetail->state_id)->get();
        $cities = City::where('districtid',$data->UserDetail->district_id)->get();
        $childUsers = [];
        if ( $data->role->role_type == 2) {
            $childUsers = User::where('role_id', $data->role->child_role_id)->get();
        } 
        
        $clients=Client::where('is_employee',0)->orderBy('name')->get();
        $assignment = UserAssignment::where('user_id',$data->id)->first();
        $sites=[];
        $shifts=[];
        if($assignment){
            $sites = Site::where('client_id', $assignment->client_id)->get();
            $shifts = Site::find($assignment->site_id)->siteShifts->unique('id');
        }
        return view('usermanagement.edit', compact('data', 'roles', 'states', 'cities', 'districts', 'childUsers','assignment','clients','sites','shifts'));


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            // 'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'role_id' => ['required', 'exists:roles,id'],
            'password' => ['nullable', 'string', 'min:8'],
            'mobile_no' => ['required', 'numeric', 'digits:10'],
            'state_id' => ['required', 'exists:state,id'],
            'city_id' => ['required', 'exists:city,id'],
            'district_id' => ['required', 'exists:district,id'],
            'address' => ['required', 'string'],
        ];
        $role = Roles::find($request->role_id);
        if ($role && $role->role_type == 2) {
            $rules['user_ids'] = ['required', 'array', 'min:1'];
        }
        if ($role && $role->role_type == 3 &&( $request->client_id!=null || $request->site_id!=null ||$request->shift_id!=null)) {
            $rules['client_id'] = ['required', 'exists:clients,id'];
            $rules['site_id'] = ['required', 'exists:sites,id'];
            $rules['shift_id'] = ['required', 'exists:shifts,id'];
        } 

        $validated = Validator::make($request->all(), $rules);
    
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }
        $user = User::findOrFail($id);
        $user->name = $request->name;
    
        $user->role_id = $request->role_id;
        if($request->password!=null){
            $user->password=bcrypt($request->password);
        }
        $user->save();
        $role=Roles::whereId($request->role_id)->first();
        // Sync child users
        if ($request->has('user_ids') && $role->role_type==2) {
            $user->relatedUsers()->sync($request->user_ids);
        } else {
            $user->relatedUsers()->detach();
        }
  


        if ($role && $role->role_type == 3) {
            if ($request->client_id && $request->site_id && $request->shift_id) {
               
                $user->UserAssignment()->updateOrCreate(
                    ['user_id' => $user->id],
                    ['client_id' => $request->client_id, 'site_id' => $request->site_id, 'shift_id' => $request->shift_id]
                );
            } else {
                // If any value is missing, detach the assignment
                $user->UserAssignment()->delete();
            }
        }else{
            $user->UserAssignment()->delete(); 
        }


        // Update user details
        $user->userDetail()->update([
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'district_id' => $request->district_id,
        ]);

     
 
        return redirect()->route('usermanagement.index')->with('success', 'User Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::whereId($id)->delete();
        return response()->json(['success' => true, 'message' => 'User deleted successfully']);
    }
    public function status(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        User::whereId($id)->update(['status' => $status]);
    }


    public function getUsersByRole($roleId)
{
    $role = Roles::findOrFail($roleId);
    $childRole = $role->childRole;
    $users = $childRole ?  $childRole->users()->with('userDetail')->get(): [];

    return response()->json([
        'users' => $users,
        'child_role_name' => $childRole ? $childRole->name : null
    ]);
}


public function getSites($client_id)
{
    $sites = Site::where('client_id', $client_id)->get();
    return response()->json($sites);
}

public function getShifts($site_id)
{
    // $shifts = Shift::where('site_id', $site_id)->get();
    $shifts = Site::find($site_id)->siteShifts->unique('id');
    return response()->json($shifts);
}
}
