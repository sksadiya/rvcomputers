<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;

class shopController extends Controller
{
   public function index(Request $request) {
    $shopProducts = Product::latest()->paginate(12);
    // Fetch all distinct colors used across all products
    $colors = Color::whereIn('id', function ($query) {
        $query->select('color_id')->from('product_color')->distinct();
    })->get();

        return view('front.shop' ,compact('shopProducts','colors'));
   }
}
