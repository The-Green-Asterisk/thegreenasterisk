<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Auth;

class IndexController extends Controller
{
    public function home()
    {
        $posts = BlogPost::where('is_draft', false)->orderByDesc('published_at')->take(5)->get();

        if (env('APP_ENV') === 'production') {
            if (auth()->check() && Auth::user()?->isAdmin()) {
                $socials = new SocialController();
                $social_posts = $socials->buildFeed();

                return view('welcome', compact('posts', 'social_posts'));
            } else {
                return redirect('https://thegreenasterisk.netlify.app/');
            }
        } else {
            $socials = new SocialController();
            $social_posts = $socials->buildFeed();

            // dd($social_posts);

            return view('welcome', compact('posts', 'social_posts'));
        }
    }

    public function about()
    {
        return view('/');
    }

    public function contact()
    {
        return view('contact');
    }

    public function privacy()
    {
        return view('privacy');
    }

    public function tos()
    {
        return view('tos');
    }

    public function deleteFbData()
    {
        return view('delete-fb-data');
    }
}
