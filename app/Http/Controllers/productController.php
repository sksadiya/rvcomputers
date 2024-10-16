<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\productAttribute;
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
        if ($request->attributes) {
            // Debugging: Log the attributes and choice options to check what's coming from the request
            
            foreach ($request->attributes as  $attribute_id) {
                // Dynamically get the choice options based on the attribute ID
                $choice_options = $request->input('choice_options_' . $attribute_id);
                
                // Debugging: Log to check if choice options are being fetched correctly
                \Log::info('Choice options for attribute ' . $attribute_id . ':', $choice_options);
                
                if ($choice_options) {
                    foreach ($choice_options as $option_value) {
                        // Check if product attribute values are saving correctly
                        \Log::info('Saving product attribute:', [
                            'product_id' => $product->id,
                            'attribute_id' => $attribute_id,
                            'attribute_value_id' => $option_value,
                        ]);
        
                        // Save the product attribute in the product_attribute table
                        ProductAttribute::create([
                            'product_id' => $product->id,
                            'attribute_id' => $attribute_id, // Store attribute (e.g., Size)
                            'attribute_value_id' => $option_value, // Store option (e.g., Small, Medium)
                        ]);
                    }
                } else {
                    return redirect()->back()->with('error' ,'No choice options found for attribute: ' . $attribute_id);
                    // \Log::error('No choice options found for attribute: ' . $attribute_id);
                }
            }
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
    public function getChoiceOptions(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'attribute_id' => 'required|integer|exists:attributes,id',
        ]);
    
        // Fetch the attribute and its options
        $attribute = Attribute::with('options')->find($request->attribute_id);
        
        // Get the options for the selected attribute
        $options = $attribute->options;
    
        // Generate the HTML for the select options
        $optionsHtml = '';
        foreach ($options as $option) {
            $optionsHtml .= '<option value="' . $option->id . '">' . $option->value . '</option>'; // Changed to use the 'value' field
        }
    
        return response()->json($optionsHtml);
    }
    public function combination(Request $request) {
        $colors = $request->input('colors');
        $choice_attributes = $request->input('choice_attributes');
        $price = $request->input('unit_price');
        $product_name = $request->input('name');
        $choice_no = $request->input('choice_no');
    
        $options = [];
    
        // Fetch color names from the database if colors are IDs
        if ($colors && count($colors) > 0) {
            $colorNames = Color::whereIn('id', $colors)->pluck('name')->toArray();
            array_push($options, $colorNames);
        }
    
        // Process choice attributes
        if ($choice_no) {
            foreach ($choice_no as $key => $no) {
                $_name = 'choice_options_' . $no;
                if ($request->input($_name)) {
                    $data = $request->input($_name);
                    
                    // Assuming you have a method to get attribute names from IDs
                    $attributeValues = AttributeValue::whereIn('id', $data)->pluck('value')->toArray();
                    array_push($options, $attributeValues);
                }
            }
        }
    
        // Generate combinations
        $combinations = $this->generateCombination($options);
        
        // Return the HTML
        return response()->json([
            'html' => $this->combinationHtml($combinations, $price, $product_name)
        ]);
    }
    private function generateCombination($arrays, $i = 0) {
        if (!isset($arrays[$i])) {
            return [];
        }
        if ($i == count($arrays) - 1) {
            $result = [];
            foreach ($arrays[$i] as $v) {
                $result[][] = $v;
            }
            return $result;
        }
    
        // Get combinations from subsequent arrays
        $tmp = $this->generateCombination($arrays, $i + 1);
        $result = [];
    
        // Concatenate each array from tmp with each element from $arrays[$i]
        foreach ($arrays[$i] as $v) {
            foreach ($tmp as $t) {
                $result[] = is_array($t) ? array_merge([$v], $t) : [$v, $t];
            }
        }
        return $result;
    }
    private function combinationHtml($combinations, $unit_price, $product_name) {
        $html = '';
        if ($combinations) {
            $html .= '
            <input type="hidden" name="variant_product" value="1">
            <table width="100%" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th width="30%">Variant Name</th>
                        <th width="15%">Variant Price <small class="text-danger">*</small></th>
                        <th width="15%">SKU</th>
                        <th width="15%">Quantity <small class="text-danger">*</small></th>
                        <th width="25%">Photo</th>
                        <th width="5%">#</th>
                    </tr>
                </thead>
                <tbody>
            ';
    
            $index = 0;
            foreach ($combinations as $combination) {
                $sku = '';
    
                // Generate SKU from product name
                foreach (explode(' ', $product_name) as $value) {
                    $sku .= substr($value, 0, 1);
                }
    
                $str = '';
                foreach ($combination as $key => $item) {
                    if ($key > 0) {
                        $str .= ' - ' . $item;  // Now using readable name (item name)
                        $sku .= '-' . str_replace(' ', '', $item);  // SKU part remains the same
                    } else {
                        $str .= $item;  // Now using readable name (item name)
                        $sku .= '-' . str_replace(' ', '', $item);  // SKU part remains the same
                    }
                }
    
                if (strlen($str) > 0) {
                    $html .= '
                    <tr class="variant' . $index . '">
                        <td>
                            <label for="" class="control-label">' . $str . '</label>
                        </td>
                        <td>
                            <input type="hidden" name="variant_name[]" value="' . $str . '">
                            <input type="number" name="variant_price[]" value="' . $unit_price . '" min="0" step="0.01" class="form-control" placeholder="Price" required>
                        </td>
                        <td>
                            <input type="text" name="variant_sku[]" value="' . $sku . '" class="form-control">
                        </td>
                        <td>
                            <input type="number" name="variant_qty[]" value="10" min="0" step="1" class="form-control" placeholder="Quantity" required>
                        </td>
                        <td>
                            <div class="img-div text-center btn-variantimage btn-select-variantimage" id="btn-select-variantimage-' . $index . '" data-column="variantimage' . $index . '">
                                <span class="text-blue cursor-pointer img-logo" style="display: none;">Choose logo</span>
                                <span id="btn-select-variantimage-' . $index . '" data-column="variantimage' . $index . '">
                                <img id="img-variantimage' . $index . '" src="' . asset('assets/images/avatar.webp') . '" class="logo-display img-fluid" />
                                </span>
                                <input type="hidden" name="variant_image_url[]" id="variantimage' . $index . '">
                                <button type="button" id="btn-remove-variantimage-' . $index . '" data-column="variantimage' . $index . '" class="btn btn-sm btn-danger btn-rounded pull-right btn-remove-variantimage" title="Clear" style="display: none;"><i class="bx bx-trash-alt"></i></button>
                            </div>
                        </td>
                        <td>
                        <button type="button" class="btn btn-sm btn-danger btn-rounded pull-right btn-delete-variant" data-id="' . $index . '" title="Delete"><i class="bx bx-trash-alt"></i></button>
                        </td>
                    </tr>
                    ';
                }
    
                $index++;
            }
    
            $html .= '</tbody></table>';
        }
    
        return $html;
    }
    

    
    

}
