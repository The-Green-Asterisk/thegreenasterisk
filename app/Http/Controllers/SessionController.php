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

        $user = User::updateOrCreate([
            'login_service_id' => $serviceUser->id,
            'email' => $serviceUser->email,
        ], [
            'name' => $serviceUser->name,
            'login_service_token' => $serviceUser->token,
            'login_service_refresh_token' => $serviceUser->refreshToken,
            'avatar' => $serviceUser->avatar,
        ]);

        switch ($service) {
            case 'google':
                $user->google_account = $serviceUser->email;
                break;
            case 'github':
                $user->github_account = "https://github.com/$serviceUser->nickname";
                break;
            case 'facebook':
                $user->facebook_account = "https://facebook.com/$serviceUser->id";
                break;
            case 'twitter':
                $user->twitter_account = "https://twitter.com/$serviceUser->nickname";
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
