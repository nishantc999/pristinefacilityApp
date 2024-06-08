<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
class RoleController extends Controller
{
    public function __construct()
    {
         $this->middleware('permission:role management,create')->only(['create','store']);
         $this->middleware('permission:role management,delete')->only(['destroy']);
         $this->middleware('permission:role management,show')->only(['index']);
         $this->middleware('permission:role management,update')->only(['edit','update','status']);
    }
    public function index()
    {
        $data = Roles::latest()->get();
        $count = 1;
        return view('role.index', compact('data', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $module = Permission::distinct('module_name')->pluck('module_name')->toArray();
        $data = Permission::all();
        $group_permissions = $data->groupBy('module_name');

        return view('role.create', compact('group_permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
        ]);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }
        $data = Permission::all();
        $group_permissions = $data->groupBy('module_name');
        $data = [];
        foreach ($group_permissions as $key => $permissions) {
            foreach ($permissions as $value) {
                $permission_id = $value->id;
                $permission = 'permission' . $value->id;

                if ($request->$permission == 1) {
                    $data[$key][] = $value->feature_name;

                    $index = 1;
                }
            }
        }

      
        Roles::create(['name' => $request->name, 'permission' => $data]);
        return redirect()->route('role.index')->with('success', 'Role Create Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $module = Permission::distinct('module_name')->pluck('module_name')->toArray();

        $group_permissions = Permission::all()->groupBy('module_name');
        $data = Roles::whereId($id)->first();

        return view('role.edit', compact('group_permissions', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
        ]);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }
        // $data = Permission::all();
        $group_permissions = Permission::all()->groupBy('module_name');
        $data = [];
        foreach ($group_permissions as $key => $permissions) {
            foreach ($permissions as $value) {
                $permission_id = $value->id;
                $permission = 'permission' . $value->id;

                if ($request->$permission == 1) {
                    $data[$key][] = $value->feature_name;

                    $index = 1;
                }
            }
        }
        if (count($data) == 0) {
            $validated = Validator::make($request->all(), [
                'permission' => ['required'],
            ]);
            if ($validated->fails()) {
                return redirect()->back()->withErrors($validated)->withInput();
            }
        }
        Roles::whereId($id)->update(['name' => $request->name, 'permission' => $data]);
        return redirect()->route('role.index')->with('success', 'Role Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user=User::where('role_id',$id)->first();
        if($user){
            return response()->json(['success' => false,'message'=>'You cannot delete the role because it is assigned to a user']);
        }else{
            Roles::whereId($id)->delete();
            return response()->json(['success' => true, 'message' => 'Role deleted successfully']);
        }
    }
    public function status(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        Roles::whereId($id)->update(['status' => $status]);
    }
    public function get_role_name(Request $request)
    {
        $id = $request->role_id;
       
       $role_id= Roles::whereId($id)->value('id');
        return response()->json(['role_id' =>$role_id]);
    }

}




