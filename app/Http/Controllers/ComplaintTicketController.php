<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    User,
    ComplaintTicket,
    ComplaintReply,
    Client

  
    

};
use Auth;
class ComplaintTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

              $search_feild['client_id'] = $request->client_id;

    $clients=Client::where('is_employee',0)->orderBy('name')->get();

        $data = ComplaintTicket::latest()->get();


        $count = 1;
        return view('complainttickets.index', compact('data', 'count','clients','search_feild'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $complaint = ComplaintTicket::whereId($id)->first();
        $count = 1;
        return view('complainttickets.show', compact('complaint', 'count'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ComplaintTicket::whereId($id)->delete();
        return response()->json(['success' => true, 'message' => 'User deleted successfully']);
    }

    public function reply(Request $request)
    {
        $request->validate([
            'message' => 'nullable|string',
            'complaint_ticket_id' => 'integer|exists:complaint_tickets,id',
            // 'attachment' => 'nullable|file|mimes:jpg,png,pdf,doc,docx,txt|max:2048',
            'attachment' => 'nullable|file|max:2048',
        ]);

        $message = $request->input('message');
        $attachment = $request->hasFile('attachment');

        if (!$message && !$attachment) {
            return response()->json(['error' => 'Either message or attachment is required.'], 400);
        }
        $ticket= ComplaintTicket::whereId($request->complaint_ticket_id)->first();
        $data=$request->all();
        $data['sender_id']=Auth::user()->id;
        $data['sending_by']='user';
        if ($request->hasFile('attachment')) {
            $imageName = time() . uniqid() . '.' . $request->attachment->extension();
            $request->attachment->move('assets/images/tickets', $imageName);
            $data['attachment']= 'tickets/'.$imageName;
           
    
            }
        // $ticket->replies()->create($data);
       $complaint= ComplaintReply::create($data);

        return response()->json([
            'success' => 'Message sent successfully.',
            'message' => $message,
            'created_at'=>$complaint->created_at->format('d-m-Y h:i A'),
            'attachment' => $complaint->attachment!=null ? asset('assets/images/'.$complaint->attachment): null
        ], 200);
    }
}
