<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Certification;
use Barryvdh\DomPDF\Facade\Pdf;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        // Load opportunities posted (for org) or claimed (for volunteer)
        if ($user->role === 'organization') {
                $opportunities = Opportunity::where('organization_id', $user->id)
                    ->with('volunteer')
                    ->latest()
                    ->get();
                $testimonials = [];  // TODO: Add testimonials table later
            } else {
                $opportunities = Opportunity::where('volunteer_id', $user->id)
                    ->with('organization')
                    ->latest()
                    ->get();
                $testimonials = [];
            }

            return view('profile.show', compact('user', 'opportunities', 'testimonials'));
    }
    public function approveCertification($opportunityId)
    {
        $opp = Opportunity::findOrFail($opportunityId);
        if ($opp->organization_id != Auth::id() || $opp->completed) abort(403);

        $cert = Certification::create([
            'opportunity_id' => $opp->id,
            'user_id' => $opp->volunteer_id,
            'organization_id' => Auth::id(),
            'title' => 'Certificate of Completion for ' . $opp->title,
            'message' => 'Thank you for your amazing contribution!',
            'approved' => true,
        ]);

        // Generate PDF
        $pdf = Pdf::loadView('certifications.template', ['cert' => $cert, 'opp' => $opp]);
        $path = 'certs/' . $cert->id . '.pdf';
        $pdf->save(public_path($path));
        $cert->pdf_path = $path;
        $cert->save();

        return back()->with('success', 'Certificate approved and generated!');
    }
    public function update(Request $request)
    {
        $request->validate([
            'avatar' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
            $user->save();
        }
        if ($request->has('skills_input')) {
        $skills = array_map('trim', explode(',', $request->skills_input));
        $user->skills = json_encode(array_unique($skills));
        $user->save();
        }

        return back()->with('success', 'Profile updated!');
    }
}