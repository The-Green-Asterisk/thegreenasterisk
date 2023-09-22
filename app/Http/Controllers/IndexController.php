<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;

class IndexController extends Controller
{
    public function home()
    {
        $posts = BlogPost::where('is_draft', false)->whereDoesntHave('tags', function ($query) {
            $query->where('name', 'featured');
        })->orderByDesc('published_at')->take(6)->get();
        $featured_posts = BlogPost::where('is_draft', false)->whereHas('tags', function ($query) {
            $query->where('name', 'featured');
        })->orderByDesc('published_at')->get();

        $posts = $featured_posts->merge($posts);

        $socials = new SocialController();
        $social_posts = $socials->buildFeed();

        return view('welcome', compact('posts', 'social_posts'));
    }

    public function about()
    {
        return view('about');
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
