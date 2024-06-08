<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;
use App\Models\User;
use App\Models\State;
use App\Models\District;
use App\Models\City;
use App\Models\Shift;
use App\Models\Site;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class ClientManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  
     public function __construct()
     {
 
         $this->middleware('permission:client management,create')->only(['create', 'store']);
         $this->middleware('permission:client management,delete')->only(['destroy']);
         $this->middleware('permission:client management,show')->only(['index']);
         $this->middleware('permission:client management,update')->only(['edit', 'update', 'status']);
 
     }
     public function index(Request $request)
     {
 
         $search_feild['role_id'] = $request->role_id;
         $data = User::with('role','city', 'state', 'district')->where('role_id', 1)->latest()->get();
        //  dd($data);
         $count = 1;
         return view('clientmanagement.index', compact('data', 'count', 'search_feild'));
 
     }
 
     /**
      * Show the form for creating a new resource.
      */
     public function create()
     {

 
        
         $states=State::orderBy('state_title')->get();
         return view('clientmanagement.create_step1', compact('states'));
     }
 
     /**
      * Store a newly created resource in storage.
      */
     public function store(Request $request)
     {
         $validated = Validator::make($request->all(), [
             'name' => ['required', 'string', 'max:255'],
             'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            //  'role_id' => ['required', 'not_in:""'], // Ensure role_id not null for any user
             'password' => ['required', 'string', 'min:8'],
             'mobile_no' => ['required', 'numeric', 'digits:10'], // mobile no required with 10 digit
 
         ]);
         if ($validated->fails()) {
             return redirect()->back()->withErrors($validated)->withInput();
         }
 
         $data = $request->all();
 
         $data['password'] = Hash::make($request->password);
         $data['role_id']=1;
         $data['client_creation_step_status']=1;

            $user=User::create($data);
            return redirect()->route('clientmanagement.create_step2',$user->id);
        //  return redirect()->route('clientmanagement.index')->with('success', 'User Create Successfully');
     }
 



      public function showStep2($id)
    {
        $user=User::whereId($id)->first();
        if ($user==null) {
            return redirect()->route('clientmanagement.create');
        }

        $shifts =Shift::get(); 
        return view('clientmanagement.create_step2',compact('user','shifts'));
    }

    public function postStep2(Request $request)
    {
     
        $validatedData = $request->validate([
         
            'sites.*.name' => 'required|string|max:255',
            'sites.*.areas.*.name' => 'required|string|max:255',
            'user_id' => 'required',
            'sites.*.shifts' => 'required|array',
            'sites.*.shifts.*' => 'required|integer|exists:shifts,id',
        ]);
    
        // $client = User::whereId($request->user_id)->first();
        $client = User::find($request->user_id);
        foreach ($validatedData['sites'] as $siteData) {
            $site = $client->sites()->create([
                'name' => $siteData['name'],
                'client_id' => $client->id 
            ]);
            $site->shifts()->attach($siteData['shifts'], ['client_id' => $client->id]);
            foreach ($siteData['areas'] as $areaData) {
                $site->areas()->create([
                    'name' => $areaData['name'],
                    'client_id' => $client->id
                ]);
            }
        }
        $client->client_creation_step_status=2;
        $client->save();
        return redirect()->route('form.step3');
    }

    public function showStep3()
    {
        if (!session()->has('step1') || !session()->has('step2')) {
            return redirect()->route('form.step1');
        }

        return view('form.step3');
    }

    public function postStep3(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $data = array_merge(session('step1'), session('step2'), $request->only('password'));

        // Here you can save the data to the database or process it further
        // User::create($data);

        // Clear the session
        session()->forget(['step1', 'step2']);

        return redirect()->route('form.step1')->with('success', 'Form submitted successfully!');
    }







     public function show(string $id)
     {
         //
     }
 
     /**
      * Show the form for editing the specified resource.
      */
     public function edit(string $id)
     {
        
 
         $data = User::whereId($id)->first();
         $count = 1;
 
         return view('clientmanagement.edit', compact('count', 'data'));
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
         return redirect()->route('clientmanagement.index')->with('success', 'User Update Successfully');
     }

     public function step_2_edit($id)
     {
         $client = User::with('sites.areas', 'sites.shifts')->findOrFail($id);
         $shifts = Shift::all();
 
         return view('clientmanagement.edit_step_2', compact('client', 'shifts'));
     }
     public function step_2_update(Request $request, string $id)
     {
   
            $request->validate([
              
                'sites.*.name' => 'required|string|max:255',
                'sites.*.shifts' => 'required|array',
                'sites.*.shifts.*' => 'exists:shifts,id',
                'sites.*.areas.*.name' => 'required|string|max:255'
            ]);
    
            $client = User::findOrFail($id);
       
    
            $existingSiteIds = $client->sites()->pluck('id')->toArray();
            $submittedSiteIds = array_filter(array_column($request->sites, 'id'));
    
            // Delete removed sites
            $sitesToDelete = array_diff($existingSiteIds, $submittedSiteIds);
            Site::destroy($sitesToDelete);
    
            foreach ($request->sites as $siteData) {
                if (isset($siteData['id'])) {
                    $site = Site::findOrFail($siteData['id']);
                    $site->update(['name' => $siteData['name']]);
                } else {
                    $site = $client->sites()->create(['name' => $siteData['name']]);
                }
                $siteData['shifts'];
              
                $site->shifts()->sync($siteData['shifts']);
 
                $existingAreaIds = $site->areas()->pluck('id')->toArray();
                $submittedAreaIds = array_filter(array_column($siteData['areas'], 'id'));
    
                // Delete removed areas
                $areasToDelete = array_diff($existingAreaIds, $submittedAreaIds);
                Area::destroy($areasToDelete);
    
                foreach ($siteData['areas'] as $areaData) {
                    if (isset($areaData['id'])) {
                        $area = Area::findOrFail($areaData['id']);
                        $area->update(['name' => $areaData['name']]);
                    } else {
                        $site->areas()->create(['name' => $areaData['name']]);
                    }
                }
            }
    
            // return redirect()->route('clients.index')->with('success', 'Client updated successfully!');
        }
  
 
   
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



     public function get_district_on_state_id(Request $request)
     {
         return response()->json(District::where('state_id', $request->id)->get());
     }
 
     public function get_city_on_district_id(Request $request)
     {
         return response()->json(City::where('districtid', $request->id)->get());
     }
}
