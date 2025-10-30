<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;  // ← THIS IMPORT FIXES THE ERROR

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Leaderboard: Top 10 volunteers by points, then tasks
        $leaderboard = User::where('role', 'volunteer')
            ->orderBy('points', 'desc')
            ->orderBy('tasks_completed', 'desc')
            ->take(10)
            ->get();

        return view('home', compact('leaderboard'));
    }
}