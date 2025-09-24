<?php

namespace App\Http\Controllers;

use App\Http\Resources\TicketResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TicketStoreRequest;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function index(Request $request) {
        $query = Ticket::query();

        $query->orderBy('created_at', 'desc');

        if ($request->search) {
            $query->where('code', 'like', '%' . $request->search . '%')
                ->onWhere('code', 'like', '%' . $request->search . '%');
        }

        if ($request->status) {
            $query->where('status' . $request->status);
        }
    }
    
    public function store(TicketStoreRequest $request) {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $ticket = new Ticket;
            $ticket->user_id = auth()->user()->id;
            $ticket->code = 'TIC-' . rand(10000, 99999);
            $ticket->title = $data['title'];
            $ticket->description = $data['description'];
            $ticket->priority = $data['priority'];
            $ticket->save();

            DB::commit();

            return response()->json([
                'message' => 'Ticket berhasil ditambahkan',
                'data' => new TicketResource($ticket),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Terjadi Kesalahan',
                'data' => null,
            ], 500);
        }
    }
}