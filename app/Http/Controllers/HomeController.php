<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;

class HomeController extends Controller
{

    public function index()
    {
        $albums = Album::latest()->take(3)->get(); // últimos 3
        return view('home', compact('albums'));
    }

}
