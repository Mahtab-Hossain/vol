<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\Opportunity;
use App\Models\Testimonial;
use App\Models\User;

class OpportunityController extends Controller
{
	// List opportunities (simple implementation)
	public function index()
	{
		// eager load relations if available; fall back to simple query
		$opportunities = Opportunity::with(['organization','volunteer','testimonial'])->paginate(10);
		return view('opportunities.index', compact('opportunities'));
	}

	// Show create form
	public function create()
	{
		return view('opportunities.create');
	}

	// Store a new opportunity (minimal validation)
	public function store(Request $request)
	{
		$data = $request->validate([
			'title' => 'required|string|max:255',
			'description' => 'required|string',
		]);

		$opp = new Opportunity($data);

		// persist who posted this opportunity: prefer organization_id if available
		if (Auth::check()) {
			if (Schema::hasColumn('opportunities', 'organization_id')) {
				$opp->organization_id = Auth::id();
			} elseif (Schema::hasColumn('opportunities', 'user_id')) {
				// legacy column
				$opp->user_id = Auth::id();
			} else {
				// no known owner column — leave as-is (or handle differently)
			}
		}

		$opp->save();

		return redirect()->route('opportunities.index')->with('success', 'Opportunity created.');
	}

	// Claim an opportunity (mark as claimed by current user)
	public function claim($id)
	{
		$opp = Opportunity::findOrFail($id);
		if (! Auth::check()) {
			return redirect()->route('opportunities.index')->with('error', 'Unauthorized.');
		}
		$opp->volunteer_id = Auth::id();
		$opp->save();

		return redirect()->back()->with('success', 'Opportunity claimed.');
	}

	// Mark an opportunity complete
	public function complete($id)
	{
		$opp = Opportunity::findOrFail($id);

		// Only the volunteer who claimed it or the organization can mark complete
		$userId = Auth::id();
		if ($opp->volunteer_id && $userId !== $opp->volunteer_id && $userId !== $opp->organization_id) {
			return redirect()->back()->with('error', 'Unauthorized to mark this as complete.');
		}

		$opp->completed = true;
		$opp->completed_at = now();
		$opp->save();

		// Award points and increment tasks_completed safely
		if ($opp->volunteer_id) {
			$vol = User::find($opp->volunteer_id);
			if ($vol) {
				// Points: prefer opportunity-defined points, fallback to 10
				$pointsAwarded = $opp->points ?? 10;

				if (Schema::hasColumn('users', 'points')) {
					$vol->points = ($vol->points ?? 0) + $pointsAwarded;
				}
				if (Schema::hasColumn('users', 'tasks_completed')) {
					$vol->tasks_completed = ($vol->tasks_completed ?? 0) + 1;
				}
				$vol->save();
			}
		}

		return redirect()->back()->with('success', 'Opportunity marked as completed.');
	}

	// Store a testimonial for an opportunity
	public function storeTestimonial(Request $request, $id)
	{
		$request->validate([
			'rating' => 'required|integer|min:1|max:5',
			'comment' => 'nullable|string|max:1000',
		]);

		$opp = Opportunity::findOrFail($id);

		// Resolve organization id robustly
		$orgId = $opp->organization_id ?? $opp->user_id ?? null;

		// Prevent duplicate testimonials: update if the volunteer already submitted one for this opportunity
		$testimonial = Testimonial::where('opportunity_id', $opp->id)
			->where('volunteer_id', Auth::id())
			->first();

		$payload = [
			'opportunity_id' => $opp->id,
			'volunteer_id' => Auth::id(),
			'organization_id' => $orgId,
			'rating' => $request->rating,
			'comment' => $request->comment,
		];

		if ($testimonial) {
			$testimonial->update($payload);
		} else {
			Testimonial::create($payload);
		}

		// Redirect volunteer to their profile with success message (per UX request)
		return redirect()->route('profile')->with('success', 'Thank you for your feedback.');
	}

	// Show testimonial form (GET)
	public function showTestimonial($id)
	{
		$opp = Opportunity::with('organization')->findOrFail($id);

		// Only allow volunteer who claimed it (or allow orgs to view as needed)
		if (! Auth::check() || (Auth::id() !== $opp->volunteer_id && Auth::user()->role !== 'organization')) {
			abort(403);
		}

		return view('opportunities.testimonial', compact('opp'));
	}
}