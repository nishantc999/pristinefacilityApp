<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    User,
  
    SKU,
  
    Stock,

};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use DB;
use Session;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


       $users = User::get();
       
      
       return view('dashboard',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }





    public function profile()
    {
        $data = Auth::user();
        return view('profile.edit', compact('data'));
    }
    public function profilestore(Request $request)
    {
        $user = Auth::user();

        if ($request->hasFile('profile')) {
            $imageName = time() . '.' . $request->profile->extension();
            $request->profile->move('assets/slip', $imageName);
            $user->profile = $imageName;
            // $imageName = uniqid() . '_' . time() . '.' . $request->file('profile')->getClientOriginalExtension();
            // $request->file('profile')->storeAs('uploads', $imageName, 'public');
            // $user->profile = $imageName;
            // $imageName = $request->file('profile')->store('uploads', 'public');
        }
        if ($request->password != null || $request->c_password != null) {

            $request->validate([
                'password' => 'required|min:8',
                'c_password' => 'required_with:password|same:password|min:8',

            ]);

            if ($request->password == $request->c_password) {

                $user->password = bcrypt($request->password);

            }
        }
        $user->name = $request->name;
        $user->save();

        return redirect()->back()->with('success', 'Profile Update Successfully');
    }

    public function set_global_city(Request $request)
    {
        if($request->city==-1){
            \Session::forget('city');
            \Session::forget('warehouse');
            // return redirect()->back()->with('success', 'City Set Successfully');
            return redirect()->back();
        }else{
            \Session::put('city', $request->city);
            // return redirect()->back()->with('success', 'City Set Successfully');
            return redirect()->back();
        }

    }
    public function set_global_distributor(Request $request)
    {

        \Session::forget('city');
        \Session::forget('warehouse');
        if($request->distributor==-1){
            \Session::forget('distributor');
            // return redirect()->back()->with('success', 'distributor Set Successfully');
            return redirect()->back();
        }else{
            \Session::put('distributor', $request->distributor);
            // return redirect()->back()->with('success', 'distributor Set Successfully');
            return redirect()->back();
        }

    }
    public function set_global_warehouse(Request $request)
    {
        if($request->warehouse==-1){
            \Session::forget('warehouse');
            // return redirect()->back()->with('success', 'warehouse Set Successfully');
            return redirect()->back();
        }else{
            \Session::put('warehouse', $request->warehouse);
            // return redirect()->back()->with('success', 'warehouse Set Successfully');
            return redirect()->back();
        }

    }
    public function dashboard(Request $request){
        $user = Auth::user();
        // dd($user);
        $userDetails = $user->user_details;
        $currentDate = Carbon::now()->format('Y-m-d');
         $search_feild['warehouse_id'] = $request->warehouse_id;
        $search_feild['distributer_id'] = $request->distributer_id;
        $search_feild['city_id'] = $request->city_id;
        if ($request->date) {
            $currentDate = $request->date;
        }

    
            $vehicles = WarehouseManagement::with(['expences','warehouseloading' => function ($query) use ($currentDate) {
            $query->with('sku_relation');
}])->
          
            
                      where(function ($query) use ($request) {
            if ($request->warehouse_id != null) {
                $query->where('warehouse_id', $request->warehouse_id);
            }
            // if ($request->distributer_id != null) {
            //     $query->where('distributer_id', $request->distributer_id);
            // }
            if (Auth::user()->role_id==1) {
                $query->whereIn('city_id', Auth::user()->distributor_cities);
            }
            if (Auth::user()->role_id==3 || Auth::user()->role_id==4 || Auth::user()->role_id==5 || Auth::user()->role_id==6) {
                $query->where('warehouse_id', Auth::user()->user_details['warehouse_id']);
            }
            if ($request->city_id != null) {
                $query->where('city_id', $request->city_id);
            }
                      })
             ->whereDate('created_at', $currentDate)
            ->get();

        $data = [];
        $count = 0;
       
  
        
        $total_vehicles = $vehicles->count();
        $present = $vehicles->whereNotNull('is_present')->count();
        $loaded = $vehicles->whereNotNull('loading_status', 1)->count();
        $unloaded = $vehicles->whereNotNull('unloading_status', 1)->count();

        $citiesWithWarehouseCount = [];
        $totalWarehouseCount = 0;

        

$users=User::get();

    //   $cash_total = $orders->where('payment_mode', 'cash')->sum('total');
    //   $upi_total = $orders->where('payment_mode', 'upi')->sum('total');
       $cash_total = $vehicles->sum('cash_collected');
       $upi_total = $vehicles->sum('upi_collected');
       $total = $vehicles->sum('total_collected');
        $admin = $users->where('role_id', 3)->count();
       $manager = $users->where('role_id', 4)->count();
       $security = $users->where('role_id', 5)->count();
       $fe = $users->where('role_id', 6)->count();
       $all_vehicles = $vehicles->count();
//       $vehicles->each(function ($vehicle) {
//     $vehicle->total_expences = $vehicle->expences->sum('amount');
// });
      $expence = $vehicles->flatMap->expences->sum('amount'); 
    
     
       
       
       
// $skuSaleData = [];

// foreach ($vehicles as $vehicle) {
//     foreach ($vehicle->warehouseloading as $loading) {
//         $skuId = $loading->sku;
//         $saleQty = $loading->loading_qty-$loading->unloading_qty;
//         $price = $loading->price; // Assuming price is available in 'sku_relation'

//         if (!isset($skuSaleData[$skuId])) {
//             $skuSaleData[$skuId] = 0; // Initialize total sales amount to 0 if SKU is encountered for the first time
//         }

//         $totalSaleAmount = $saleQty * $price;
//         $skuSaleData[$skuId] += $totalSaleAmount; // Add total sales amount to existing total sales amount for the SKU
//     }
// }
$skuSaleData = [];

foreach ($vehicles as $vehicle) {
    foreach ($vehicle->warehouseloading as $loading) {
        $skuId = $loading->sku;
        $saleQty = $loading->loading_qty - $loading->unloading_qty;
        $price = $loading->price; // Assuming price is available in 'sku_relation'

        // Fetch additional data from the SKU model
        $skuData = SKU::where('sku',$skuId)->first();

        if ($skuData) {
            // If SKU data is found, store it in the $skuSaleData array
            if (!isset($skuSaleData[$skuId])) {
                // Initialize total sales amount and sale quantity to 0 if SKU is encountered for the first time
                $skuSaleData[$skuId] = [
                    'total_sale_amount' => 0,
                    'total_sale_qty' => 0,
                    'sku_data' => $skuData, // Store SKU data
                ];
            }

            $totalSaleAmount = $saleQty * $price;

            // Add sale quantity and total sales amount to existing values for the SKU
            $skuSaleData[$skuId]['total_sale_qty'] += $saleQty;
            $skuSaleData[$skuId]['total_sale_amount'] += $totalSaleAmount;
        }
    }
}
       
       
  
       
    //   data for filter
    
     $cities=City::
         where(function ($query) use ($request) {
            // if ($request->distributer_id != null) {
            //     $distributor_cities=User::whereId($request->distributer_id)->value('distributor_cities');
               
            //     $query->whereIn('id', $distributor_cities);
            // }
            if (Auth::user()->role_id==1) {
               
               
                $query->whereIn('id', Auth::user()->distributor_cities);
            }
         
          

        })->get();


    $distributors=[];
         if ($request->city_id != null) {
             $distributors = User::where('role_id',1)->whereJsonContains('distributor_cities', $request->city_id)->get();
                // $distributors=User::whereIn('id',$dis)->get();
            }
       
        $warehouses=[];
        //  if ($request->distributer_id != null && $request->city_id != null) {
         if ($request->city_id != null) {
            $warehouses=Warehouse::where('city',$request->city_id)->where('city',$request->city_id)->get();
           
         }
         if (Auth::user()->role_id==1 && $request->city_id != null) {
            $warehouses=Warehouse::where('user_id',Auth::user()->id)->where('city',$request->city_id)->get();
         }
     
       //$users = User::get();

        return view('admin-dashboard', compact('skuSaleData','search_feild','warehouses','distributors','cities','total','admin','citiesWithWarehouseCount','expence','totalWarehouseCount','manager','security','fe','present','all_vehicles', 'total_vehicles','currentDate','loaded', 'unloaded','data','cash_total','upi_total'));

    }
}
