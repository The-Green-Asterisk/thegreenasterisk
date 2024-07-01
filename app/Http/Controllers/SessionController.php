<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\View\Components\Modal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Storage;

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
        return Socialite::driver($service)->scopes($service == 'facebook' ?['email', 'user_posts']:[])->stateless()->redirect();
    }

    public function store($service)
    {
        $serviceUser = Socialite::driver($service)->scopes($service == 'facebook' ?['email', 'user_posts']:[])->stateless()->user();
        if (empty($serviceUser->avatar)) {
            $serviceUser->avatar = 'https://www.gravatar.com/avatar/'.md5(strtolower(trim($serviceUser->email))).'?d=mp';
        }
        Storage::put('images/avatars/'.$serviceUser->id.'.jpg', file_get_contents($serviceUser->avatar));
        $serviceUser->avatar = Storage::url('images/avatars/'.$serviceUser->id.'.jpg');

        $user = User::updateOrCreate([
            'email' => $serviceUser->email,
        ], [
            'name' => User::where('email', $serviceUser->email)?->first()->name ?? $serviceUser->name,
            'login_service_token' => $serviceUser->token,
            'login_service_refresh_token' => $serviceUser->refreshToken,
            'avatar' => $serviceUser->avatar,
        ]);

        switch ($service) {
            case 'google':
                $user->google_account = $serviceUser->id;
                $user->google_token = $serviceUser->token;
                break;
            case 'github':
                $user->github_account = $serviceUser->id;
                $user->github_token = $serviceUser->token;
                break;
            case 'facebook':
                $user->facebook_account = $serviceUser->id;
                $user->facebook_token = $serviceUser->token;
                break;
            case 'twitter-oauth-2':
                $user->twitter_account = $serviceUser->id;
                $user->twitter_token = $serviceUser->token;
                break;
        }
        $user->save();

        Auth::login($user, true);

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
