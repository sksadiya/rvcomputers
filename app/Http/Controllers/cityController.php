<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class cityController extends Controller
{
    public function index() {
        return view('city.index');
    }
    public function getData(Request $request)
    {
        $query = City::latest();
    
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
    
        $cities = $query->skip($page * $perPage)->take($perPage)->get(); // Fetch records
    
        return response()->json([
            'draw' => intval($request->get('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, // Assuming no additional filtering beyond search
            'data' => $cities->map(function ($city) {
                return [
                    'id' => $city->id,
                    'name' => $city->name,
                    'status' =>   $this->getStatusBadge($city),
                    'options' => $this->generateCitiesActions($city)
                ];
            })
        ]);
    }
    private function generateCitiesActions($city)
    {
        $actions = '';
       if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<a href="'.route('city.edit',$city->id).'" name="btn-edit" class="btn btn-info me-2" data-id="7" title="Edit"><i class="fas fa-edit"></i></a>';
        }
       if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<button type="button" name="btn-delete" class="btn btn-danger" data-id="'. $city->id .'" title="Delete"><i class="fas fa-trash"></i></button>';
        }
        return $actions ? '<div class="">' . $actions . '</div>' : '';
    }
    public function getStatusBadge($city)
    {
        $isChecked = $city->status == 1 ? 'checked' : '';

        return '
            <div class="form-check form-switch form-switch-md">
                <input class="form-check-input city_status_change" type="checkbox" data-id="' . $city->id . '" ' . $isChecked . '>
                <label class="form-check-label"></label>
            </div>
        ';
        // if ($status == 1) {
        //     return '<span class="badge bg-primary">Active</span>'; // Primary badge for status 1
        // } else {
        //     return '<span class="badge bg-warning">Inactive</span>'; // Danger badge for other statuses
        // }
    }   
    public function create() {
        $states = State::all();
        return view('city.create',compact('states'));
    }
    public function store(request $request) {
        $validator = Validator::make($request->all(),[
            'state_id' => 'required|exists:state_info,id',
            'name' => 'required|unique:city_info,name', // Exclude the current record if updating
            'status' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $success = false;
        $city = new City();
        $city->state_id = $request->state_id;
        $city->name = $request->name;
        $city->status = $request->status;
        $success = $city->save();
        $success = true;
        if ($success) {
            return redirect()->route('city.index')->with('success', 'City created successfully');
        } else {
            return redirect()->route('city.index')->with('error', 'Failed to create city');
        }
    }
    public function edit($id) {
        $city = city::find($id);
        if (empty($city)) {
            Session::flash('error', 'No city found!');
            return redirect()->route('city.index');
        }
        $states = State::all();
        return view('city.edit',compact('city','states'));
    }
    public function update(Request $request, $id) {
        $city = City::find($id);
        if (empty($city)) {
            Session::flash('error', 'No city found!');
            return redirect()->route('city.index');
        }
        $validator = Validator::make($request->all(), [
            'state_id' => 'required|exists:state_info,id',
            'name' => 'required|unique:city_info,name,' . $request->id, // Exclude the current record if updating
            'status' => 'required|boolean',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $success = false;
        $city->name = $request->input('name');
        $city->state_id = $request->input('state_id');
        $city->status = $request->input('status');
        $city->save();
        $success = true;
        if($success) {
            return redirect()->route('city.index')->with('success','city Updated successfully');
        } else {
            return redirect()->route('city.index')->with('error','Failed to update city');
        }
    }
    public function destroy($id)
    {
        try {
            $city = City::findOrFail($id);
            $city->delete();
            Session::flash('success','City deleted successfully!');
            return response()->json(['success' => 'City deleted successfully!'], 200);
        } catch (\Exception $e) {
            Session::flash('error','Failed to delete the City!');
            return response()->json(['error' => 'Failed to delete the City!'], 422);
        }
    }

    public function changeStatus(Request $request) {
        $validator = Validator::make($request->all(),[
            'city_id' => 'required|exists:city_info,id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $city = City::find($request->city_id);
        if(!$city) { 
            return redirect()->route('city.index')->with('error','city Not Found');
        }
        $city->status = !$city->status;
        $city->save();
    
        return response()->json([
            'status' => $city->status,
            'message' => 'city status updated successfully.',
        ]);
    }
}
