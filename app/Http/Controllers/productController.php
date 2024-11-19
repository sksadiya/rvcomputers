<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\productAttribute;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class productController extends Controller
{
    public function index() {
        return view('product.index');
    }
    public function getData(Request $request)
    {
        $query = Product::with('categories')->latest();
    
        // Filtering
        if ($request->has('search') && !empty($request->get('search')['value'])) {
            $searchValue = $request->get('search')['value'];
            $query->where('name', 'like', "%{$searchValue}%");
        }
    
        // Sorting
        if ($request->has('order')) {
            $columnIndex = $request->get('order')[0]['column'];
            $columnName = $request->get('columns')[$columnIndex]['data'];
            $direction = $request->get('order')[0]['dir'];
    
            // Define mapping for columns in DataTable to actual columns in the database
            $columnMap = [
                'name' => 'name',
                'image' => 'image',
            ];
    
            if (array_key_exists($columnName, $columnMap)) {
                $query->orderBy($columnMap[$columnName], $direction);
            }
        } else {
            $query->latest('id'); // Default sorting if none provided
        }
        // Pagination
        $perPage = $request->get('length', 10); // Number of records per page
        $page = $request->get('start', 0) / $perPage; // Offset
        $totalRecords = $query->count(); // Total records count
    
        $products = $query->skip($page * $perPage)->take($perPage)->get(); // Fetch records
    
        return response()->json([
            'draw' => intval($request->get('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, // Assuming no additional filtering beyond search
          'data' => $products->map(function ($product, $index) {
            return [
                'id' => $index + 1, // Using $index + 1 to start from 1 instead of 0
                'image' => $product->image ? '<img src="'. asset($product->image ).'" alt="'. $product->name .'" class="avatar-md rounded material-shadow">' : null, 
                'name' =>'<a href="'.route('product.show', $product->slug).'">'.$product->name.'</a>',
                'category' => $product->categories->pluck('name')->implode(', '), 
                'price' => $product->unit_price,
                'status' => $this->getStatusBadge($product),
                'options' => $this->generateOptions($product)
            ];
        })
        ]);
    }
    private function generateOptions($product)
    {
        $actions = '';
        if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<a href="'.route('product.edit',$product->id).'" name="btn-edit" class="btn btn-info me-2" title="Edit"><i class="fas fa-edit"></i></a>';
        }
        if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<button type="button" name="btn-delete" class="btn btn-danger" data-id="'. $product->id .'" title="Delete"><i class="fas fa-trash"></i></button>';
        }
        return $actions ? '<div class="">' . $actions . '</div>' : '';
    }
    public function getStatusBadge($product)
    {
        $isChecked = $product->status == 1 ? 'checked' : '';

        return '
            <div class="form-check form-switch form-switch-md">
                <input class="form-check-input product_status_change" type="checkbox" data-id="' . $product->id . '" ' . $isChecked . '>
                <label class="form-check-label"></label>
            </div>
        ';
    }
    public function create()
    {

        $categories = ProductCategory::all();
        $categoryOptions = (new ProductCategory())->buildCategoryOptions($categories);
        $brands = Brand::all();
        $colors = Color::all();
        $attributes = Attribute::all();
        return view('product.create', compact('categoryOptions', 'brands', 'colors', 'attributes'));
    }
    public function store(Request $request)
    {
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
            'old_price' => 'nullable|numeric',
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
            'choice_attributes' => 'nullable|array',
            'status' => 'required|boolean',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $product = new Product();
        $product->name = $request->name;
        $product->slug = Product::generateSlug($request->input('name'));
        $product->brand_id = $request->brand;
        $product->unit = $request->unit;
        $product->weight = $request->weight;
        $product->min_qty = $request->min_qty;
        $product->video_provider = $request->video_provider;
        $product->video_link = $request->video_link;
        $product->unit_price = $request->unit_price;
        $product->old_price = $request->old_price;
        $product->discount = $request->discount;
        $product->discount_type = $request->discount_type;
        $product->current_stock = $request->current_stock;
        $product->sku = $request->sku;
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->low_stock_quantity = $request->low_stock_quantity;
        $product->image = $request->image_url;
        $product->status = $request->status;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;

        $product->save();
        if ($request->category) {
            $product->categories()->sync($request->category);
        }
        if ($request->colors) {
            $product->colors()->sync($request->colors);
        }
        if ($request->tags) {
            $tagIds = $this->createOrGetTags($request->tags);
            // Debugging line
            \Log::info('Tag IDs:', $tagIds);
            $product->tags()->attach($tagIds);
        }
        if ($request->choice_attributes) {
            foreach ($request->choice_attributes as $key => $attributeId) {
                $choiceIndex = $request->choice_no[$key];
                $choiceOptionsKey = 'choice_options_' . $choiceIndex;
                $values = $request->input($choiceOptionsKey);

                if (is_array($values)) {
                    foreach ($values as $value) {
                        // Check if this combination already exists
                        if (
                            !productAttribute::where('product_id', $product->id)
                                ->where('attribute_id', $attributeId)
                                ->where('attribute_value_id', $value)
                                ->exists()
                        ) {
                            // Save the attribute
                            $product->attributes()->create([
                                'attribute_id' => $attributeId,
                                'attribute_value_id' => $value,
                            ]);
                        }
                    }
                } else {
                    if (
                        !ProductAttribute::where('product_id', $product->id)
                            ->where('attribute_id', $attributeId)
                            ->where('attribute_value_id', $values)
                            ->exists()
                    ) {
                        $product->attributes()->create([
                            'attribute_id' => $attributeId,
                            'attribute_value_id' => $values,
                        ]);
                    }
                }
            }
        }
        if ($request->variant_name) {
            foreach ($request->variant_name as $index => $variantName) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'variant_name' => $variantName,
                    'variant_price' => $request->variant_price[$index],
                    'variant_sku' => $request->variant_sku[$index],
                    'variant_qty' => $request->variant_qty[$index],
                    'variant_image' => $request->variant_image_url[$index],
                ]);
            }
        }
        if ($request->has('gallery_image_url')) {
            foreach ($request->gallery_image_url as $imageUrl) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $imageUrl,
                ]);
            }
        }
        return redirect()->route('product.index')->with('success', 'product created successfully');
    }
    public function edit($id) {
        $product = Product::find($id);
        if(!$product) {
            return redirect()->back()->with('error' ,'Product not found');
        }
        $categories = ProductCategory::all();
        $categoryOptions = (new ProductCategory())->buildCategoryOptions($categories);
        $brands = Brand::all();
        $colors = Color::all();
        $attributes = Attribute::all();
        return view('product.edit' , compact('product','categoryOptions','brands','colors','attributes'));
    }
    public function update(Request $request ,$id) {
        // dd($request->all());
        $product = Product::find($id);
        if(!$product) {
            return redirect()->back()->with('error' ,'Product not found');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'brand' => 'nullable|integer|exists:brands,id',
            'unit' => 'nullable|string|max:50',
            'weight' => 'nullable|numeric',
            'min_qty' => 'nullable|integer|min:1',
            'video_provider' => 'nullable|string|max:50',
            'video_link' => 'nullable|string|max:255',
            'unit_price' => 'nullable|numeric',
            'old_price' => 'nullable|numeric',
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
            'choice_attributes' => 'nullable|array',
            'status' => 'required|boolean',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $product->name = $request->name;
        if ($product->isDirty('name')) { // Check if the name has changed
            $product->slug = Product::generateSlug($request->input('name')); 
        }
        $product->brand_id = $request->brand;
        $product->unit = $request->unit;
        $product->weight = $request->weight;
        $product->min_qty = $request->min_qty;
        $product->video_provider = $request->video_provider;
        $product->video_link = $request->video_link;
        $product->unit_price = $request->unit_price;
        $product->old_price = $request->old_price;
        $product->discount = $request->discount;
        $product->discount_type = $request->discount_type;
        $product->current_stock = $request->current_stock;
        $product->sku = $request->sku;
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->low_stock_quantity = $request->low_stock_quantity;
        $product->image = $request->image_url;
        $product->status = $request->status;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;

        $product->save();

        if ($request->category) {
            $product->categories()->sync($request->category);
        }
        if ($request->colors) {
            $product->colors()->sync($request->colors);
        }
        if ($request->tags) {
            $tagIds = $this->createOrGetTags($request->tags);
            // Debugging line
            \Log::info('Tag IDs:', $tagIds);
            $product->tags()->sync($tagIds); 
        }
        if ($request->choice_attributes) {
            // Clear existing choice attributes
            $product->attributes()->delete(); // Delete old attributes
    
            foreach ($request->choice_attributes as $key => $attributeId) {
                $choiceIndex = $request->choice_no[$key];
                $choiceOptionsKey = 'choice_options_' . $choiceIndex;
                $values = $request->input($choiceOptionsKey);
    
                if (is_array($values)) {
                    foreach ($values as $value) {
                        // Save new attributes
                        $product->attributes()->create([
                            'attribute_id' => $attributeId,
                            'attribute_value_id' => $value,
                        ]);
                    }
                } else {
                    $product->attributes()->create([
                        'attribute_id' => $attributeId,
                        'attribute_value_id' => $values,
                    ]);
                }
            }
        }
        // Handle variants
        if ($request->variant_name) {
            // Clear existing variants
            $product->variants()->delete(); // Delete old variants
    
            foreach ($request->variant_name as $index => $variantName) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'variant_name' => $variantName,
                    'variant_price' => $request->variant_price[$index],
                    'variant_sku' => $request->variant_sku[$index],
                    'variant_qty' => $request->variant_qty[$index],
                    'variant_image' => $request->variant_image_url[$index],
                ]);
            }
        }
        // Handle gallery images
        if ($request->has('gallery_image_url')) {
            // Clear existing gallery images
            $product->images()->delete(); // Delete old gallery images
    
            foreach ($request->gallery_image_url as $imageUrl) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $imageUrl,
                ]);
            }
        }
        return redirect()->route('product.index')->with('success', 'product updated successfully');
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
    public function combination(Request $request)
    {
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
            'html' => $this->combinationHtml($combinations, $price, $product_name),
        ]);
    }
    private function generateCombination($arrays, $i = 0)
    {
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
    private function combinationHtml($combinations, $unit_price, $product_name)
    {
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
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            Session::flash('success','product deleted successfully!');
            return response()->json(['success' => 'product deleted successfully!'], 200);
        } catch (\Exception $e) {
            Session::flash('error','Failed to delete the product!');
            return response()->json(['error' => 'Failed to delete the product!'], 422);
        }
    }
    public function changeStatus(Request $request) {
        $validator = Validator::make($request->all(),[
            'product_id' => 'required|exists:products,id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $product = Product::find($request->product_id);
        if(!$product) { 
            return redirect()->route('product.index')->with('error','product Not Found');
        }
        $product->status = !$product->status;
        $product->save();
    
        return response()->json([
            'status' => $product->status,
            'message' => 'product status updated successfully.',
        ]);
    }
    public function deleteVariant(Request $request) {
        $variant = ProductVariant::find($request->variant_id);
        if(!$variant) { 
            return redirect()->back()->with('error','variant Not Found');
        }
        $variant->delete();
        return response()->json([
            'success' => true,
            'message' => 'variant deleted successfully.',
        ]);
    }

    public function show($slug)
{
    $product = Product::where('slug', $slug)
    ->with('images') 
    ->firstOrFail(); 
    if (!$product->status) { 
        return redirect()->back()->with('error', 'You have to publish the equipment.'); 
    }
    $allImages = $product->images->pluck('image_url')->toArray(); // Ensure 'image_url' is the correct field

    // Check if the product has any variants
    if ($product->variants->isNotEmpty()) {
        foreach ($product->variants as $variant) {
            // Access the images relationship correctly
            if ($variant->variant_image) { // Check if the variant image exists
                $allImages[] = $variant->variant_image; // Directly add the variant image to the array
            }
        }
    }

 $groupedAttributes = [];

    foreach ($product->attributes as $productAttribute) {
        // Group attribute values under their attribute name
        $attributeName = $productAttribute->attribute->name;
        $attributeValue = $productAttribute->attributeValue->value;

        $groupedAttributes[$attributeName][] = $attributeValue;
    }
    $averageRating = $product->reviews()->average('rating');

    // Rating summary calculation (e.g., 5-star, 4-star counts)
    $ratingSummary = [];
    for ($i = 5; $i >= 1; $i--) {
        $count = $product->reviews()->where('rating', $i)->count();
        $percentage = ($product->reviews->count() > 0) ? ($count / $product->reviews->count()) * 100 : 0;
        $ratingSummary[$i] = $percentage;
    }
    if ($product->discount > 0) {
        if ($product->discount_type == 'percentage') {
            $discountAmount = ($product->unit_price * $product->discount) / 100;
        } elseif ($product->discount_type == 'fixed') {
            $discountAmount = $product->discount;
        }
        $finalPrice = max(0, $product->unit_price - $discountAmount); // Ensures no negative price
    } else {
        $finalPrice = $product->unit_price;
    }
    return view('product.show', compact('product' ,'allImages' ,'groupedAttributes','averageRating' ,'ratingSummary','finalPrice'));
}

public function checkVariant(Request $request)
{
    $productId =  $request->input('product_id');
    $attributes = $request->input('attributes'); // an associative array of attributes

    // Sort attributes by key to ensure consistency in order
    ksort($attributes);

    // Prepare an array to hold all possible variant names
    $possibleVariants = [];

    // Get only the attribute values for the base variant name
    $baseVariantName = implode(' - ', array_values($attributes));
    $possibleVariants[] = $baseVariantName;

    // Now generate possible combinations (considering all orderings)
    $attributeValues = array_values($attributes);
    $attributeNames = array_keys($attributes);
    
    // Using combinations of attribute values to generate all possible variants
    $this->generateCombinations($attributeValues, $possibleVariants);

    // Debugging: Display all generated combinations
    // dd($possibleVariants); 

    // Check each variant in the database
    foreach ($possibleVariants as $variantName) {
        $variant = ProductVariant::where('product_id', $productId)
                    ->where('variant_name', $variantName)
                    ->first();

        if ($variant && $variant->variant_qty > 0) {
            return response()->json(['status' => 'available', 
            'stock' => $variant->variant_qty ,                                                                                                                                                                                                                                                  
            'variant_name' => $variantName ,
            'variant_id' => $variant->id ,
            'price' => $variant->variant_price]);
        }
    }

    return response()->json(['status' => 'unavailable', 'variant_name' => $baseVariantName]);
}

// Helper function to generate all combinations of attributes
private function generateCombinations($values, &$combinations) {
    // Generate different arrangements of the values
    $this->permutate($values, 0, count($values) - 1, $combinations);
}

private function permutate(&$array, $l, $r, &$combinations) {
    if ($l == $r) {
        // Create a variant name from this permutation using only values
        $variantName = implode(' - ', $array);
        $combinations[] = $variantName;
    } else {
        for ($i = $l; $i <= $r; $i++) {
            $this->swap($array, $l, $i);
            $this->permutate($array, $l + 1, $r, $combinations);
            $this->swap($array, $l, $i); // backtrack
        }
    }
}

private function swap(&$array, $i, $j) {
    $temp = $array[$i];
    $array[$i] = $array[$j];
    $array[$j] = $temp;
}
}
