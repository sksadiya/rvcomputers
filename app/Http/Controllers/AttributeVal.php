<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AttributeVal extends Controller
{
   public function index($id) {
    $attribute = Attribute::find($id);
    return view('attValues.index' ,compact('attribute', 'id'));
   }
   public function getData(Request $request ,$id)
    {
        $query = AttributeValue::with('attribute')
        ->where('attribute_id', $id);
    
        // Filtering
        if ($request->has('search') && !empty($request->get('search')['value'])) {
            $searchValue = $request->get('search')['value'];
            $query->where('value', 'like', "%{$searchValue}%");
        }
    
        // Sorting
        if ($request->has('order')) {
            $columnIndex = $request->get('order')[0]['column'];
            $columnName = $request->get('columns')[$columnIndex]['data'];
            $direction = $request->get('order')[0]['dir'];
    
            // Define mapping for columns in DataTable to actual columns in the database
            $columnMap = [
                'value' => 'value',
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
    
        $values = $query->skip($page * $perPage)->take($perPage)->get(); // Fetch records
    
        return response()->json([
            'draw' => intval($request->get('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, // Assuming no additional filtering beyond search
            'data' => $values->map(function ($val) {
                return [
                    'id' => $val->id,
                    'value' => $val->value,
                    'options' => $this->generatevalueOptions($val)
                ];
            })
        ]);
    }
    private function generatevalueOptions($value)
    {
        $actions = '';
        if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<a href="'.route('attributeValue.edit',$value->id).'" name="btn-edit" class="btn btn-info me-2" title="Edit"><i class="fas fa-edit"></i></a>';
        }
        if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<button type="button" name="btn-delete" class="btn btn-danger" data-id="'. $value->id .'" title="Delete"><i class="fas fa-trash"></i></button>';
        }
        return $actions ? '<div class="">' . $actions . '</div>' : '';
    }
    public function create($id) {
        $attribute = Attribute::find($id);
        if(!$attribute) {
            return redirect()->back()->with('error','attribute not found');
        }
        return view('attValues.create',compact('attribute'));
    }
    public function store(Request $request ,$id) {
        $attribute = Attribute::find($id);
        if(!$attribute) {
            return redirect()->back()->with('error','attribute not found');
        }
        $validator = Validator::make($request->all() ,[
            'value' => 'required|unique:attribute_values,value'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $val = new AttributeValue();
        $val->value = $request->input('value');
        $val->attribute_id = $attribute->id;
        $val->save();
        $success = true ;
        if($success) {
            return redirect()->route('attributeValue.index',$attribute->id)->with('success','Attribute value created successfully');
        } else {
            return redirect()->route('attributeValue.index',$attribute->id)->with('error','Failed to create attribute value');
        }
    }
    public function edit($id) {
        $val = AttributeValue::with('attribute')->find($id);
        if(!$val) {
            return redirect()->route('attributeValue.index')->with('error','Attribute value not found');
        } 
        return view('attValues.edit',compact('val'));
    }
    public function update(Request $request, $id) {
        $val = AttributeValue::find($id);
        if(!$val) {
            return redirect()->route('attributeValue.index')->with('error','Attribute value not found');
        } 
        $validator = Validator::make($request->all(), [
            'value' => 'required|unique:attribute_values,value,' . $val->id,
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $val->value = $request->input('value');
        $val->attribute_id = $val->attribute->id;
        $val->save();
        $success = true ;
        if($success) {
            return redirect()->route('attributeValue.index' ,$val->attribute->id)->with('success','Attribute value updated successfully');
        } else {
            return redirect()->route('attributeValue.index' ,$val->attribute->id)->with('error','Failed to update attribute value');
        } 
    }
    public function destroy($id)
    {
        try {
            $value = AttributeValue::findOrFail($id);
            $value->delete();
            Session::flash('success','attribute value deleted successfully!');
            return response()->json(['success' => 'attribute value deleted successfully!'], 200);
        } catch (\Exception $e) {
            Session::flash('error','Failed to delete the attribute value!');
            return response()->json(['error' => 'Failed to delete the attribute vaue!'], 422);
        }
    }
    public function getAttributeValues($attributeId)
{
    // Fetch attribute values based on the attribute ID
    $attributeValues = AttributeValue::where('attribute_id', $attributeId)->get();

    // Return them as JSON
    return response()->json($attributeValues);
}
}
