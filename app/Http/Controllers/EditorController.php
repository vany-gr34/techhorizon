<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EditorController extends Controller
{
    public function index()
    {
        return view('editor.dashboard'); // Remplacez par la vue pour l'éditeur
    }
}
