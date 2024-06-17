<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TrixImageUploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image',
        ]);

        $media = $request->file('file')->store('uploads', 'public');

        return response()->json([
            'url' => asset('storage/' . $media),
        ]);
    }
}

