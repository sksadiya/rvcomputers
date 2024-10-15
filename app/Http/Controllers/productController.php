<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductVariant;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class productController extends Controller
{
    public function create() {
        
    $categories = ProductCategory::all();
    $categoryOptions = (new ProductCategory())->buildCategoryOptions($categories);
    $brands = Brand::all();
    $colors = Color::all();
    $attributes = Attribute::all();
        return view('product.create',compact('categoryOptions','brands','colors','attributes'));
    }
   
    
    public function store(Request $request) {
        dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'brand' => 'nullable|integer|exists:brands,id',
            'unit' => 'nullable|string|max:50',
            'weight' => 'nullable|numeric',
            'min_qty' => 'nullable|integer|min:1',
            'video_provider' => 'nullable|string|max:50',
            'video_link' => 'nullable|string|max:255',
            'unit_price' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'discount_type' => 'in:fixed,percentage',
            'current_stock' => 'required|integer',
            'sku' => 'nullable|string|unique:products,sku',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'low_stock_quantity' => 'nullable|integer',
            'image_url' => 'nullable',
            'category' => 'required|array',
            'tags' => 'nullable|string', 
            'variant_name' => 'nullable|array',
            'variant_price' => 'nullable|array',
            'variant_sku' => 'nullable|array',
            'variant_qty' => 'nullable|array',
            'variant_image_url' => 'nullable|array',
            'gallery_image_url' => 'nullable|array', 
            'colors' => 'nullable|array', 
            'attributes' => 'nullable|array',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $product = new Product();
        $product->name = $request->name;
        $product->brand_id = $request->brand;
        $product->unit = $request->unit;
        $product->weight = $request->weight;
        $product->min_qty = $request->min_qty;
        $product->video_provider = $request->video_provider;
        $product->video_link = $request->video_link;
        $product->unit_price = $request->unit_price;
        $product->discount = $request->discount;
        $product->discount_type = $request->discount_type;
        $product->current_stock = $request->current_stock;
        $product->sku = $request->sku;
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->low_stock_quantity = $request->low_stock_quantity;
        $product->image = $request->image_url;
        $product->save();
        if($request->category) {
            $product->categories()->sync($request->category);
        }
        if($request->colors) {
            $product->colors()->sync($request->colors);
        }
        if ($request->tags) {
            $tagIds = $this->createOrGetTags($request->tags);
            // Debugging line
            \Log::info('Tag IDs:', $tagIds);
            $product->tags()->attach($tagIds);
        }
        return redirect()->back()->with('success' ,'created');

}

    protected function createOrGetTags(string $tagsString): array
    {
        $tags = explode(',', $tagsString);
        $tagIds = [];

        foreach ($tags as $tagName) {
            $tagName = trim($tagName); 
            $tag = Tag::firstOrCreate([
                'name' => $tagName,
                'slug' => \Str::slug($tagName), // Create slug from name
            ]);
            $tagIds[] = $tag->id;
        }

        return $tagIds;
    }
    public function createOrGetAttributes($attributes, $choices)
{
    $attributeIds = [];

    foreach ($attributes as $index => $attributeName) {
        // Check if the attribute already exists by name
        $attribute = Attribute::firstOrCreate([
            'name' => $attributeName, // e.g., "Size" or "Color"
        ]);

        // Get or create the values associated with this attribute
        $choiceValues = $choices[$index]; // This would be the list of values (e.g., "Small", "Medium", etc.)

        foreach ($choiceValues as $valueName) {
            // Check if the value already exists for this attribute
            $attributeValue = AttributeValue::firstOrCreate([
                'attribute_id' => $attribute->id,
                'value' => $valueName, // e.g., "Small", "Medium"
            ]);

            // Store the attribute ID and value ID for later association with the product
            $attributeIds[$attribute->id][] = $attributeValue->id;
        }
    }

    return $attributeIds; // Return attribute IDs with their associated value IDs
}

}
