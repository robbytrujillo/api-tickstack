<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TicketStoreRequest;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function store(TicketStoreRequest $request) {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $ticket = new Ticket;
            $ticket->user_id = auth()->user->id;
            $ticket->code = 'TIC-' . rand(10000, 99999);
            $ticket->title = $data['title'];
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}