<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function getStatistics() {
        $currentMonth = Carbon::now()->starOfMonth();
        $endOfMonth = $currentMonth->copy()->endOfMonth;

        $totalTickets = Ticket::whereBetween('created_at', [$currentMonth, $endOfMonth])->count();
    }
}