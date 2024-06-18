<?php

namespace App\Http\Controllers\API\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\ClientDetail;
use App\Models\Site;
use Illuminate\Support\Facades\Validator;

use App\Http\Resources\SiteResource;

class DataController extends Controller
{
    public function getAllSites(){
        $user = Auth::guard('clientapi')->user();
        if($user->is_employee === 0){
            $sites = Site::where('client_id', $user->id)->where('status', 1)->get();
        }else{
            $assignedSiteIds = json_decode($user->lines); // Assuming `lines` is an array of site IDs
            $sites = Site::whereIn('id', $assignedSiteIds)->where('status', 1)->get();
        }
        return response()->json([
            'status' => 'success',
            'data' => SiteResource::collection($sites)
        ], 200);
    }

    public function getAllSiteswithRelations(){
        $user = Auth::guard('clientapi')->user();
        if($user->is_employee === 0){
            $sites = Site::where('client_id', $user->id)->where('status', 1)->with(['shifts.areas.checklists'])->get();
        }else{
            $assignedSiteIds = json_decode($user->lines); // Assuming `lines` is an array of site IDs
            $sites = Site::whereIn('id', $assignedSiteIds)->where('status', 1)->with(['shifts.areas.checklists'])->get();
        }

        return response()->json([
            'status' => 'success',
            'data' => SiteResource::collection($sites)
        ], 200);
    }

}
