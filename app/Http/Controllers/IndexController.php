<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function home()
    {
        if (env('APP_ENV') === 'production' && ! auth()->user()->isAdmin()) {
            return redirect('https://thegreenasterisk.netlify.app/');
        } else {
            return view('welcome');
        }
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
