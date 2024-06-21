<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public function list()
    {
        $pages = Page::inRandomOrder()->paginate(7);

        return view('list', compact('pages'));
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->first();

        return view('page', compact('page'));
    }
}

