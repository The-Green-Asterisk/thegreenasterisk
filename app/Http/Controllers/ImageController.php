<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $path = '/storage/'.$file->store('images');

            return response()->json(['location' => asset($path), 'success' => true], 200);
        }

        return response()->json(['error' => 'Invalid File or File not found'], 400);
    }
}
