<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index() {
        return view('brands.index');
    }
    public function getData(Request $request)
    {
        $query = Brand::latest();
    
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
                'logo' => 'logo',
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
    
        $brands = $query->skip($page * $perPage)->take($perPage)->get(); // Fetch records
    
        return response()->json([
            'draw' => intval($request->get('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, // Assuming no additional filtering beyond search
            'data' => $brands->map(function ($brand) {
                return [
                    'id' => $brand->id,
                    'name' => $brand->name,
                    'logo' => $brand->logo ? '<img src="'. asset($brand->logo ).'" alt="'. $brand->name .'" class="avatar-md rounded material-shadow">' : null, 
                    'status' =>   $this->getStatusBadge($brand),
                    'options' => $this->generatebrandOptions($brand)
                ];
            })
        ]);
    }
    private function generatebrandOptions($brand)
    {
        $actions = '';
        if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<a href="'.route('brand.edit',$brand->id).'" name="btn-edit" class="btn btn-info me-2" title="Edit"><i class="fas fa-edit"></i></a>';
        }
        if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<button type="button" name="btn-delete" class="btn btn-danger" data-id="'. $brand->id .'" title="Delete"><i class="fas fa-trash"></i></button>';
        }
        return $actions ? '<div class="">' . $actions . '</div>' : '';
    }
    public function getStatusBadge($brand)
    {
        $isChecked = $brand->status == 1 ? 'checked' : '';

        return '
            <div class="form-check form-switch form-switch-md">
                <input class="form-check-input brand_status_change" type="checkbox" data-id="' . $brand->id . '" ' . $isChecked . '>
                <label class="form-check-label"></label>
            </div>
        ';
    }
    public function create() {
        return view('brands.create');
    }

    public function store(Request $request) {
        // dd($request->all());
        $validator = Validator::make($request->all() ,[
            'logo' => 'nullable|string',
            'name' => 'required|string|unique:brands,name',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $brand = new Brand();
        $brand->name = $request->input('name');
        $brand->logo = $request->input('logo');
        $brand->meta_title = $request->input('meta_title');
        $brand->meta_description = $request->input('meta_description');
        $brand->status = $request->input('status');
        // Generate and set the slug
        $brand->slug = Brand::generateSlug($request->input('name'));
        $brand->save();
        $success = true ;
        if($success) {
            return redirect()->route('brand.index')->with('success','Brand created successfully');
            } else {
                return redirect()->route('brand.index')->with('error','Failed to create brand');
        }
    }
    public function edit($id) {
        $brand = Brand::find($id);
        if(!$brand) {
            return redirect()->route('brand.index')->with('error','Brand not found');
        }
        return view('brands.edit',compact('brand'));
    }
    public function update(Request $request ,$id) {
        $brand = Brand::find($id);
        if(!$brand) {
            return redirect()->route('brand.index')->with('error','Brand not found');
        }
        $validator = Validator::make($request->all() ,[
            'logo' => 'nullable|string',
            'name' => 'required|string|unique:brands,name,' . $brand->id,
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $brand->name = $request->input('name');
        if ($brand->isDirty('name')) { // Check if the name has changed
            $brand->slug = Brand::generateSlug($request->input('name')); 
        }
        
        $brand->logo = $request->input('logo');
        $brand->meta_title = $request->input('meta_title');
        $brand->meta_description = $request->input('meta_description');
        $brand->status = $request->input('status');
        $brand->save();
        $success = true ;
        if($success) {
            return redirect()->route('brand.index')->with('success','Brand updated successfully');
            } else {
                return redirect()->route('brand.index')->with('error','Failed to update brand');
                }
    }
    public function destroy($id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $brand->delete();
            Session::flash('success','Brand deleted successfully!');
            return response()->json(['success' => 'Brand deleted successfully!'], 200);
        } catch (\Exception $e) {
            Session::flash('error','Failed to delete the Brand!');
            return response()->json(['error' => 'Failed to delete the Brand!'], 422);
        }
    }
    public function changeStatus(Request $request) {
        $validator = Validator::make($request->all(),[
            'brand_id' => 'required|exists:brands,id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $brand = Brand::find($request->brand_id);
        if(!$brand) { 
            return redirect()->route('brand.index')->with('error','brand Not Found');
        }
        $brand->status = !$brand->status;
        $brand->save();
    
        return response()->json([
            'status' => $brand->status,
            'message' => 'brand status updated successfully.',
        ]);
    }
}
