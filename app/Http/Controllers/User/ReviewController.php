<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Court;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Court $court)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::updateOrCreate(
            [
                'court_id' => $court->id,
                'user_id' => Auth::id(),
            ],
            [
                'rating' => $request->input('rating'),
                'comment' => $request->input('comment'),
            ]
        );

        return back()->with('success', 'Thank you for your feedback! Review saved.');
    }
}
