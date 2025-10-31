<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    public function redirectToGoogle(Request $request)
    {
        // Save desired role (if any) so callback can assign it
        $role = $request->query('role');
        if ($role) {
            session(['oauth_role' => $role]);
        }

        $callback = route('login.google.callback');
        return Socialite::driver('google')->redirectUrl($callback)->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $callback = route('login.google.callback');
            $googleUser = Socialite::driver('google')->redirectUrl($callback)->stateless()->user();

            $email = $googleUser->getEmail();
            if (! $email) {
                return redirect()->route('login')->with('error', 'Google account has no email.');
            }

            $user = User::where('email', $email)->first();

            $role = session('oauth_role', 'volunteer'); // default volunteer if not provided
            session()->forget('oauth_role');

            if (! $user) {
                $user = User::create([
                    'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Google User',
                    'email' => $email,
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make(Str::random(40)),
                    'avatar' => $googleUser->getAvatar(), // store external URL
                    'role' => in_array($role, ['organization','volunteer']) ? $role : 'volunteer',
                ]);
            } else {
                // update google_id / avatar / role only if missing or a role was explicitly requested
                if (empty($user->google_id)) {
                    $user->google_id = $googleUser->getId();
                }
                if ($googleUser->getAvatar()) {
                    $user->avatar = $googleUser->getAvatar();
                }
                // if session supplied role and user has no role, set it (do not override existing role)
                if (!empty($role) && empty($user->role)) {
                    $user->role = in_array($role, ['organization','volunteer']) ? $role : $user->role;
                }
                $user->save();
            }

            Auth::login($user, true);
            return redirect()->route('profile')->with('success', 'Signed in with Google. Complete your profile.');

        } catch (Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Google sign in failed. Check redirect URI in Google Cloud Console.');
        }
    }
}
