<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\User;
use App\Models\State;
use App\Models\District;
use App\Models\City;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    public function index(Request $request)
    {

        $search_feild['role_id'] = $request->role_id;
        $data = User::with('role')->whereNot('role_id', 0)

            ->where(function ($query) use ($request) {
                if ($request->role_id != null) {
                    $query->where('role_id', $request->role_id);
                }

            })

            ->latest()->get();

        $roles = Roles::whereNot('id', 0)
            ->where(function ($query) use ($request) {
            })

            ->get();
        $count = 1;
        return view('usermanagement.index', compact('data', 'count', 'roles', 'search_feild'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Roles::latest()->get();

        $count = 1;
        $states=State::orderBy('state_title')->get();
        return view('usermanagement.create', compact('roles', 'count','states'));
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
    
        // Validate the request
        $validated = Validator::make($request->all(), $rules);
    
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }
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

        return redirect()->route('usermanagement.index')->with('success', 'User Create Successfully');
    }

   
    public function show(string $id)
    {
        $user = User::with(['role', 'userDetail.state', 'userDetail.city', 'userDetail.district', 'relatedUsers'])->findOrFail($id);
            return view('usermanagement.show', compact('user'));
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
        if ( $data->role->role_type == 2) {
            $childUsers = User::where('role_id', $data->role->child_role_id)->get();
        } 
        

        return view('usermanagement.edit', compact('data', 'roles', 'states', 'cities', 'districts', 'childUsers'));


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            // 'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            // 'username' => 'required|string|max:255|unique:users,username,' . $id,
            'role_id' => 'required|exists:roles,id',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id',
            'state_id' => 'required|exists:state,id',
            'city_id' => 'required|exists:city,id',
            'district_id' => 'required|exists:district,id',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
    
        $user->role_id = $request->role_id;
        $user->save();
        $role=Roles::whereId($request->role_id)->first();
        // Sync child users
        if ($request->has('user_ids') && $role->role_type==2) {
            $user->relatedUsers()->sync($request->user_ids);
        } else {
            $user->relatedUsers()->detach();
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

}
