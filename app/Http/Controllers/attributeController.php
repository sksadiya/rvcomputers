<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class attributeController extends Controller
{
    public function index() {
        return view('Attribute.index');
    }
    public function getData(Request $request)
    {
        $query = Attribute::latest();
    
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
    
        $attributes = $query->skip($page * $perPage)->take($perPage)->get(); // Fetch records
    
        return response()->json([
            'draw' => intval($request->get('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, // Assuming no additional filtering beyond search
            'data' => $attributes->map(function ($attribute) {
                return [
                    'id' => $attribute->id,
                    'name' => $attribute->name,
                    'options' => $this->generateattributeOptions($attribute)
                ];
            })
        ]);
    }
    private function generateattributeOptions($attribute)
    {
        $actions = '';
        if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<a href="'.route('attribute.edit',$attribute->id).'" name="btn-edit" class="btn btn-info me-2" title="Edit"><i class="fas fa-edit"></i></a>';
        }
        if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<button type="button" name="btn-delete" class="btn btn-danger me-2" data-id="'. $attribute->id .'" title="Delete"><i class="fas fa-trash"></i></button>';
        }
        if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<a href="'.route('attributeValue.index' ,$attribute->id).'" name="btn-attribute-value" data-id="'. $attribute->id .'"  class="btn btn-primary me-2" title="attribute">Attribute Values</a>';
        }
        return $actions ? '<div class="">' . $actions . '</div>' : '';
    }
    public function create() {
        return view('Attribute.create');
    }
    public function store(Request $request) {
        $validator = Validator::make($request->all() ,[
            'name' => 'required|unique:attributes,name'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $attribute = new Attribute();
        $attribute->name = $request->input('name');
        $attribute->save();
        $success = true ;
        if($success) {
            return redirect()->route('attribute.index')->with('success','Attribute created successfully');
        } else {
            return redirect()->route('attribute.index')->with('error','Failed to create attribute');
        }
    }
    public function edit($id) {
        $attribute = Attribute::find($id);
        if(!$attribute) {
            return redirect()->route('attribute.index')->with('error','Attribute not found');
        } 
        return view('Attribute.edit',compact('attribute'));
    }
    public function update(Request $request, $id) {
        $attribute = Attribute::find($id);
        if(!$attribute) {
            return redirect()->route('attribute.index')->with('error','Attribute not found');
        } 
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:attributes,name,' . $attribute->id,
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $attribute->name = $request->input('name');
        $attribute->save();
        $success = true ;
        if($success) {
            return redirect()->route('attribute.index')->with('success','Attribute updated successfully');
        } else {
            return redirect()->route('attribute.index')->with('error','Failed to update attribute');
        } 
    }
    public function destroy($id)
    {
        try {
            $attribute = Attribute::findOrFail($id);
            $attribute->delete();
            Session::flash('success','attribute deleted successfully!');
            return response()->json(['success' => 'attribute deleted successfully!'], 200);
        } catch (\Exception $e) {
            Session::flash('error','Failed to delete the attribute!');
            return response()->json(['error' => 'Failed to delete the attribute!'], 422);
        }
    }
}
