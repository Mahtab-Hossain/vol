<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index()
    {
        $volunteers = User::where('role', 'volunteer')
            ->orderBy('points', 'desc')
            ->orderBy('tasks_completed', 'desc')
            ->paginate(10);

        $organizations = User::where('role', 'organization')
            ->withCount('opportunities')
            ->orderBy('opportunities_count', 'desc')
            ->orderBy('verified', 'desc')
            ->paginate(10);

        return view('leaderboard.index', compact('volunteers', 'organizations'));
    }
}
