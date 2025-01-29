<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $posts = Post::all();

        return view('subscriber.profil.dashboard', compact('categories', 'posts'));
    }
}

