<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\View\Components\Modal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SessionController extends Controller
{
    public function show()
    {
        $modal = new Modal(
            'Login',
            view('components.modal.modals.login.login'),
            false,
            false
        );

        return $modal->render();
    }

    public function create($service)
    {
        return Socialite::driver($service)->redirect();
    }

    public function store($service)
    {
        $serviceUser = Socialite::driver($service)->user();

        $user = new User();

        switch ($service) {
            case 'google':
                $user = User::where('google_account', $serviceUser->id)->first();
                if ($user) {
                    break;
                } else if (User::where('email', $serviceUser->email)->first()) {
                    $user = User::where('email', $serviceUser->email)->first();
                    $user->google_account = $serviceUser->id;
                    $user->save();
                } else {
                    User::insert([
                        'name' => $serviceUser->name,
                        'email' => $serviceUser->email,
                        'google_account' => $serviceUser->id,
                    ]);

                    $user = User::where('google_account', $serviceUser->id)->first();
                    $user->save();
                }
                break;
            case 'github':
                $user = User::where('github_account', $serviceUser->id)->first();
                if ($user) {
                    break;
                } else if (User::where('email', $serviceUser->email)->first()) {
                    $user = User::where('email', $serviceUser->email)->first();
                    $user->github_account = $serviceUser->id;
                    $user->save();
                } else {
                    User::insert([
                        'name' => $serviceUser->name,
                        'email' => $serviceUser->email,
                        'github_account' => $serviceUser->id,
                    ]);

                    $user = User::where('github_account', $serviceUser->id)->first();
                    $user->save();
                }
                break;
            case 'facebook':
                $user = User::where('facebook_account', $serviceUser->id)->first();
                if ($user) {
                    break;
                } else if (User::where('email', $serviceUser->email)->first()) {
                    $user = User::where('email', $serviceUser->email)->first();
                    $user->facebook_account = $serviceUser->id;
                    $user->save();
                } else {
                    User::insert([
                        'name' => $serviceUser->name,
                        'email' => $serviceUser->email,
                        'facebook_account' => $serviceUser->id,
                    ]);

                    $user = User::where('facebook_account', $serviceUser->id)->first();
                    $user->save();
                }
                break;
            case 'twitter':
                $user = User::where('twitter_account', $serviceUser->id)->first();
                if ($user) {
                    break;
                } else if (User::where('email', $serviceUser->email)->first()) {
                    $user = User::where('email', $serviceUser->email)->first();
                    $user->twitter_account = $serviceUser->id;
                    $user->save();
                } else {
                    User::insert([
                        'name' => $serviceUser->name,
                        'email' => $serviceUser->email,
                        'twitter_account' => $serviceUser->id,
                    ]);

                    $user = User::where('twitter_account', $serviceUser->id)->first();
                    $user->save();
                }
                break;
        }

        Auth::login($user);

        return redirect('/');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
