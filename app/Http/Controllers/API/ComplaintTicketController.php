<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ComplaintTicket;
use Illuminate\Support\Facades\Validator;

class ComplaintTicketController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'nullable|exists:employees,id',
            'client_id' => 'required|exists:clients,id',
            'complainer_id' => 'required|exists:clients,id',
            'subject' => 'required|string',
            'opened_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'closed_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'opened_description' => 'nullable|string',
            // 'closed_description' => 'nullable|string',
            // 'ticket_status' => 'required|in:opned,closed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        if ($request->hasFile('opened_image')) {
            $imageName = time() . uniqid() . '.' . $request->opened_image->extension();
            $request->opened_image->move('assets/images/opened_image', $imageName);
            $data['opened_image']  = 'opened_image/'.$imageName;
          
    
            }
    

        if ($request->hasFile('closed_image')) {
            $data['closed_image'] = $request->file('closed_image')->store('complaints', 'public');
        }
        $data['ticket_status']='opned';
        
        $complaint = ComplaintTicket::create($data);

        return response()->json(['complaint' => $complaint], 201);
    }
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
           
           
            'closer_id' => 'required|exists:users,id',
            
            'closed_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            
            'closed_description' => 'nullable|string',
        
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        if ($request->hasFile('closed_image')) {
            $imageName = time() . uniqid() . '.' . $request->closed_image->extension();
            $request->closed_image->move('assets/images/closed_image', $imageName);
            $data['closed_image']  = 'closed_image/'.$imageName;
          
    
            }
    

      
        $data['ticket_status']='closed';
        
        $complaint = ComplaintTicket::whereId($id)->update($data);

        return response()->json(['complaint' => $complaint], 201);
    }
}
