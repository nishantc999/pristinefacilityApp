<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\SKU;
use Illuminate\Http\Request;

class SKUController extends Controller
{

    public function __construct()
    {

        $this->middleware('permission:sku management,create')->only(['create', 'store']);
        $this->middleware('permission:sku management,delete')->only(['destroy']);
        $this->middleware('permission:sku management,show')->only(['index']);
        $this->middleware('permission:sku management,update')->only(['edit', 'update', 'status']);

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = SKU::get();
        return view('sku.index', ['data' => $data, 'count' => 1]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $defaultSku = 1001;

        // Get the maximum SKU number from the database
        $maxSku = SKU::max('sku');

        // Check if the maximum SKU exists and is numeric
        if ($maxSku !== null && is_numeric($maxSku)) {
            // Increment the maximum SKU number
            $defaultSku = (int) $maxSku + 1;
        }

        return view('sku.create', ['sku' => $defaultSku]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation rules

        $validated = Validator::make($request->all(), [

            'sku' => 'required|numeric',
            // 'sku_type' =>'required|string|in:row,finished',
            'label' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10048', // Adjust max file size as needed
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|in:KG,Count', // Assuming unit can only be 'KG' or 'Count'

        ]);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }

        $data = $request->all();
        $data['sku_type'] = 'row';

        // upload sku image
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move('assets/images', $imageName);
            $data['image'] = $imageName;

        }

        SKU::create($data);

        // Redirect back with success message

        return redirect()->route('sku.index')->with('success', 'SKU created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find the city by its ID
        $sku = SKU::findOrFail($id);

        // Delete the city
        $sku->update(['is_delete' => 1]);

        // Optionally, you can return a response or redirect
        return redirect()->route('sku.index')->with('success', 'SKU deleted successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $data = SKU::findOrFail($id); // Ensure SKU record exists or throw 404 if not found

        $edit = true;
        return view('sku.edit', compact('data', 'edit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validation rules

        $validated = Validator::make($request->all(), [

            'sku' => 'required|numeric',
            // 'sku_type' =>'required|string|in:row,finished',
            'label' => 'required|string|max:255',

            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|in:KG,Count', // Assuming unit can only be 'KG' or 'Count'
        ]);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }

        $data = $request->all();
        unset($data['_token']);
        unset($data['_method']);
        // upload sku image
        if ($request->hasFile('image')) {

            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10048', // Adjust max file size as needed
            ]);
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move('assets/images', $imageName);
            $data['image'] = $imageName;

        } else {
            unset($data['image']);
        }
        // Update the record

        SKU::whereId($id)->update($data);

        // Redirect back with success message
        return redirect()->route('sku.index')->with('success', 'SKU updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Find the SKU by its ID
            $sku = SKU::findOrFail($id);

            // Delete the SKU
            // $sku->update(['is_delete' => 1]);

            // Return success response
            return response()->json(['success' => true, 'message' => 'SKU deleted successfully']);
        } catch (\Exception $e) {
            // Return error response
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

}
