<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ComplaintTicket;
use Auth;
use Illuminate\Support\Facades\Validator;

class ComplaintTicketController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'nullable|exists:employees,id',
            'user_id' => 'nullable|exists:users,id',
            'client_id' => 'required|exists:clients,id',
            'site_id' => 'required|exists:sites,id',
            'shift_id' => 'required|exists:shifts,id',
            // 'complainer_id' => 'required|exists:clients,id',
            'subject' => 'required|string',
            // 'opened_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'closed_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'opened_description' => 'nullable|string',
            // 'closed_description' => 'nullable|string',
          
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        // if ($request->hasFile('opened_image')) {
        //     $imageName = time() . uniqid() . '.' . $request->opened_image->extension();
        //     $request->opened_image->move('assets/images/opened_image', $imageName);
        //     $data['opened_image']  = 'opened_image/'.$imageName;
          
    
        //     }
    

     
        $data['ticket_status']='opened';
        $data['complainer_id']=Auth::guard('clientapi')->user()->id;

        
        $complaint = ComplaintTicket::create($data);

        return response()->json(['complaint' => $complaint], 201);
    }
    public function closed(Request $request,$id)
    {
        // $validator = Validator::make($request->all(), [
        //     'closer_id' => 'required|exists:users,id',

        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }

        // $data = $request->all();

     
    

      
        $data['ticket_status']='closed';
        $data['closer_id']=Auth::guard('userapi')->user()->id;
        
        $complaint = ComplaintTicket::whereId($id)->update($data);

        return response()->json(['complaint' => $complaint], 201);
    }
}
