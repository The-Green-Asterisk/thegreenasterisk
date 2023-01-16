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
        return Socialite::driver($service)->stateless()->redirect();
    }

    public function store($service)
    {
        $serviceUser = Socialite::driver($service)->stateless()->user();

        $user = User::updateOrCreate([
            'email' => $serviceUser->email,
        ], [
            'login_service_id' => $serviceUser->id,
            'name' => $serviceUser->name,
            'login_service_token' => $serviceUser->token,
            'login_service_refresh_token' => $serviceUser->refreshToken,
            'avatar' => $serviceUser->avatar,
        ]);

        switch ($service) {
            case 'google':
                $user->google_account = $serviceUser->id;
                break;
            case 'github':
                $user->github_account = $serviceUser->id;
                break;
            case 'facebook':
                $user->facebook_account = $serviceUser->id;
                break;
            case 'twitter-oauth-2':
                $user->twitter_account = $serviceUser->id;
                break;
        }
        $user->save();

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
