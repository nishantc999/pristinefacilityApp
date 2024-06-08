<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\User;
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
        $this->middleware('permission:user management,show')->only(['index']);
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
        $roles = Roles::

            latest()->get();

        $count = 1;

        return view('usermanagement.create', compact('roles', 'count'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role_id' => ['required', 'not_in:""'], // Ensure role_id not null for any user
            'password' => ['required', 'string', 'min:8'],
            'mobile_no' => ['required', 'numeric', 'digits:10'], // mobile no required with 10 digit

        ]);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }

        $data = $request->all();

        // this is for distributor

        // this is for fe

        // dd($data);
        $data['password'] = Hash::make($request->password);
        User::create($data);

        return redirect()->route('usermanagement.index')->with('success', 'User Create Successfully');
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
        $roles = Roles::latest()->get();

        $data = User::whereId($id)->first();
        $count = 1;

        return view('usermanagement.edit', compact('roles', 'count', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validated = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            // 'username' => ['required', 'string', 'max:255', 'unique:users'], // Ensure unique user
            'role_id' => ['required', 'not_in:""'], // Ensure role_id not null for any user

            'city_name' => ['required', 'not_in:""'], // Ensure city name not null for any user because all user register in perticuler city

            'mobile_no' => ['required', 'numeric', 'digits:10'], // mobile no required with 10 digit

        ]);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }

        $data = $request->all();

        unset($data['_token']);
        unset($data['_method']);
        if ($request->password != "" || $request->password != null) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }
        User::whereId($id)->update($data);
        return redirect()->route('usermanagement.index')->with('success', 'User Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::whereId($id)->update(['status' => 0]);
        return response()->json(['success' => true, 'message' => 'User deleted successfully']);
    }
    public function status(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        User::whereId($id)->update(['status' => $status]);
    }

}
