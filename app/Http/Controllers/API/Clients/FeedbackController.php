<?php

namespace App\Http\Controllers\API\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Checklist;
use App\Models\Feedback;
use App\Models\SiteShiftAreawithClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    public function getChecklist($id, $date)
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

        $variables = $checklist->variables->map(function ($variable) use ($date) {
            $feedbacks = $variable->feedbacks()
                ->whereDate('created_at', $date)
                ->get();

            return [
                'id' => $variable->id,
                'name' => $variable->name,
                'description' => $variable->description,
                'status' => $variable->status,
                'feedbacks' => $feedbacks
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => [
                'checklist' => $checklist,

                'variables_with_feedbacks' => $variables
            ]
        ], 200);
    }

//     public function getChecklist($id, $date)
// {
//     $user = Auth::guard('clientapi')->user();

//     if ($user->is_employee === 0) {
//         $checklist = Checklist::where('client_id', $user->id)
//             ->with('area', 'variables')
//             ->find($id);
//     } else {
//         $checklist = Checklist::where('client_id', $user->client_id)
//             ->with('area', 'variables')
//             ->find($id);
//     }

//     if (!$checklist) {
//         return response()->json([
//             'status' => 'error',
//             'message' => 'Checklist not found or You are not authorized'
//         ], 403);
//     }

//     $feedbacks = Feedback::with(['checklist', 'variable'])
//         ->where('checklist_id', $id)
//         ->whereDate('created_at', $date)
//         ->get();

//     return response()->json([
//         'status' => 'success',
//         'data' => [
//             'checklist' => $checklist,
//             'feedbacks' => $feedbacks
//         ]
//     ], 200);
// }


public function storeFeedback(Request $request)
{
    $user = Auth::guard('clientapi')->user();

    // Validate the request data
    $validator = Validator::make($request->all(), [
        'checklist_id' => 'required|exists:checklists,id',
        'checklist_variable_id' => 'required|exists:variables,id',
        'rating' => 'required|numeric|between:0,5',
        'status' => 'required|in:pending,completed,revised',
        'remark' => 'nullable|string',
        'media' => 'nullable|string',
    ]);
    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    if ($user->is_employee === 0) {
        $checklist = Checklist::where('client_id', $user->id)
            ->with('area')
            ->find($validator['checklist_id']);
    } else {
        $checklist = Checklist::where('client_id', $user->client_id)
        ->with('area')
        ->find($validator['checklist_id']);
    }


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


    // Create a new feedback
    $feedback = Feedback::create([
        'checklist_id' => $validator['checklist_id'],
        'checklist_variable_id' => $validator['checklist_variable_id'],
        'rating' => $validator['rating'],
        'status' => $validator['status'],
        'rating_given_by' => $user->id, // Assuming the authenticated user is the one giving the rating
        'remark' => $validator['remark'] ?? null,
        'media' => $validator['media'] ?? null,
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Feedback stored successfully',
        'data' => $feedback
    ], 201);
}
}
