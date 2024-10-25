<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;

class shopController extends Controller
{
   public function index(Request $request) {
    $perPage = $request->input('per_page', 10); 
    $sortOrder = $request->input('sort_order', 'latest'); 
    $categorySlug = $request->input('category'); 
    $colorId = $request->input('color');
    $brandsArray = [];
    $priceRanges = $request->input('price', []);
    $query = Product::query();

    if ($categorySlug) {
        $query->whereHas('categories', function($q) use ($categorySlug) {
            $q->where('slug', $categorySlug); // Assuming your category has a slug
        });
    }
   
    if ($request->has('tag')) {
        $tagId = $request->get('tag');
        $query->whereHas('tags', function ($q) use ($tagId) {
            $q->where('tags.slug', $tagId);
        });
    }

    if ($request->has('brands') && !empty($request->input('brands'))) {
        $brandsArray = $request->input('brands'); // Get brands directly as an array
        $query->whereIn('brand_id', $brandsArray);
    }
     // Filter by color
     if ($colorId) {
        $query->whereHas('colors', function($q) use ($colorId) {
            $q->where('colors.id', $colorId);  // Ensure `colors.id` is specified explicitly
        });
    }
    if ($sortOrder === 'oldest') {
        $query->oldest(); 
    } else {
        $query->latest(); 
    }

    if (!empty($priceRanges)) {
        foreach ($priceRanges as $range) {
            list($min, $max) = explode('-', $range);
            $min = (float) $min;
            $max = (float) $max;
            $query->orWhereBetween('unit_price', [$min, $max]);
        }
    }
    $shopProducts = $query->paginate($perPage);
    $colors = Color::all();
        return view('front.shop' ,compact('shopProducts','colors','brandsArray'));
   }
}
