<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\Membership;
use App\Models\Tournament;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $courts = Court::with('images')->take(4)->get();
        $tournaments = Tournament::where('status', 'upcoming')
            ->orderBy('start_date', 'asc')
            ->take(3)
            ->get();
        $memberships = Membership::orderBy('price', 'asc')->get();
        $reviews = Review::with(['court', 'user'])->latest()->take(3)->get();

        return view('home', compact('courts', 'tournaments', 'memberships', 'reviews'));
    }
}
