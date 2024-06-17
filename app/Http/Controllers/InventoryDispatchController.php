<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryDispatch;
use App\Models\Shift;
use App\Models\Sku;
use App\Models\InventoryMeasure;
use App\Models\InventoryDispatchMeasure;
use App\Models\Client;
use App\Models\Roles;
use App\Models\User;
use App\Models\UserAssignment;
use Auth;
use Illuminate\Support\Collection;
class InventoryDispatchController extends Controller
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
        $search_feild['sendingDate'] = $request->sendingDate; // Assuming $request->date contains the date range "2024-05-01 to 2024-05-24"
        $search_feild['sender'] = $request->sender;
         $search_feild['shift_id'] = $request->shift_id;
        if ($request->shift_id != null) {$users = User::where('shift_id', $request->shift_id)  // Select users where the 'shift_id' column matches the value from the request
    ->latest()  // Orders the results by the created_at column in descending order
    ->pluck('name');  // Retrieves an array containing the 'name' column values for the selected users
}
// dd()
        // Initialize the query
        $query = InventoryDispatch::whereNotNull('sendingDate'); // Ensure date is not null
        
        // Check if a date range is provided in the request
        if ($request->sendingDate != null) {
            // Split the date range into "from" and "to" dates
            list($fromDate, $toDate) = explode(" to ", $search_feild['sendingDate']);
            
            // Apply the date range filter
            $query->whereDate('sendingDate', '>=', $fromDate)
              ->whereDate('sendingDate', '<=', $toDate);
        }
         // Check if a sender is provided in the request
    if ($request->sendor != null) {
        // Apply the sender filter
        $query->where('sendor', $request->sendor);
    }
    if($request->shift_id!=null){
    if ($users ) {
        // Apply the sender filter
        $query->whereIn('sendor_id', $users);
    }}
        // Get the results
        $data = $query->latest()->orderBy('dispatchNumber','desc')->get();
        
$sendingDate = InventoryDispatch::whereNot('sendingDate', "")
->where(function ($query) use ($request) {
})->pluck('sendingDate');
$sender = InventoryDispatch::whereNot('sender_id', null)
->where(function ($query) use ($request) {
})

->pluck('sender_id')->unique();
// dd($sendor);

