<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    User,
    Shift
};
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {

        $this->middleware('permission:shift management,create')->only(['create', 'store']);
        $this->middleware('permission:shift management,delete')->only(['destroy']);
        $this->middleware('permission:shift management,show')->only(['index']);
        $this->middleware('permission:shift management,update')->only(['edit', 'update', 'status']);

    }
    public function index(Request $request)
    {


        $data = Shift::latest()->get();


        $count = 1;
        return view('shiftmanagement.index', compact('data', 'count'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $count = 1;
        return view('shiftmanagement.create', compact('count'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'weekday' => 'required|array', // Ensure weekday is an array
            'weekday.*' => 'required|string', // Ensure each weekday is a str
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'shift_hr' => 'required|integer',


        ]);




        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }

        $data = $request->all();
        // this is for distributor

        // this is for fe

        // dd($data);
        // $data['password'] = Hash::make($request->password);
        Shift::create($data);

        return redirect()->route('shiftmanagement.index')->with('success', 'Shift Create Successfully');
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


        $data = Shift::whereId($id)->first();
        $count = 1;

        return view('shiftmanagement.edit', compact('count', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validated = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'weekday' => 'required|array', // Ensure weekday is an array
            'weekday.*' => 'required|string', // Ensure each weekday is a str
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'shift_hr' => 'required|integer',


        ]);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }

        $data = $request->all();

        unset($data['_token']);
        unset($data['_method']);
        $clientId = $request->client_id;
        Shift::whereId($id)->update($data);
        return redirect()->route('shifts', ['id' => $clientId]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
