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

        $user = User::where('login_service_id', $serviceUser->id)->first();

        switch ($service) {
            case 'google':
                if ($user) {
                    continue;
                } else if (User::where('email', $serviceUser->email)->first()) {
                    $user = User::where('email', $serviceUser->email)->first();
                    $user->login_service_id = $serviceUser->id;
                    $user->google_account = $serviceUser->id;
                    $user->avatar = $serviceUser->avatar;
                    $user->save();
                } else {
                    $user = new User([
                        'name' => $serviceUser->name,
                        'email' => $serviceUser->email,
                        'google_account' => $serviceUser->id,
                        'login_service_id' => $serviceUser->id,
                        'avatar' => $serviceUser->avatar
                    ]);
                    $user->save();
                }
                break;
            case 'github':
                if ($user) {
                    continue;
                } else if (User::where('email', $serviceUser->email)->first()) {
                    $user = User::where('email', $serviceUser->email)->first();
                    $user->github_account = $serviceUser->id;
                    $user->avatar = $serviceUser->avatar;
                    $user->save();
                } else {
                    $user = new User([
                        'name' => $serviceUser->name,
                        'email' => $serviceUser->email,
                        'github_account' => $serviceUser->id,
                        'login_service_id' => $serviceUser->id,
                        'avatar' => $serviceUser->avatar,
                    ]);

                    $user->save();
                }
                break;
            case 'facebook':
                if ($user) {
                    continue;
                } else if (User::where('email', $serviceUser->email)->first()) {
                    $user = User::where('email', $serviceUser->email)->first();
                    $user->facebook_account = $serviceUser->id;
                    $user->login_service_id = $serviceUser->id;
                    $user->avatar = $serviceUser->avatar;
                    $user->save();
                } else {
                    $user = new User([
                        'name' => $serviceUser->name,
                        'email' => $serviceUser->email,
                        'facebook_account' => $serviceUser->id,
                        'login_service_id' => $serviceUser->id,
                        'avatar' => $serviceUser->avatar
                    ]);

                    $user->save();
                }
                break;
            case 'twitter-oauth-2':
                if ($user) {
                    continue;
                } else if (User::where('email', $serviceUser->email)->first()) {
                    $user = User::where('email', $serviceUser->email)->first();
                    $user->twitter_account = $serviceUser->id;
                    $user->login_service_id = $serviceUser->id;
                    $user->avatar = $serviceUser->avatar;
                    $user->save();
                } else {
                    $user = new User([
                        'name' => $serviceUser->name,
                        'email' => $serviceUser->email,
                        'twitter_account' => $serviceUser->id,
                        'login_service_id' => $serviceUser->id,
                        'avatar' => $serviceUser->avatar
                    ]);

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
