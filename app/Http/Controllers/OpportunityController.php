<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpportunityController extends Controller
{
    public function index()
    {
        $query = Opportunity::with('organization', 'volunteer');

        if (Auth::check() && Auth::user()->role === 'volunteer') {
            $userSkills = json_decode(Auth::user()->skills, true) ?? [];
            $query->where(function ($q) use ($userSkills) {
                foreach ($userSkills as $skill) {
                    $q->orWhere('description', 'LIKE', "%$skill%");
                }
            });
        }

        $opportunities = $query->get();
        return view('opportunities.index', compact('opportunities'));
    }

    public function create()
    {
        return view('opportunities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        Opportunity::create([
            'title' => $request->title,
            'description' => $request->description,
            'organization_id' => Auth::id(),
        ]);

        return redirect()->route('opportunities.index')->with('success', 'Opportunity posted successfully!');
    }

    public function claim($id)
    {
        $opp = Opportunity::findOrFail($id);
        if ($opp->volunteer_id) {
            return back()->with('error', 'Already claimed');
        }
        $opp->update(['volunteer_id' => Auth::id()]);
        return back()->with('success', 'Claimed!');
    }

    public function complete($id)
    {
        $opp = Opportunity::findOrFail($id);

        if ($opp->volunteer_id != Auth::id()) {
            return back()->with('error', 'You can only complete your own tasks.');
        }

        $opp->update(['completed' => true]);

        $user = Auth::user();
        $user->increment('tasks_completed');
        $user->increment('points', 100);   // 100 points per task

        // ---- BADGE LOGIC ----
        $badges = json_decode($user->badges, true) ?? [];

        if ($user->tasks_completed == 1 && !in_array('first_task', $badges)) {
            $badges[] = 'first_task';
        }
        if ($user->tasks_completed >= 5 && !in_array('hero', $badges)) {
            $badges[] = 'hero';
        }
        if ($user->points >= 1000 && !in_array('legend', $badges)) {
            $badges[] = 'legend';
        }

        $user->badges = json_encode(array_unique($badges));
        $user->save();
        // ---------------------

        return back()->with('success', 'Task completed! +100 points');
    }
}