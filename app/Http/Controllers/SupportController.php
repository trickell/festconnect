<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;

class SupportController extends BaseController
{
    public function submit_ticket(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        if (session()->has('user')) {
            $data['user_id'] = optional(session('user'))->id;
        }

        try {
            SupportTicket::create($data);
            return response()->json(['status' => 'success', 'message' => 'Your message has been sent to our support team!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to send message: ' . $e->getMessage()]);
        }
    }

    public function index()
    {
        $this->authorizeAdmin();

        $tickets = SupportTicket::orderBy('created_at', 'desc')->get();
        return view('pages.support_admin', compact('tickets'));
    }

    public function reply(Request $request, $id)
    {
        $this->authorizeAdmin();

        $ticket = SupportTicket::findOrFail($id);
        $request->validate(['reply' => 'required|string']);

        $ticket->update([
            'admin_reply' => $request->reply,
            'replied_at' => now(),
            'status' => 'resolved' // Auto resolve on reply for simplicity, or keep open
        ]);

        // Mock Email logic (Since actual mailer might not be configured)
        // Mail::to($ticket->email)->send(new \App\Mail\TicketReply($ticket));

        return response()->json(['status' => 'success', 'message' => 'Reply sent successfully!']);
    }

    public function update_status(Request $request, $id)
    {
        $this->authorizeAdmin();

        $ticket = SupportTicket::findOrFail($id);
        $request->validate(['status' => 'required|in:open,resolved,archived']);

        $ticket->update(['status' => $request->status]);

        return response()->json(['status' => 'success', 'message' => 'Ticket status updated.']);
    }

    private function authorizeAdmin()
    {
        if (!session()->has('user') || optional(session('user'))->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }
    }
}
