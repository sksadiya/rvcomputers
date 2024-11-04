<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $reviews = Review::where('status', 1)->get();
        $averageRating = Review::where('status', 1)->avg('rating');
        // Format the average rating to 1 decimal place
        $averageRating = number_format($averageRating, 1);
        $colors = Color::pluck('code')->toArray();
        return view('front.index' ,compact('reviews','averageRating','colors'));
    }
}
