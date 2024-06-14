<?php

namespace App\Http\Controllers\API\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Checklist;
use App\Models\SiteShiftAreawithClient;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function getChecklist($id)
    {

        $user = Auth::guard('clientapi')->user();
        if ($user->is_employee === 0) {
            $checklist = Checklist::where('client_id', $user->id)->with('area')->find($id);
        } else {

            $checklist = Checklist::where('client_id', $user->client_id)->with('area')->find($id);

            // Check if the checklist details exist
            if (!$checklist) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Checklist not found'
                ], 404);
            }

            // Get the area_id from the checklist details
            $areaId = $checklist->area_id;

            // Fetch the site_id associated with the area_id using pivot table
            $siteId = SiteShiftAreawithClient::where('area_id', $areaId)->value('site_id');
            $lines = is_array($user->lines) ? $user->lines : json_decode($user->lines, true);

            // Check if the user has permission to access the site based on site_id
            if (!in_array($siteId, $lines)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized access'
                ], 403);
            }
        }

        if (!$checklist) {
            return response()->json([
                'status' => 'error',
                'message' => 'Checklist not found or You are not Authorised'
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'data' => $checklist
        ], 200);
    }



    public function storeFeedback(Request $request){
        $user = Auth::guard('clientapi')->user();
        if ($user->is_employee === 0) {

        }else{

        }
    }
}
