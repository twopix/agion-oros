<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class HomeController extends Controller
{
    public function index()
    {
        $randomPages = Page::inRandomOrder()->limit(7)->get();

        return view('home', compact('randomPages'));
    }
}

