<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return view('product-categories.index');
    }
    public function getData(Request $request)
    {
        $query = ProductCategory::with('parentCategory')->latest();
  
      // Filtering
      if ($request->has('search') && !empty($request->get('search')['value'])) {
        $searchValue = $request->get('search')['value'];
        $query->where(function ($query) use ($searchValue) {
            $query->where('name', 'like', "%{$searchValue}%")
                  ->orWhereHas('parentCategory', function ($q) use ($searchValue) {
                      $q->where('name', 'like', "%{$searchValue}%");
                  });
        });
    }
  
      // Sorting
      if ($request->has('order')) {
        $columnIndex = $request->get('order')[0]['column'];
        $columnName = $request->get('columns')[$columnIndex]['data'];
        $direction = $request->get('order')[0]['dir'];

        // Define mapping for columns in DataTable to actual columns in the database
        $columnMap = [
            'name' => 'name',
            'status' => 'status',
            'parent_category' => 'parent_category_id' // Add parent_category mapping
        ];

        if (array_key_exists($columnName, $columnMap)) {
            if ($columnName === 'parent_category') {
                $query->orderBy('parent_category_id', $direction);
            } else {
                $query->orderBy($columnMap[$columnName], $direction);
            }
        }
    } else {
        $query->latest('id'); // Default sorting if none provided
    }
      // Pagination
      $perPage = $request->get('length', 10); // Number of records per page
      $page = $request->get('start', 0) / $perPage; // Offset
      $totalRecords = $query->count(); // Total records count
  
      $categories = $query->skip($page * $perPage)->take($perPage)->get(); // Fetch records
  
      return response()->json([
        'draw' => intval($request->get('draw')),
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $totalRecords, // Assuming no additional filtering beyond search
        'data' => $categories->map(function ($category) {
          return [
            'id' => $category->id,
            'name' =>  $category->name ,
            'parent_category' => $category->parentCategory ? $category->parentCategory->name : 'None', 
            'logo' => $category->logo ? '<img src="'. asset($category->logo ).'" alt="'. $category->name .'" class="avatar-md rounded material-shadow">' : null, 
            'status' => $this->getStatusBadge($category),
            'options' => $this->generateOptions($category)
          ];
        })
      ]);
    }
    private function generateOptions($category)
    {
      $actions = '';
      $actions .= '<a href="' . route('category.edit', $category->id) . '" name="btn-edit" class="btn btn-info me-2" data-id="' . $category->id . '" title="Edit"><i class="fas fa-edit"></i></a>';
      $actions .= '<button type="button" name="btn-delete" class="btn btn-danger" data-id="' . $category->id . '" title="Delete"><i class="fas fa-trash"></i></button>';
      return $actions ? '<div class="">' . $actions . '</div>' : '';
    }
    public function getStatusBadge($category)
    {
      $isChecked = $category->status == 1 ? 'checked' : '';
  
      return '
            <div class="form-check form-switch form-switch-md">
                <input class="form-check-input category_status_change" type="checkbox" data-id="' . $category->id . '" ' . $isChecked . '>
                <label class="form-check-label"></label>
            </div>
        ';
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategory::all();
        $formattedCategories = $this->buildCategoryOptions($categories);
        return view('product-categories.create' ,compact('formattedCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'parent_id' => 'nullable|exists:product_categories,id',
            'status' => 'required|boolean',
            'logo' => 'nullable|string'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $category = new ProductCategory();
        $category->name = $request->input('name');
        $category->logo = $request->input('logo');
        $category->parent_category_id = $request->input('parent_id');
        $category->meta_title = $request->input('meta_title');
        $category->meta_description = $request->input('meta_description');
        $category->status = $request->input('status');
        $category->save();
        $success = true ;
        if($success) {
            return redirect()->route('category.index')->with('success', 'Category created successfully');
        } else {
            return redirect()->route('category.index')->with('error', 'Category creation failed');
        }
    }

    public function edit($id)
    {
        $category = ProductCategory::find($id);
        if(!$category) {
            return redirect()->back()->with('error','Category Not Found');
        }
        $categories = ProductCategory::where('id', '!=', $category->id)->get();
        $formattedCategories = $this->buildCategoryOptions($categories);
        return view('product-categories.edit', compact('category','formattedCategories'));

    }
    private function buildCategoryOptions($categories, $parentId = null, $prefix = '')
    {
        $output = [];
        
        foreach ($categories->where('parent_category_id', $parentId) as $category) {
            $output[] = ['id' => $category->id, 'name' => $prefix . $category->name];
            $output = array_merge($output, $this->buildCategoryOptions($categories, $category->id, $prefix . '--'));
        }
    
        return $output;
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = ProductCategory::find($id);
        if(!$category) {
            return redirect()->back()->with('error','Category Not Found');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'parent_id' => 'nullable|exists:product_categories,id',
            'status' => 'required|boolean',
            'logo' => 'nullable|string'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $category->name = $request->input('name');
        $category->logo = $request->input('logo');
        $category->parent_category_id = $request->input('parent_id');
        $category->meta_title = $request->input('meta_title');
        $category->meta_description = $request->input('meta_description');
        $category->status = $request->input('status');
        $category->save();
        $success = true;
        if($success) {
            return redirect()->route('category.index')->with('success','Category Updated Successfully');
        } else {
            return redirect()->route('category.index')->with('error','Failed to Update Category');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $category = ProductCategory::findOrFail($id);
            $category->delete();
            Session::flash('success','category deleted successfully!');
            return response()->json(['success' => 'category deleted successfully!'], 200);
        } catch (\Exception $e) {
            Session::flash('error','Failed to delete the category!');
            return response()->json(['error' => 'Failed to delete the category!'], 422);
        }
    }
  public function changeStatus(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'category_id' => 'required|exists:product_categories,id',
    ]);
    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator);
    }
    $category = ProductCategory::find($request->category_id);
    if (!$category) {
      return redirect()->route('category.index')->with('error', 'category Not Found');
    }
    $category->status = !$category->status;
    $category->save();

    return response()->json([
      'status' => $category->status,
      'message' => 'category status updated successfully.',
    ]);
  }
}
