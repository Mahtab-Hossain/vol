<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\Certification;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Testimonial;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if ($user->role === 'organization') {
            $opportunities = Opportunity::where('organization_id', $user->id)
                ->with(['volunteer','testimonial'])
                ->latest()
                ->get();
            $testimonials = Testimonial::where('organization_id', $user->id)
                ->with('volunteer')
                ->latest()
                ->get();
            $averageRating = $testimonials->avg('rating') ?? 0;
            $certifications = [];  // Orgs don't have certs
        } else {
            // For volunteer show completed/claimed tasks — include organization and testimonial for quick checks
            $opportunities = Opportunity::where('volunteer_id', $user->id)
                ->with(['organization','testimonial'])
                ->latest()
                ->get();

            $testimonials = [];
            $averageRating = 0;
            $certifications = collect();

            // Determine which column the certifications table uses for the volunteer/user reference
            $certColumn = null;
            if (Schema::hasColumn('certifications', 'volunteer_id')) {
                $certColumn = 'volunteer_id';
            } elseif (Schema::hasColumn('certifications', 'user_id')) {
                $certColumn = 'user_id';
            } elseif (Schema::hasColumn('certifications', 'recipient_id')) {
                $certColumn = 'recipient_id';
            }

            if ($certColumn) {
                $certifications = Certification::where($certColumn, $user->id)
                    ->where('approved', true)
                    ->with('organization', 'opportunity')
                    ->latest()
                    ->get();
            } else {
                $certifications = collect();
            }
        }

        return view('profile.show', compact('user', 'opportunities', 'testimonials', 'averageRating', 'certifications'));
    }

    public function approveCertification($opportunityId)
    {
        $user = Auth::user();
        $opp = Opportunity::findOrFail($opportunityId);

        if ($opp->organization_id != Auth::id() || !$opp->completed || $opp->volunteer_id == null) {
            return back()->with('error', 'Cannot approve this task.');
        }

        // Check if cert already exists
        $existingCert = Certification::where('opportunity_id', $opp->id)->first();
        if ($existingCert) {
            return back()->with('info', 'Certificate already approved.');
        }

        // Create cert with correct column names from migration
        $cert = Certification::create([
            'opportunity_id' => $opp->id,
            'user_id' => $opp->volunteer_id, // volunteer's user_id
            'organization_id' => Auth::id(),
            'title' => 'Certificate of Completion - ' . $opp->title,
            'message' => 'Thank you for your outstanding contribution to ' . $user->name . '!',
            'approved' => true,
        ]);

        // Generate PDF with correct storage path
        try {
            $pdf = Pdf::loadView('certifications.template', [
                'cert' => $cert,
                'opp' => $opp,
                'volunteer' => $opp->volunteer ?? \App\Models\User::find($opp->volunteer_id),
                'org' => $user,
            ]);
            
            // Store in storage/app/public/certs
            $fileName = 'certs/' . $cert->id . '.pdf';
            $pdf->save(storage_path('app/public/' . $fileName));
            $cert->pdf_path = $fileName;
            $cert->save();
        } catch (\Throwable $e) {
            // continue gracefully if PDF generation fails
        }

        return back()->with('success', 'Certificate approved and sent to volunteer!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'skills_input' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && file_exists(storage_path('app/public/' . $user->avatar))) {
                unlink(storage_path('app/public/' . $user->avatar));
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        if ($request->has('skills_input')) {
            $skills = array_filter(array_map('trim', explode(',', $request->skills_input)));
            $user->skills = json_encode($skills);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    public function downloadCertificate($id)
    {
        $cert = Certification::with(['opportunity', 'volunteer', 'organization'])->findOrFail($id);

        if (! Auth::check() || (Auth::id() != $cert->user_id && Auth::id() != $cert->organization_id)) {
            abort(403);
        }

        // Ensure certs directory exists in storage/app/public
        $storageDir = storage_path('app/public/certs');
        if (! is_dir($storageDir)) {
            mkdir($storageDir, 0755, true);
        }

        // If pdf_path missing or file not present, generate the PDF and save to storage/app/public/certs
        $fileName = $cert->pdf_path ? trim($cert->pdf_path, "/") : null;
        $filePath = $fileName ? storage_path('app/public/' . $fileName) : null;

        if (! $filePath || ! file_exists($filePath)) {
            // build filename and full path
            $fileName = 'certs/' . $cert->id . '.pdf';
            $filePath = storage_path('app/public/' . $fileName);

            try {
                $pdf = Pdf::loadView('certifications.template', [
                    'cert' => $cert,
                    'opp' => $cert->opportunity,
                    'volunteer' => $cert->volunteer,
                    'org' => $cert->organization,
                ]);
                $pdf->save($filePath);

                // persist generated path if model has column
                if (Schema::hasColumn('certifications', 'pdf_path')) {
                    $cert->pdf_path = $fileName;
                    $cert->save();
                }
            } catch (\Throwable $e) {
                // PDF generation failed — return 404 so caller sees a clear error
                abort(404, 'Certificate file not available.');
            }
        }

        if (! file_exists($filePath)) {
            abort(404, 'Certificate file not found.');
        }

        // Send with friendly filename
        $downloadName = Str::slug($cert->title ?: 'certificate') . '-' . $cert->id . '.pdf';
        return response()->download($filePath, $downloadName, ['Content-Type' => 'application/pdf']);
    }
}