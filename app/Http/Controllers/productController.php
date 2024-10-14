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
        // dd($request->all());
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
            'current_stock' => 'nullable|integer',
            'sku' => 'nullable|string|unique:products,sku',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'low_stock_quantity' => 'nullable|integer',
            'image_url' => 'nullable|url',
            'category' => 'required|array',
            'tags' => 'nullable|string', // Assuming tags are a comma-separated string
            'variant_name' => 'nullable|array',
            'variant_price' => 'nullable|array',
            'variant_sku' => 'nullable|array',
            'variant_qty' => 'nullable|array',
            'variant_image_url' => 'nullable|array',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $product = Product::create([
            'name' => $request->name,
            'brand_id' => $request->brand,
            'unit' => $request->unit,
            'weight' => $request->weight,
            'min_qty' => $request->min_qty,
            'video_provider' => $request->video_provider,
            'video_link' => $request->video_link,
            'unit_price' => $request->unit_price,
            'discount' => $request->discount,
            'discount_type' => $request->discount_type,
            'current_stock' => $request->current_stock,
            'sku' => $request->sku,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'low_stock_quantity' => $request->low_stock_quantity,
            'image' => $request->image_url,
        ]);
        if ($request->has('category')) {
            $product->categories()->attach($request->category);
        }

        if ($request->tags) {
            $tagIds = $this->createOrGetTags($request->tags);
            // Debugging line
            \Log::info('Tag IDs:', $tagIds);
            $product->tags()->attach($tagIds);
        }
        // Store colors
        if ($request->has('colors')) {
            $product->colors()->attach($request->colors);
        }
        // Store product variants if they exist
        if ($request->has('variant_name')) {
            foreach ($request->variant_name as $index => $variantName) {
                // Debugging line
                \Log::info('Creating variant:', [
                    'product_id' => $product->id,
                    'variant_name' => $variantName,
                    'variant_price' => $request->variant_price[$index] ?? null,
                    'variant_sku' => $request->variant_sku[$index] ?? null,
                    'variant_qty' => $request->variant_qty[$index] ?? null,
                    'variant_image' => $request->variant_image_url[$index] ?? null,
                ]);
                
                ProductVariant::create([
                    'product_id' => $product->id,
                    'variant_name' => $variantName,
                    'variant_price' => $request->variant_price[$index] ?? null,
                    'variant_sku' => $request->variant_sku[$index] ?? null,
                    'variant_qty' => $request->variant_qty[$index] ?? null,
                    'variant_image' => $request->variant_image_url[$index] ?? null,
                ]);
            }
            if ($request->has('attributes') && $request->has('choice')) {
                $attributesData = $request->attributes;
                $attributeValuesData = $request->choice;
        
                $attributes = $this->createOrGetAttributes($attributesData, $attributeValuesData);
        
                foreach ($attributes as $attribute) {
                    DB::table('product_attribute')->insert([
                        'product_id' => $product->id,
                        'attribute_id' => $attribute['attribute_id'],
                        'attribute_value_id' => $attribute['attribute_value_id']
                    ]);
                }
            }
        return redirect()->back()->with('success','product created successfully');

    }
}

    protected function createOrGetTags(string $tagsString): array
    {
        $tags = explode(',', $tagsString);
        $tagIds = [];

        foreach ($tags as $tagName) {
            $tagName = trim($tagName); // Trim whitespace

            // Check if the tag already exists by name or slug
            $tag = Tag::firstOrCreate([
                'name' => $tagName,
                'slug' => \Str::slug($tagName), // Create slug from name
            ]);

            // Store the tag ID
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
