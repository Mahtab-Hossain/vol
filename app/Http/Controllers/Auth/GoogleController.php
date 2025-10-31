<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        // ensure redirect_uri matches the named route exactly
        $callback = route('login.google.callback');
        return Socialite::driver('google')->redirectUrl($callback)->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $callback = route('login.google.callback');
            // ensure Socialite uses the same redirect when exchanging code
            $googleUser = Socialite::driver('google')->redirectUrl($callback)->stateless()->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Google User',
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make(Str::random(40)), // random secure password
                    'avatar' => $googleUser->getAvatar(),
                    'role' => 'volunteer', // default role — allow editing later
                ]);
            } else {
                // Keep google_id in sync for existing users
                if (empty($user->google_id)) {
                    $user->google_id = $googleUser->getId();
                    $user->save();
                }
            }

            Auth::login($user, true);
            return redirect()->route('profile')->with('success', 'Signed in with Google. Please complete your profile.');

        } catch (Exception $e) {
            // log($e->getMessage()); // optional: log for debugging
            return redirect()->route('login')
                ->with('error', 'Google sign in failed. Please check your Google Cloud Console redirect URI and try again.');
        }
    }
}
