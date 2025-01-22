<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index()
    {
        return view('subscriber.dashboard'); // Remplacez par la vue pour l'éditeur
    }
}
