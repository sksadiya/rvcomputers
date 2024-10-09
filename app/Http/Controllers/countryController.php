<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
class countryController extends Controller
{
    public function index()
    {   
        $countries = Country::all();
        return view('country.index',compact('countries'));
    }
    public function getData(Request $request)
    {
        $query = Country::latest();
    
        // Filtering
        if ($request->has('search') && !empty($request->get('search')['value'])) {
            $searchValue = $request->get('search')['value'];
            $query->where('name', 'like', "%{$searchValue}%")
            ->orWhere('code', 'like', "%{$searchValue}%");
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
    
        $countries = $query->skip($page * $perPage)->take($perPage)->get(); // Fetch records
    
        return response()->json([
            'draw' => intval($request->get('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, // Assuming no additional filtering beyond search
            'data' => $countries->map(function ($country) {
                return [
                    'id' => $country->id,
                    'name' => $country->name,
                    'code' => $country->code,
                    'status' =>   $this->getStatusBadge($country),
                    'options' => $this->generateCountryOptions($country)
                ];
            })
        ]);
    }
    private function generateCountryOptions($country)
    {
        $actions = '';
        if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<a href="'.route('country.edit',$country->id).'" name="btn-edit" class="btn btn-info me-2" data-id="7" title="Edit"><i class="fas fa-edit"></i></a>';
        }
        if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<button type="button" name="btn-delete" class="btn btn-danger" data-id="'. $country->id .'" title="Delete"><i class="fas fa-trash"></i></button>';
        }
        return $actions ? '<div class="">' . $actions . '</div>' : '';
    }
    public function getStatusBadge($country)
    {
        $isChecked = $country->status == 1 ? 'checked' : '';

        return '
            <div class="form-check form-switch form-switch-md">
                <input class="form-check-input country_status_change" type="checkbox" data-id="' . $country->id . '" ' . $isChecked . '>
                <label class="form-check-label"></label>
            </div>
        ';
        // if ($status == 1) {
        //     return '<span class="badge bg-primary">Active</span>'; // Primary badge for status 1
        // } else {
        //     return '<span class="badge bg-warning">Inactive</span>'; // Danger badge for other statuses
        // }
    }
    public function create()
    {
        return view('country.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:country_info,name',
            'code' => 'nullable',
            'status' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $success = false;
        $country = new Country();
        $country->name = $request->input('name');
        $country->code = $request->input('code');
        $country->status = $request->input('status');
        $country->save();
        $success = true;

        if ($success) {
            return redirect()->route('country.index')->with('success', 'Country created successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to create country');
        }
    }
    public function edit($id) {
        $country = Country::find($id);
        if (empty($country)) {
            Session::flash('error', 'No country found!');
            return redirect()->route('country.index');
        }
        return view('country.edit',compact('country'));
    }
    public function update(Request $request, $id) {
        $country = Country::find($id);
        if (empty($country)) {
            Session::flash('error', 'No country found!');
            return redirect()->route('country.index');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:country_info,name,' . $country->id, 
            'code' => 'nullable|string',
            'status' => 'required|boolean',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $success = false;
        $country->name = $request->input('name');
        $country->code = $request->input('code');
        $country->status = $request->input('status');
        $country->save();
        $success = true;
        if($success) {
            return redirect()->route('country.index')->with('success','Country Updated successfully');
        } else {
            return redirect()->route('country.index')->with('error','Failed to update country');
        }
    }
    public function destroy($id)
    {
        try {
            $country = Country::findOrFail($id);
            $country->delete();
            Session::flash('success','Country deleted successfully!');
            return response()->json(['success' => 'Country deleted successfully!'], 200);
        } catch (\Exception $e) {
            Session::flash('error','Failed to delete the country!');
            return response()->json(['error' => 'Failed to delete the country!'], 422);
        }
    }

    public function getStates($countryId)
    {
        Log::info('Fetching states for country ID:', ['countryId' => $countryId]);

        $states = State::where('country_id', $countryId)
        ->where('status', 1)
        ->pluck('name', 'id');

        Log::info('States fetched:', ['states' => $states]);

        return response()->json(['states' => $states]);
    }

    public function getCities($stateId)
    {
        Log::info('Fetching cities for state ID:', ['stateId' => $stateId]);

        $cities = City::where('state_id', $stateId)
                  ->where('status', 1) 
                  ->pluck('name', 'id');

        Log::info('Cities fetched:', ['cities' => $cities]);

        return response()->json(['cities' => $cities]);
    }
    public function changeStatus(Request $request) {
        $validator = Validator::make($request->all(),[
            'country_id' => 'required|exists:country_info,id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $country = Country::find($request->country_id);
        if(!$country) { 
            return redirect()->route('country.index')->with('error','country Not Found');
        }
        $country->status = !$country->status;
        $country->save();
    
        return response()->json([
            'status' => $country->status,
            'message' => 'country status updated successfully.',
        ]);
    }
}
