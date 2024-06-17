<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    User,
    ComplaintTicket,
    ComplaintReply,
    Client

  
    

};
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
        $complaint = ComplaintTicket::first();
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
            'message' => 'required|string',
        ]);
        $ticket= ComplaintTicket::whereId($request->complaint_ticket_id)->first();
        $ticket->replies()->create($request->all());

        return back();
    }
}
