<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
   public function index() {
    return view('Colors.index');
   }
   public function getData(Request $request)
    {
        $query = Color::latest();
    
        // Filtering
        if ($request->has('search') && !empty($request->get('search')['value'])) {
            $searchValue = $request->get('search')['value'];
            $query->where('name', 'like', "%{$searchValue}%")
            ->orWhere('code' ,'like', "%{$searchValue}%");
        }
    
        // Sorting
        if ($request->has('order')) {
            $columnIndex = $request->get('order')[0]['column'];
            $columnName = $request->get('columns')[$columnIndex]['data'];
            $direction = $request->get('order')[0]['dir'];
    
            // Define mapping for columns in DataTable to actual columns in the database
            $columnMap = [
                'name' => 'name',
                'code' => 'code',
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
    
        $colors = $query->skip($page * $perPage)->take($perPage)->get(); // Fetch records
    
        return response()->json([
            'draw' => intval($request->get('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, // Assuming no additional filtering beyond search
            'data' => $colors->map(function ($color) {
                return [
                    'id' => $color->id,
                    'name' => $color->name,
                    'code' => $color->code,
                    'status' =>   $this->getStatusBadge($color),
                    'options' => $this->generatecolorOptions($color)
                ];
            })
        ]);
    }
    private function generatecolorOptions($color)
    {
        $actions = '';
        if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<a href="'.route('color.edit',$color->id).'" name="btn-edit" class="btn btn-info me-2" title="Edit"><i class="fas fa-edit"></i></a>';
        }
        if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<button type="button" name="btn-delete" class="btn btn-danger" data-id="'. $color->id .'" title="Delete"><i class="fas fa-trash"></i></button>';
        }
        return $actions ? '<div class="">' . $actions . '</div>' : '';
    }
    public function getStatusBadge($color)
    {
        $isChecked = $color->status == 1 ? 'checked' : '';

        return '
            <div class="form-check form-switch form-switch-md">
                <input class="form-check-input color_status_change" type="checkbox" data-id="' . $color->id . '" ' . $isChecked . '>
                <label class="form-check-label"></label>
            </div>
        ';
    }
    public function create() {
        return view('Colors.create');
    }
    public function store(Request $request) {
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'code' => 'required|string',
            'status' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $color = new Color();
        $color->name = $request->name;
        $color->code = $request->code;
        $color->status = $request->status;
        $color->save();
        $success = true ;
        if($success) {
            return redirect()->route('color.index')->with('success','Color created successfully');
        } else {
            return redirect()->route('color.index')->with('error','Failed to create color');
        }
    }
    public function edit($id) {
        $color = Color::find($id);
        if(!$color) {
            return redirect()->route('color.index')->with('error','Color not found');
        }
        return view('Colors.edit',compact('color'));
    }
    public function update(Request $request ,$id) {
        // dd($request->all());
        $color = Color::find($id);
        if(!$color) {
            return redirect()->route('color.index')->with('error','Color not found');
        }
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'code' => 'required|string',
            'status' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $color->name = $request->name;
        $color->code = $request->code;
        $color->status = $request->status;
        $color->save();
        $success = true ;
        if($success) {
            return redirect()->route('color.index')->with('success','Color updated successfully');
        } else {
            return redirect()->route('color.index')->with('error','Failed to update color');
        }
    }
    public function destroy($id)
    {
        try {
            $color = Color::findOrFail($id);
            $color->delete();
            Session::flash('success','color deleted successfully!');
            return response()->json(['success' => 'color deleted successfully!'], 200);
        } catch (\Exception $e) {
            Session::flash('error','Failed to delete the color!');
            return response()->json(['error' => 'Failed to delete the color!'], 422);
        }
    }
    public function changeStatus(Request $request) {
        $validator = Validator::make($request->all(),[
            'color_id' => 'required|exists:colors,id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $color = Color::find($request->color_id);
        if(!$color) { 
            return redirect()->route('color.index')->with('error','Color Not Found');
        }
        $color->status = !$color->status;
        $color->save();
    
        return response()->json([
            'status' => $color->status,
            'message' => 'color status updated successfully.',
        ]);
    }
}
