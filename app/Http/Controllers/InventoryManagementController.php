<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Roles;
use App\Models\State;
use App\Models\SKU;
use App\Models\Client;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryManagementController extends Controller
{
    public function __construct()
    {

        $this->middleware('permission:inventory management,create')->only(['create', 'store']);
        $this->middleware('permission:inventory management,delete')->only(['destroy']);
        $this->middleware('permission:inventory management,show')->only(['index','show']);
        $this->middleware('permission:inventory management,update')->only(['edit', 'update', 'status']);

    }
    public function index(Request $request)
    {


      
        $search_feild['date'] = $request->date; // Assuming $request->date contains the date range "2024-05-01 to 2024-05-24"

               // Initialize the query
               $query = Inventory::whereNotNull('date'); // Ensure date is not null
               
               // Check if a date range is provided in the request
               if ($request->date != null) {
                   // Split the date range into "from" and "to" dates
                   list($fromDate, $toDate) = explode(" to ", $search_feild['date']);
                   
                   // Apply the date range filter
                   $query->whereDate('date', '>=', $fromDate)
                     ->whereDate('date', '<=', $toDate);
               }
               if ($request->vendorname != null) {
                   // Split the date range into "from" and "to" dates
                   
                   // Apply the date range filter
                   $query->where('vendor', '=', $vennam);
               }
               
               // Get the results
               $data = $query->latest()->orderBy('created_at','desc')->get();
               // dd( $data);
       $date = Inventory::whereNot('date', "")
       ->where(function ($query) use ($request) {
       })
       
       ->pluck('date');
               // $data = Inward::latest()->get();
       
       // Loop through each inward_creation record
       foreach ($data as $record) {
           // Add count of elements in the sku_label_and_quantity array
           $record['sku_label_and_quantity_count'] = count($record->sku_label_and_quantity);
       }
        return view('Inventory.index' , ['data' => $data, 'count' => 1, 'search_feild' => $search_feild, "date"=>$date]);

    }

    public function create()
    {
        // $roles = Roles::latest()->get();

        // $count = 1;
        // $states=State::orderBy('state_title')->get();
        // $clients=Client::where('is_employee',0)->orderBy('name')->get();
         // Default SKU number
         $defaultSku = 1001;
         $defaultPurchaseNo = 1001;
 
         // Get the maximum SKU number from the database
         $maxSku = SKU::max('sku');
 $maxPurchaseNo = Inventory::max('purchase_no');
         // Check if the maximum SKU exists and is numeric
         if ($maxSku !== null && is_numeric($maxSku)) {
             // Increment the maximum SKU number
             $defaultSku = (int)$maxSku + 1;
         }
         if ($maxPurchaseNo !== null && is_numeric($maxPurchaseNo)) {
             // Increment the maximum SKU number
             $defaultPurchaseNo = (int)$maxPurchaseNo + 1;
         }
         $skus=SKU::orderBy('label', 'asc')->get();
         return view('Inventory.create', ['defaultSku' => $defaultSku,'skus'=>$skus,'defaultPurchaseNo'=>$defaultPurchaseNo]);
        // return view('Inventory.create', compact('roles', 'count','states','clients'));
    }

    public function store(Request $request)
    {
          // Validation rules
          $validated = $request->validate([
            'vendor_name' => 'required|string|max:255',
            'image' => 'nullable|mimes:pdf,png,jpg,jpeg|max:10048',
            'unit' => 'required|string|in:KG',
        ]);
    
        // Encode composition data to JSON
        $product = $request->product;
        $quantity = $request->quantity;
        $result = [];
        $count = count($product);
        for ($i = 0; $i < $count; $i++) {
            $result[] = ['product' => $product[$i], 'quantity' => $quantity[$i],'calc_quantity' => $quantity[$i],'status' => 0];
        }




   

        $composition = $result;
        
        // foreach ($result as $inwardItem){

        //         $inventory = Inventory::where('sku_label', $inwardItem['product'])->first();
        //         if ($inventory) {
        //             // Update the quantity
        //             $inventory->sku_quantity = ($inventory->sku_quantity ?? 0) + intval($inwardItem['quantity']);
        //             $inventory->save();
        //         } else {
        //             // Handle the case where the product is not found in the inventory
        //             // You might want to log an error or perform other actions here
        //         }
        // }
       // dd($composition);
    
        // Create SKU record
        $data = $request->all();
         $number = Inventory::max('purchase_no');
    if($number){
        $number = $number+1;
    }else{
        $number = "1001";}
        $data["purchase_no"] = $number;
        $data['sku_label_and_quantity'] = $composition;
        $data['vendor'] = $request->vendor_name;
    
      // Upload SKU PDF
      if ($request->hasFile('pdf')) {
        $pdfName = time() . '.' . $request->pdf->extension();
        $request->pdf->move('assets/pdfs', $pdfName);
        $data['pdf'] = $pdfName;
    }
    
   else if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move('assets/images', $imageName);
        $data['pdf'] = $imageName;
    }
    
    
        // Create SKU
        Inventory::create($data);
    
        // Redirect back with success message
        return redirect()->route('inventory.index')->with('success', 'inward creation created successfully!');
    }
    
    public function show($id)
    {
        // dd($id);

        $data = Inventory::whereId($id)->get(); // Ensure SKU record exists or throw 404 if not found
    //   dd($data);
      $count = 1;
      $composition = $data[0]->sku_label_and_quantity;
foreach ($composition as &$item) { // Add '&' to reference the array elements directly
    // Find the SKU record corresponding to the product in the composition
    $sku = SKU::firstWhere('sku', $item['product']);
    
    // If SKU record exists, add a new field to the composition with label + unit
    if ($sku) {
        $item['label_unit'] = $sku->label;
        $item['subid'] = $id;
    }
}
unset($item); // Unset the reference to avoid potential side effects

        return view('Inventory.ind', ['data'=>$data,'count'=>$count, 'composition'=>$composition]);
    }

