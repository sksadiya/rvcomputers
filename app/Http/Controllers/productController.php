<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class productController extends Controller
{
    public function create() {
        
    $categories = ProductCategory::all();
    $categoryOptions = (new ProductCategory())->buildCategoryOptions($categories);
    $brands = Brand::all();
        return view('product.create',compact('categoryOptions','brands'));
    }
    public function store(Request $request) {
        dd($request->all());
    }
}
