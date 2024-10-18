<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class sliderController extends Controller
{
    public function index() {
        return view('slider.index');
    }
    public function getData(Request $request)
    {
        $query = Slider::latest();
        // Filtering
        if ($request->has('search') && !empty($request->get('search')['value'])) {
            $searchValue = $request->get('search')['value'];
            $query->where('slider_type', 'like', "%{$searchValue}%");
        }
    
        // Sorting
        if ($request->has('order')) {
            $columnIndex = $request->get('order')[0]['column'];
            $columnName = $request->get('columns')[$columnIndex]['data'];
            $direction = $request->get('order')[0]['dir'];
    
            // Define mapping for columns in DataTable to actual columns in the database
            $columnMap = [
                'slider_type' => 'slider_type',
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
    
        $sliders = $query->skip($page * $perPage)->take($perPage)->get(); // Fetch records
    
        return response()->json([
            'draw' => intval($request->get('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, // Assuming no additional filtering beyond search
            'data' => $sliders->map(function ($slider) {
                return [
                    'id' => $slider->id,
                    'type' => $slider->slider_type,
                    'image' => $slider->image ? '<img src="'. asset($slider->image ).'" alt="'. $slider->slider_type .'" class="avatar-md rounded material-shadow">' : null ,
                    'status' =>   $this->getStatusBadge($slider),
                    'options' => $this->generatesliderOptions($slider)
                ];
            })
        ]);
    }
    private function generatesliderOptions($slider)
    {
        $actions = '';
        if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<a href="'.route('slider.edit',$slider->id).'" name="btn-edit" class="btn btn-info me-2" data-id="7" title="Edit"><i class="fas fa-edit"></i></a>';
        }
        if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<button type="button" name="btn-delete" class="btn btn-danger" data-id="'. $slider->id .'" title="Delete"><i class="fas fa-trash"></i></button>';
        }
        return $actions ? '<div class="">' . $actions . '</div>' : '';
    }
    public function getStatusBadge($slider)
    {
        $isChecked = $slider->status == 1 ? 'checked' : '';

        return '
            <div class="form-check form-switch form-switch-md">
                <input class="form-check-input slider_status_change" type="checkbox" data-id="' . $slider->id . '" ' . $isChecked . '>
                <label class="form-check-label"></label>
            </div>
        ';
    }
    public function create() {
        $categories = ProductCategory::all();
        $products = Product::all();
        return view('slider.create', compact('categories','products'));
    }
    public function store(Request $request) {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'logo' => 'required', 
            'link' => 'nullable|url',  
            'status' => 'required|boolean', 
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $slider = new Slider();
        $slider->slider_type = $request->type;
        $slider->type_id = $request->type === 'product' ? $request->product : ($request->type === 'category' ? $request->category : null); 
        $slider->image = $request->logo;
        $slider->link = $request->link;
        $slider->status = $request->status;
        $slider->save();

        $success = true ;
        if($success) {
            return redirect()->route('slider.index')->with('success', 'Slider created successfully');
        } else {
            return redirect()->route('slider.index')->with('error', 'Failed to create slider');
        }

    }
    public function edit($id) {
        $slider = Slider::find($id);
        if(!$slider) {
            return redirect()->route('slider.index')->with('error', 'Slider not found');
        }
        $categories = ProductCategory::all();
        $products = Product::all();
        return view('slider.edit', compact('slider','categories','products'));
    }
    public function update(Request $request, $id) {
        $slider = Slider::find($id);
        if(!$slider) {
            return redirect()->route('slider.index')->with('error', 'Slider not found');
        }
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'logo' => 'required', 
            'link' => 'nullable|url',  
            'status' => 'required|boolean', 
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $slider->slider_type = $request->type;
        $slider->type_id = $request->type === 'product' ? $request->product : ($request->type === 'category' ? $request->category : null); 
        $slider->image = $request->logo;
        $slider->link = $request->link;
        $slider->status = $request->status;
        $slider->save();
        $success = true ;
        if($success) {
            return redirect()->route('slider.index')->with('success', 'Slider updated successfully');
        } else {
            return redirect()->route('slider.index')->with('error', 'Failed to update slider');
        }
    }
    public function destroy($id)
    {
        try {
            $slider = Slider::findOrFail($id);
            $slider->delete();
            Session::flash('success','Slider deleted successfully!');
            return response()->json(['success' => 'Slider deleted successfully!'], 200);
        } catch (\Exception $e) {
            Session::flash('error','Failed to delete the Slider!');
            return response()->json(['error' => 'Failed to delete the Slider!'], 422);
        }
    }
    public function changeStatus(Request $request) {
        $validator = Validator::make($request->all(),[
            'slider_id' => 'required|exists:sliders,id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $slider = Slider::find($request->slider_id);
        if(!$slider) { 
            return redirect()->route('slider.index')->with('error','slider Not Found');
        }
        $slider->status = !$slider->status;
        $slider->save();
    
        return response()->json([
            'status' => $slider->status,
            'message' => 'slider status updated successfully.',
        ]);
    }
}