public function bill_get($id)
    {
        //  dd($id);

        $data = Inventory::whereId($id)->get(); // Ensure SKU record exists or throw 404 if not found
    $pdfFilename = $data[0]->pdf;

// Extract the extension of the file
$extension = pathinfo($pdfFilename, PATHINFO_EXTENSION);

// Check if the extension is 'pdf'
if ($extension === 'pdf') {
    // Do something if the extension is 'pdf'
    $pdf = true ;
} else {
    // Do something else if the extension is not 'pdf'
    $pdf = false;
}
        return view('Inventory.pdfind', ['filename'=>$pdfFilename,'pdf'=>$pdf]);
    }

    public function edit($id){
        $defaultSku = 1001;
              $data = Inventory::findOrFail($id); // Ensure SKU record exists or throw 404 if not found
              $edit = true;
              // Get the maximum SKU number from the database
              $maxSku = SKU::max('sku');
      
              // Check if the maximum SKU exists and is numeric
              if ($maxSku !== null && is_numeric($maxSku)) {
                  // Increment the maximum SKU number
                  $defaultSku = (int)$maxSku + 1;
              }
              $skus=SKU::orderBy('label', 'asc')->get();
              // foreach ($skus as $sku) {
              //     $composition = $sku->composition;
              //     dd($composition);
              // }
              $composition = $data->sku_label_and_quantity;
              foreach ($composition as &$item) { // Add '&' to reference the array elements directly
                  // Find the SKU record corresponding to the product in the composition
                  $sku = SKU::firstWhere('sku', $item['product']);
                  
                  // If SKU record exists, add a new field to the composition with label + unit
                  if ($sku) {
                      $item['label_unit'] = $sku->label . ' (' . $sku->unit . ')';
                  }
              }
              // Redirect back with success message
                  
      
              return view('Inventory.edit', ['defaultSku' => $defaultSku,'skus'=>$skus, 'data'=>$data, 'edit'=>$edit, 'composition'=>$composition,'toshow'=>true,'req'=>""]);
            }

            public function update(Request $request, string $id)
            {
                // Validation rules
                $validated = $request->validate([
                    'image' => 'nullable|mimes:pdf,png,jpg,jpeg|max:10048',
                    'unit' => 'required|string|in:KG,Count',
                ]);
            
                // Encode composition data to JSON
                $product = $request->product;
                $quantity = $request->quantity;
                // $price = $request->price;
                $result = [];
                $count = count($product);
                for ($i = 0; $i < $count; $i++) {
                    $result[] = ['product' => $product[$i], 'quantity' => $quantity[$i],'calc_quantity' => $quantity[$i]];
                }
        
        
        
        
           
        
                $composition = $result;
                $inward = Inventory::where('vendor', $request->vendor_name)->first();
                // if($inward){
                // $inwardcomp = $inward->sku_label_and_quantity;
        
                //      foreach ($result as $inwardItem) {
                //         $key = array_search($inwardItem["product"], array_column($inward->sku_label_and_quantity, "product"));
                //         $inventory = Inventory::where('sku_label', $inwardItem['product'])->first();
                        
                //         if ($inventory) {
                //             if ($key !== false) {
                //                 // Update the quantity based on the difference
                //                 $newQuantity = intval($inventory->sku_quantity ?? 0) - intval($inwardcomp[$key]['quantity']) + intval($inwardItem['quantity']);
                //             } else {
                //                 // Add the quantity if the SKU is not found in inwardcomp
                //                 $newQuantity = intval($inventory->sku_quantity ?? 0) + intval($inwardItem['quantity']);
                //             }
                    
                //             // Ensure the quantity is non-negative
                //             $inventory->sku_quantity = max(0, $newQuantity);
                //             $inventory->save();
                //         }
                //     }
                // }
                // dd($request);
            
                // Create SKU record
                $data = $request->only(['date']);
                // dd($data);
                $data['sku_label_and_quantity'] = $composition;
                $data['vendor'] = $request -> vendor_name;
            
                // Upload SKU image
                if ($request->hasFile('pdf')) {
                    $pdfName = time() . '.' . $request->pdf->extension();
                    $request->pdf->move('assets/pdfs', $pdfName);
                    $data['pdf'] = $pdfName;
                }
                
               else if ($request->hasFile('image')) {
                    $imageName = time() . '.' . $request->image->extension();
                    $request->image->move('assets/images', $imageName);
                    $data['pdf'] = $imageName;
                }
                
            // dd($id);
                // Update the record
                Inventory::whereId($id)->update($data);
        
             //  $updatedata=DB::table('s_k_u_s')->where('id',$id )->get();
        
               // dd($updatedata);
            
                // Redirect back with success message
                return redirect()->route('inventory.index')->with('success', 'SKU updated successfully!');
            }

            public function destroy(string $id)
    {

       
       
        try {
            // Find the SKU by its ID
            $inward = Inventory::findOrFail($id);  
                // foreach($inward->sku_label_and_quantity as $product){
                // $inventory = Inventory::where('sku_label',$product["product"] )->first();
                // $inventory->sku_quantity = max(0, $inventory->sku_quantity - $product["quantity"]);
                // $inventory->save();}
                $inward -> delete();
                
        } catch (\Exception $e) {
            // Return error response
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function inventorymeasure(){
        return "hello";
    }
}
