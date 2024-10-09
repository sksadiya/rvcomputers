<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class stateController extends Controller
{
    public function index() {
        return view('state.index');
    }
    public function getData(Request $request)
    {
        $query = State::latest();
    
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
    
        $states = $query->skip($page * $perPage)->take($perPage)->get(); // Fetch records
    
        return response()->json([
            'draw' => intval($request->get('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, // Assuming no additional filtering beyond search
            'data' => $states->map(function ($state) {
                return [
                    'id' => $state->id,
                    'name' => $state->name,
                    'status' =>   $this->getStatusBadge($state),
                    'options' => $this->generateStateOptions($state)
                ];
            })
        ]);
    }
    private function generateStateOptions($state)
    {
        $actions = '';
       if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<a href="'.route('state.edit',$state->id).'" name="btn-edit" class="btn btn-info me-2" data-id="7" title="Edit"><i class="fas fa-edit"></i></a>';
        }
       if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<button type="button" name="btn-delete" class="btn btn-danger" data-id="'. $state->id .'" title="Delete"><i class="fas fa-trash"></i></button>';
        }
        return $actions ? '<div class="">' . $actions . '</div>' : '';
    }
    public function getStatusBadge($state)
    {
        $isChecked = $state->status == 1 ? 'checked' : '';

        return '
            <div class="form-check form-switch form-switch-md">
                <input class="form-check-input state_status_change" type="checkbox" data-id="' . $state->id . '" ' . $isChecked . '>
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
        $countries = Country::all();
        return view('state.create',compact('countries'));
    }
    public function store(request $request) {
        $validator = Validator::make($request->all(),[
            'country_id' => 'required|exists:country_info,id',
            'name' => 'required|unique:state_info,name', // Exclude the current record if updating
            'status' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $success = false;
        $state = new State();
        $state->country_id = $request->country_id;
        $state->name = $request->name;
        $state->status = $request->status;
        $success = $state->save();
        $success = true;
        if ($success) {
            return redirect()->route('state.index')->with('success', 'State created successfully');
        } else {
            return redirect()->route('state.index')->with('error', 'Failed to create state');
        }
    }
    public function edit($id) {
        $state = State::find($id);
        if (empty($state)) {
            Session::flash('error', 'No state found!');
            return redirect()->route('state.index');
        }
        $countries = Country::all();
        return view('state.edit',compact('state','countries'));
    }
    public function update(Request $request, $id) {
        $state = State::find($id);
        if (empty($state)) {
            Session::flash('error', 'No state found!');
            return redirect()->route('state.index');
        }
        $validator = Validator::make($request->all(), [
            'country_id' => 'required|exists:country_info,id',
            'name' => 'required|unique:state_info,name,' . $request->id, // Exclude the current record if updating
            'status' => 'required|boolean',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $success = false;
        $state->name = $request->input('name');
        $state->country_id = $request->input('country_id');
        $state->status = $request->input('status');
        $state->save();
        $success = true;
        if($success) {
            return redirect()->route('state.index')->with('success','State Updated successfully');
        } else {
            return redirect()->route('state.index')->with('error','Failed to update state');
        }
    }
    public function destroy($id)
    {
        try {
            $state = State::findOrFail($id);
            $state->delete();
            Session::flash('success','State deleted successfully!');
            return response()->json(['success' => 'State deleted successfully!'], 200);
        } catch (\Exception $e) {
            Session::flash('error','Failed to delete the State!');
            return response()->json(['error' => 'Failed to delete the State!'], 422);
        }
    }

    public function changeStatus(Request $request) {
        $validator = Validator::make($request->all(),[
            'state_id' => 'required|exists:state_info,id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $state = State::find($request->state_id);
        if(!$state) { 
            return redirect()->route('state.index')->with('error','state Not Found');
        }
        $state->status = !$state->status;
        $state->save();
    
        return response()->json([
            'status' => $state->status,
            'message' => 'state status updated successfully.',
        ]);
    }
}
