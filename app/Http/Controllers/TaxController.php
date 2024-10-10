<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TaxController extends Controller
{
    public function index()
    {
        return view('Taxes.index');
    }
    public function getData(Request $request)
    {
        $query = Tax::latest();

        // Filtering
        if ($request->has('search') && !empty($request->get('search')['value'])) {
            $searchValue = $request->get('search')['value'];
            $query->where('name', 'like', "%{$searchValue}%")
                ->orWhere('group', 'like', "%{$searchValue}%")
                ->orWhere('value', 'like', "%{$searchValue}%");
        }

        // Sorting
        if ($request->has('order')) {
            $columnIndex = $request->get('order')[0]['column'];
            $columnName = $request->get('columns')[$columnIndex]['data'];
            $direction = $request->get('order')[0]['dir'];

            // Define mapping for columns in DataTable to actual columns in the database
            $columnMap = [
                'name' => 'name',
                'group' => 'group',
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

        $taxes = $query->skip($page * $perPage)->take($perPage)->get(); // Fetch records

        return response()->json([
            'draw' => intval($request->get('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, // Assuming no additional filtering beyond search
            'data' => $taxes->map(function ($tax) {
                return [
                    'id' => $tax->id,
                    'group' => $tax->group,
                    'name' => $tax->name,
                    'value' => $tax->value,
                    'status' => $this->getStatusBadge($tax),
                    'options' => $this->generatetaxOptions($tax)
                ];
            })
        ]);
    }
    private function generatetaxOptions($tax)
    {
        $actions = '';
        if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<a href="' . route('tax.edit', $tax->id) . '" name="btn-edit" class="btn btn-info me-2" title="Edit"><i class="fas fa-edit"></i></a>';
        }
        if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<button type="button" name="btn-delete" class="btn btn-danger" data-id="' . $tax->id . '" title="Delete"><i class="fas fa-trash"></i></button>';
        }
        return $actions ? '<div class="">' . $actions . '</div>' : '';
    }
    public function getStatusBadge($tax)
    {
        $isChecked = $tax->status == 1 ? 'checked' : '';

        return '
                <div class="form-check form-switch form-switch-md">
                    <input class="form-check-input tax_status_change" type="checkbox" data-id="' . $tax->id . '" ' . $isChecked . '>
                    <label class="form-check-label"></label>
                </div>
            ';
    }
    public function create() {
        return view('Taxes.create');
    }
    public function store(Request $request) {
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'value' => 'required|numeric|min:0|max:100',
            'group' => 'required|string',
            'status' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $tax = new Tax();
        $tax->name = $request->input('name');
        $tax->value = $request->input('value');
        $tax->group = $request->input('group');
        $tax->status = $request->input('status');
        $tax->save();
        $success = true ;
        if($success) {
            return redirect()->route('tax.index')->with('success' ,'Tax Created Successfully');
        } else {
            return redirect()->route('tax.index')->with('error' ,'Failed to Create Tax');
        }
    }
    public function edit($id) {
        $tax = Tax::find($id);
        if (!$tax) {
            return redirect()->route('tax.index')->with('error', 'Tax Not Found');
        }
        return view('Taxes.edit' ,compact('tax'));
    }
    public function update(Request $request ,$id) {
        // dd($request->all());
        $tax = Tax::find($id);
        if (!$tax) {
            return redirect()->route('tax.index')->with('error', 'Tax Not Found');
        }
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'value' => 'required|numeric|min:0|max:100',
            'group' => 'required|string',
            'status' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $tax->name = $request->input('name');
        $tax->value = $request->input('value');
        $tax->group = $request->input('group');
        $tax->status = $request->input('status');
        $tax->save();
        $success = true ;
        if($success) {
            return redirect()->route('tax.index')->with('success' ,'Tax Updated Successfully');
        } else {
            return redirect()->route('tax.index')->with('error' ,'Failed to Update Tax');
        }
    }
    public function destroy($id)
    {
        try {
            $tax = Tax::findOrFail($id);
            $tax->delete();
            Session::flash('success', 'tax deleted successfully!');
            return response()->json(['success' => 'tax deleted successfully!'], 200);
        } catch (\Exception $e) {
            Session::flash('error', 'Failed to delete the tax!');
            return response()->json(['error' => 'Failed to delete the tax!'], 422);
        }
    }
    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tax_id' => 'required|exists:taxes,id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $tax = Tax::find($request->tax_id);
        if (!$tax) {
            return redirect()->route('tax.index')->with('error', 'Tax Not Found');
        }
        $tax->status = !$tax->status;
        $tax->save();

        return response()->json([
            'status' => $tax->status,
            'message' => 'tax status updated successfully.',
        ]);
    }

    
}
