<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Airport;

class AirportController extends Controller
{
    public function index() {
        $airports = Airport::all()->sortBy('name');

        return view('home', compact('airports'));
    }
}