$senders = [];
foreach($sender as &$send) { // Use reference to modify the actual array elements
    if($send == 0) {
        $send = User::whereId(1)->first()->name;
    } else {
        $send = User::whereId($send)->first()->name;
    }
    array_push($senders,$send);
}
$sender = $senders;
        // $data = Inward::latest()->get();
        // $data = RW_Dispatch::latest()->get();
           $shifts=Shift::get();
           foreach ($data as $dat){
            $user = User::whereId($dat->receiver_id)->first()->name;
            $dat["receiver"] = $user;
            $dat["client"] = Client::whereId($dat->client_id)->first()->name;
            $dat["shift"] = Shift::whereId($dat->shift_id)->first()->name;
            if($dat->sender == 0){
                $dat["sender"] = User::whereId(1)->first()->name;
            }else{
                $dat["sender"] = User::whereId($dat->sender)->first()->name;
            }
            
           }
        //    dd($data);
        return view('Inventory.Dispatch.index', ['data' => $data, 'count' => 1, 'search_feild' => $search_feild, "sendingDate"=>$sendingDate,'sender'=>$sender,'shifts' => $shifts]);
    }

    public function create()
    {
      // Default SKU number
      $defaultdispatchNumber = 1001;
      $defaultSku = 1001;

      // Get the maximum SKU number from the database
      $maxSku = SKU::max('sku');
      $maxDispatchNumber = InventoryDispatch::max('dispatchNumber');

      // Check if the maximum SKU exists and is numeric
      if ($maxSku !== null && is_numeric($maxSku)) {
          // Increment the maximum SKU number
          $defaultSku = (int)$maxSku + 1;
      }
      
      if ($maxDispatchNumber !== null && is_numeric($maxDispatchNumber)) {
          // Increment the maximum SKU number
          $defaultdispatchNumber = (int)$maxDispatchNumber + 1;
      }
     $skus = SKU::orderBy('label', 'asc')->get();

// Filter the $skus collection
$filteredSkus = $skus->filter(function ($sku) {
    // Find all matching Inventory records with non-zero quantity
    $inventoryItems = InventoryMeasure::where('sku_quantity', '>', 0)->get();

    // Check if any Inventory item matches the SKU label (case-insensitive)
    foreach ($inventoryItems as $inventoryItem) {
        if (strtolower($inventoryItem->label) == strtolower($sku->label)) {
            return true;
        }
    }

    return false;
});

// Reset keys on the filtered collection
$filteredSkus = $filteredSkus->values();
// dd($filteredSkus->count());
$skus = $filteredSkus;
if($filteredSkus->count()){}else{
    return redirect()->route('inventorydispatch.index')->with('failure', 'no more inventory to create!!');
}
      $userName = Auth::user()->id;
    $userName = $userName;
    $clients = Client::select('name','id')->get();
    // $users = 
    // foreach($clients as $client){
    //     $shift = Shift::where('client_id',$client->id)->select('name','id')->get();
    //     $client["shift"] = $shift;
    // }
    // $roles = Roles::get();
    // dd($roles); //role type 2 and 3;
    // dd($clients);
      return view('Inventory.Dispatch.create', ['defaultSku' => $defaultSku,'skus'=>$skus, 'userName'=>$userName, 'defaultdispatchNumber'=>$defaultdispatchNumber,'clients'=>$clients]);
    }

    public function get_shift(string $id)
    {

       
       
        try {
            // Find the SKU by its ID
            $shift = Shift::where('client_id',$id)->select('name','id')->get();
            // $client["shift"] = $shift;
            return response()->json(['success' => true, 'message' => $shift]);
        } catch (\Exception $e) {
            // Return error response
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function get_user(string $id)
    {

       
       
        try {
            // Find the SKU by its ID
            // [client_id,shift_id];
                $client_id = $id[0];
                $shift_id = $id[1];
                $roles = User::whereIn('role_id',[2,3])->pluck('id');
                $user = UserAssignment::where('client_id',$id[0])->where('shift_id',$id[2])->whereIn('user_id',$roles)->pluck('user_id');
                $user = User::whereIn('id',$user)->select('id','name','role_id')->get();
                foreach ($user as $use){
                    $use["role_id"] = Roles::whereId($use["role_id"])->first()->name;
                }
            return response()->json(['success' => true, 'message' => $user]);
        } catch (\Exception $e) {
            // Return error response
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    
    public function store(Request $request)
    {
        // dd($request);
        // $validated = $request->validate([
        //     'vendor_name' => 'required|string|max:255',
        //     'image' => 'nullable|mimes:pdf|max:10048',
        //     'unit' => 'required|string|in:KG',
        // ]);
    
        // Encode composition data to JSON
        $product = $request->product;
        $quantity = $request->quantity;
        $result = [];
        $count = count($product);
        for ($i = 0; $i < $count; $i++) {
            $result[] = ['product' => $product[$i], 'quantity' => $quantity[$i]];
        }
 
   

        $composition = $result;
        
       
         
        //   dd($inwards);
        foreach ($result as $inwardItem){
             $inventory = InventoryMeasure::where('sku_label', $inwardItem['product'])->first();
             if ($inventory) {
            //     // Update the quantity
                 if(($inventory->sku_quantity ?? 0) - intval($inwardItem['quantity'])<0){
                    return redirect()->route('inventorydispatch.index')->with('failure', 'not enough inventory!!!');
                }else{
                $inventory->sku_quantity = ($inventory->sku_quantity ?? 0) - intval($inwardItem['quantity']);
               $inventory->save();}
             } else {
                 return redirect()->route('inventorydispatch.index')->with('failure', 'not enough inventory!!!');
            //     // Handle the case where the product is not found in the inventory
            //     // You might want to log an error or perform other actions here
             }
             $inventorydispatch = InventoryDispatchMeasure::where('receiver_id',$request -> user_id)->where('sku_label', $inwardItem['product'])->first();
             if($inventorydispatch){
                $inventorydispatch["sku_quantity"] += $inwardItem['quantity'];
                $inventorydispatch->save();
             }else{
             $inventorydispatch["label"] = SKU::where('sku',$inwardItem['product'])->first()->label;
             $inventorydispatch["image"] = SKU::where('sku',$inwardItem['product'])->first()->image;
             $inventorydispatch["receiver_id"] = $request -> user_id;
             $inventorydispatch["sku_label"] = $inwardItem['product'];
             $inventorydispatch["sku_quantity"] = $inwardItem['quantity'];
             $inventory = InventoryDispatchMeasure::create($inventorydispatch);
             }
            //  $inventory = InventoryDispatchMeasure::where('sku_label', $inwardItem['product'])->first();
    }
        //  dd($inwards);
        //  $composition = array_merge($composition, $purchase_no);
// dd($composition);
        // Create SKU record
        // dd("updated",$updatedresult,"previous",$result);
        // dd($composition);
           $number = InventoryDispatch::max('dispatchNumber');
    if($number){
        $number = $number+1;
    }else{
        $number = "1001";}
        // $data["purchase_no"] = $number;
        $data['dispatchNumber'] = $number;
        $data['client_id'] = $request -> client_id;
        $data['shift_id'] = $request -> shift_id;
        $data['receiver_id'] = $request -> user_id;
        $data['sender'] = Auth::user()->id;
        $data['product_quantity'] = $composition;
        $currentDateTime = date('Y-m-d H:i:s');
        $data['sendingDate'] = date('Y-m-d H:i:s');
    
      // Upload SKU PDF
// if ($request->hasFile('pdf')) {
//     $pdfName = time() . '.' . $request->pdf->extension();
//     $request->pdf->move('assets/pdfs', $pdfName);
//     $data['image'] = $pdfName;
// }
    
        // Create SKU
        InventoryDispatch::create($data);
    
        // Redirect back with success message
        return redirect()->route('inventorydispatch.index')->with('success', 'inward creation created successfully!');
    }
    function show($dispatchNumber){
        $data = InventoryDispatch::where('dispatchNumber',$dispatchNumber)->get(); // Ensure SKU record exists or throw 404 if not found
        $count = 1;
        $composition = $data[0]->product_quantity;
  
  foreach ($composition as &$item) { // Add '&' to reference the array elements directly
      // Find the SKU record corresponding to the product in the composition
      $sku = SKU::firstWhere('sku', $item['product']);
      
      // If SKU record exists, add a new field to the composition with label + unit
      if ($sku) {
          $item['label_unit'] = $sku->label;
      }
  }
          return view('Inventory.Dispatch.ind', ['data'=>$data,'count'=>$count, 'composition'=>$composition]);
    }

    public function edit(string $id)
    {
  // Default SKU number
    $userName = Auth::user()->name;
    $defaultdispatchNumber = 1001;
    $maxDispatchNumber = InventoryDispatch::max('dispatchNumber');
    if ($maxDispatchNumber !== null && is_numeric($maxDispatchNumber)) {
        // Increment the maximum SKU number
        $defaultdispatchNumber = (int)$maxDispatchNumber + 1;
    }

  $defaultSku = 1001;

  $data = InventoryDispatch::where('dispatchNumber',$id)->first(); // Ensure SKU record exists or throw 404 if not found
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
  $composition = $data->product_quantity;
  $composition = array_filter($composition, function ($item) {
    return is_array($item) && isset($item['product']);
});
  foreach ($composition as &$item) { // Add '&' to reference the array elements directly
      // Find the SKU record corresponding to the product in the composition
      $sku = SKU::firstWhere('sku', $item['product']);
      
      // If SKU record exists, add a new field to the composition with label + unit
      if ($sku) {
          $item['label_unit'] = $sku->label . ' (' . $sku->unit . ')';
      }
  }
  $clients = Client::select('name','id')->get();
  $data["user_label"] = Client::whereId($data->client_id)->first()->name;
  $data["shift_label"] = Shift::whereId($data->shift_id)->first()->name;
  $data["receiver_label"] = User::whereId($data->receiver_id)->first()->name . "(".Roles::whereId(User::whereId($data->receiver_id)->first()->role_id)->first()->name.")";
  return view('Inventory.Dispatch.edit', ['defaultSku' => $defaultSku,'skus'=>$skus, 'data'=>$data, 'composition'=>$composition, 'userName'=>$userName, 'defaultdispatchNumber'=>$defaultdispatchNumber,'toshow'=>true,'req'=>"" ,'clients'=>$clients]);
    }


      public function update(Request $request, string $id)
    {
        
        // Encode composition data to JSON
        $product = $request->product;
        $quantity = $request->quantity;
        $result = [];
        $count = count($product);
        for ($i = 0; $i < $count; $i++) {
            $result[] = ['product' => $product[$i], 'quantity' => $quantity[$i]];
        }




   

        $composition = $result;
        $inward = InventoryDispatch::where('dispatchNumber', $id)->first();
        $inwardcomp = $inward->product_quantity;
            foreach ($result as $inwardItem) {
                $key = array_search($inwardItem["product"], array_column($inward->product_quantity, "product"));
                $inventory = InventoryMeasure::where('sku_label', $inwardItem['product'])->first();
                $inventorydispatch = InventoryDispatchMeasure::where('receiver_id',$request -> user_id)->where('sku_label', $inwardItem['product'])->first();
                if ($inventory) {
                    if ($key !== false) {
                        // Update the quantity based on the difference
                        $newQuantity = intval($inventory->sku_quantity ?? 0) + intval($inwardcomp[$key]['quantity']) - intval($inwardItem['quantity']);
                        $newQuantityDispatch = intval($inventorydispatch->sku_quantity ?? 0) - intval($inwardcomp[$key]['quantity']) + intval($inwardItem['quantity']);
                        $inventorydispatch->sku_quantity = $newQuantityDispatch;
                        $inventorydispatch->save();
                        // dd($inventorydispatch->sku_quantity,"+",$inwardcomp[$key]['quantity'],"-",$inwardItem['quantity'],"=", $newQuantityDispatch);
                    } else {
                        // Add the quantity if the SKU is not found in inwardcomp
                        $newQuantity = intval($inventory->sku_quantity ?? 0) - intval($inwardItem['quantity']);
                        // $newQuantityDispatch = 
                        $inventorydispatch["label"] = SKU::where('sku',$inwardItem['product'])->first()->label;
                        $inventorydispatch["image"] = SKU::where('sku',$inwardItem['product'])->first()->image;
                        $inventorydispatch["receiver_id"] = $request -> user_id;
                        $inventorydispatch["sku_label"] = $inwardItem['product'];
                        $inventorydispatch["sku_quantity"] = intval($inventorydispatch->sku_quantity ?? 0) + intval($inwardItem['quantity']);
                        $inventorydispatch = InventoryDispatchMeasure::create($inventorydispatch);
                    }
            
                    // Ensure the quantity is non-negative
                    if($newQuantity<0){
                        return redirect()->route('inventorydispatch.index')->with('failure', 'not enough inventory');
                    }else{
                    $inventory->sku_quantity = $newQuantity;
                    $inventory->save();
                
                }
                }
                

            }
        // $inwardcomps = $inward->product_quantity;
        $data = $request->only(['dispatchNumber']);
        // dd($data);
        $data['product_quantity'] = $composition;
        $data['sender_id'] = Auth::user()->id;
        $data['receiver_id'] = $request -> user_id;
        $data['client_id'] = $request -> client_id;
        $data['shift_id'] = $request -> shift_id;
        $data['sendingDate'] = date('Y-m-d H:i:s');

        // Upload SKU image
        // if ($request->hasFile('pdf')) {
        //     $pdfName = time() . '.' . $request->pdf->extension();
        //     $request->pdf->move('assets/pdfs', $pdfName);
        //     $data['image'] = $pdfName;
        // }
    // dd($id);
        // Update the record
        InventoryDispatch::where('dispatchNumber',$id)->update($data);

     //  $updatedata=DB::table('s_k_u_s')->where('id',$id )->get();

       // dd($updatedata);
    
        // Redirect back with success message
        return redirect()->route('inventorydispatch.index')->with('success', 'SKU updated successfully!');
    }


    public function destroy(string $id)
    {
        try {
             $inward = InventoryDispatch::where('dispatchNumber',$id)->first();  
              foreach($inward->product_quantity as $product){
                $inventory = InventoryMeasure::where('sku_label',$product["product"] )->first();
                $inventory->sku_quantity = $inventory->sku_quantity + $product["quantity"];
                $inventory->save();
                $inventorydispatch = InventoryDispatchMeasure::where('receiver_id',$inward->receiver_id)->where('sku_label', $product["product"])->first();
                $inventorydispatch->sku_quantity = $inventorydispatch->sku_quantity - $product["quantity"];
                $inventorydispatch->save();
            }
            $inward -> delete();
           
        } catch (\Exception $e) {
            // Return error response
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function inventorymeasureuser(Request $request){
        $datareq = false;
        $search_feild['receiver'] = $request->receiver;
        $search_feild['client'] = $request->client;
        $search_feild['shift'] = $request->shift;
        $user = null;
        if($request->client && $request->shift){
            $client_id = $request->client;
                $shift_id = $request->shift;
                $roles = User::whereIn('role_id',[2,3])->pluck('id');
                $user = UserAssignment::where('client_id',$client_id )->where('shift_id',$shift_id)->whereIn('user_id',$roles)->pluck('user_id');
                $user = User::whereIn('id',$user)->select('id','name','role_id')->get();
                foreach ($user as $use){
                    $use["role_id"] = Roles::whereId($use["role_id"])->first()->name;
                    
                }

                //working//
                $inventories = [];
                foreach ($user as $use){
                    $inventory = InventoryDispatchMeasure::where("receiver_id", $use->id)
                    ->select('sku_label', 'sku_quantity')
                    ->get();
                    if(!$inventory->isEmpty()){
                        array_push($inventories,$inventory);
                    }
                }
                // dd($inventories);
                $aggregated = [];
                if($inventories==null){
                    $datareq = true;
                }
    // Iterate through each collection in the inventories array
    foreach ($inventories as $collection) {
        // Iterate through each item in the collection
        foreach ($collection as $item) {
            $skuLabel = $item->sku_label;
            $skuQuantity = (int) $item->sku_quantity;

            // If the sku_label already exists in the aggregated array, add to the sku_quantity
            if (isset($aggregated[$skuLabel])) {
                $aggregated[$skuLabel]['sku_quantity'] += $skuQuantity;
            } else {
                // Otherwise, create a new entry for the sku_label
                $aggregated[$skuLabel] = [
                    'sku_label' => $skuLabel,
                    'sku_quantity' => $skuQuantity,
                ];
            }
        }
    }

    // Convert the aggregated results to an array format suitable for dd or further processing
    $aggregated = array_values($aggregated);

    // Dump the aggregated results
    $inventory = $aggregated;
                $combined = [];

// Iterate through each inventory item
foreach ($inventory as $item) {
    $productId = $item['sku_label'];
    $quantity = (int) $item['sku_quantity']; // Convert quantity to integer for summing
    
    // If the product ID already exists in $combined, add to the quantity
    if (isset($combined[$productId])) {
        $combined[$productId]['quantity'] += $quantity;
    } else {
        // Otherwise, create a new entry for the product ID
        $combined[$productId] = [
            "product" => $productId,
            "quantity" => $quantity,
        ];
    }
}

// Convert combined array values to indexed array (optional)
$result = array_values($combined);
// dd($result);
// Step 1: Collect all product values
// Step 1: Collect all product values
$productSkus = array_column($result, 'product');

// Step 2: Query the database once
$inventoryData = InventoryMeasure::whereIn('sku_label', $productSkus)->get()->keyBy('sku_label');

// Step 3 and Step 4: Create a mapping of sku_label to label and image, and update result
foreach ($result as &$res) {
    if (isset($inventoryData[$res["product"]])) {
        $res["label"] = $inventoryData[$res["product"]]->label;
        $res["image"] = $inventoryData[$res["product"]]->image;
    } else {
        $res["label"] = null; // Or some default value
        $res["image"] = null; // Or some default value
    }
    $res["sku_quantity"] = $res["quantity"];
}

// Step 5: Assign the updated result to $data and dump it
$data = $result;
//  dd($data);

                //working//
        }
        if($request->client && $request->shift){}else{
        $data = InventoryDispatchMeasure::get();
        foreach($data as $dat){
            $dat['label'] = SKU::where('sku',$dat['sku_label'])->value('label');
        }
    }
        $inventoryname = "User Inventory";
        $clients = Client::select('name','id')->get();
        //
        $shift = Shift::where('client_id',$search_feild['client'] )->select('name','id')->get();
        
        

        $inventory = InventoryDispatchMeasure::where("receiver_id", $request->receiver)
        ->select('sku_label', 'sku_quantity')
        ->get();

        if($request->receiver){
         
        
          // Initialize an empty array to store the aggregated results
    $aggregated = [];

    // Iterate through the inventory items
    foreach ($inventory as $item) {
        $skuLabel = $item->sku_label;
        $skuQuantity = (int) $item->sku_quantity;

        // If the sku_label already exists in the aggregated array, add to the sku_quantity
        if (isset($aggregated[$skuLabel])) {
            $aggregated[$skuLabel]['sku_quantity'] += $skuQuantity;
        } else {
            // Otherwise, create a new entry for the sku_label
            $aggregated[$skuLabel] = [
                'product' => $skuLabel,
                'quantity' => $skuQuantity,
            ];
        }
    }

    // Convert the aggregated results to an array format suitable for dd or further processing
    $aggregated = array_values($aggregated);

    // Dump the aggregated results
    // dd($aggregated);
    $result = $aggregated;
// dd($result);
// Step 1: Collect all product values
// Step 1: Collect all product values
$productSkus = array_column($result, 'product');

// Step 2: Query the database once
$inventoryData = InventoryMeasure::whereIn('sku_label', $productSkus)->get()->keyBy('sku_label');

// Step 3 and Step 4: Create a mapping of sku_label to label and image, and update result
foreach ($result as &$res) {
    if (isset($inventoryData[$res["product"]])) {
        $res["label"] = $inventoryData[$res["product"]]->label;
        $res["image"] = $inventoryData[$res["product"]]->image;
    } else {
        $res["label"] = null; // Or some default value
        $res["image"] = null; // Or some default value
    }
    $res["sku_quantity"] = $res["quantity"];
}

// Step 5: Assign the updated result to $data and dump it
$data = $result;
//  dd($data);


        }
        // dd($data);
        if($datareq){
            $data = [];
        }
        return view('Inventory.measure', ['data' => $data, 'inventoryname'=> $inventoryname, 'count' => 1, 'sendor'=>$user, 'search_feild'=>$search_feild,'clients'=>$clients,'shift'=>$shift]);
    }
}
