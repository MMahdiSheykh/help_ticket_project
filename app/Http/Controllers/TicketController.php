<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $tickets = Ticket::all();
        $user_tickets = [];

        foreach ($tickets as $ticket) {
            if ($ticket->user_id == $user->id){
                array_unshift($user_tickets,$ticket);
            }
        }

        return view('ticket.index', compact('user_tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ticket.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {

        $ticket = Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id()
        ]);

        if ($request->file('attachment')) {
            $extension = $request->file('attachment')->extension();
            $content = file_get_contents($request->file('attachment'));
            $filename = Str::random(25);
            $path = "attachments/$filename.$extension";

            Storage::disk('public')->put($path, $content);

            $ticket->update(['attachment', $path]);
        }

        return response()->redirectToRoute('ticket.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return view('ticket.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect(route('ticket.index'));
    }
}
