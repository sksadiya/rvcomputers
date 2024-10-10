<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    public function index() {
        return view('Coupons.index');
    }
    public function getData(Request $request)
    {
        $query = Coupon::latest();
    
        // Filtering
        if ($request->has('search') && !empty($request->get('search')['value'])) {
            $searchValue = $request->get('search')['value'];
            $query->where('name', 'like', "%{$searchValue}%")
            ->orWhere('promocode', 'like', "%{$searchValue}%")
            ->orWhere('discount', 'like', "%{$searchValue}%");
        }
    
        // Sorting
        if ($request->has('order')) {
            $columnIndex = $request->get('order')[0]['column'];
            $columnName = $request->get('columns')[$columnIndex]['data'];
            $direction = $request->get('order')[0]['dir'];
    
            // Define mapping for columns in DataTable to actual columns in the database
            $columnMap = [
                'id' => 'id',
                'name' => 'name',
                'promocode' => 'promocode',
                'discount' => 'discount',
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
    
        $coupons = $query->skip($page * $perPage)->take($perPage)->get(); // Fetch records
    
        return response()->json([
            'draw' => intval($request->get('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, // Assuming no additional filtering beyond search
            'data' => $coupons->map(function ($coupon) {
                return [
                    'id' => $coupon->id,
                    'name' => $coupon->name,
                    'logo' => $coupon->logo ? '<img src="'. asset($coupon->logo ).'" alt="'. $coupon->name .'" class="avatar-md rounded material-shadow">' : null, 
                    'code' => $coupon->promocode , 
                    'amount' => $coupon->type === 'percentage' ? "{$coupon->discount}%" : "₹{$coupon->discount}",
                    'duration' => $coupon->duration, 
                    'per_user' => $coupon->max_uses_per_user , 
                    'status' =>   $this->getStatusBadge($coupon),
                    'options' => $this->generatecouponOptions($coupon)
                ];
            })
        ]);
    }
    private function generatecouponOptions($coupon)
    {
        $actions = '';
        if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<a href="'.route('coupon.edit',$coupon->id).'" name="btn-edit" class="btn btn-info me-2" title="Edit"><i class="fas fa-edit"></i></a>';
        }
        if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<button type="button" name="btn-delete" class="btn btn-danger" data-id="'. $coupon->id .'" title="Delete"><i class="fas fa-trash"></i></button>';
        }
        return $actions ? '<div class="">' . $actions . '</div>' : '';
    }
    public function getStatusBadge($coupon)
    {
        $isChecked = $coupon->status == 1 ? 'checked' : '';

        return '
            <div class="form-check form-switch form-switch-md">
                <input class="form-check-input coupon_status_change" type="checkbox" data-id="' . $coupon->id . '" ' . $isChecked . '>
                <label class="form-check-label"></label>
            </div>
        ';
    }
    public function create() {
        return view('Coupons.create');
    }
    public function store(Request $request) {
    //   dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'logo' => 'nullable|string',
            'promo_code' => 'required|string',
            'min_order_value' => 'required|numeric|min:1',
            'discount' => 'required|numeric',
            'start_date' => 'required|date', 
            'end_date' => 'required|date|after:start_date',
            'redeem_per_user' => 'required|integer|min:1',   
            'description' => 'nullable|string',
            'terms' => 'nullable|string',
            'status' => 'required|boolean',
           'type' => 'required|in:percentage,fixed',
        ]);
        if ($request->type === 'percentage') {
            $validator->after(function ($validator) use ($request) {
                if ($request->discount < 0 || $request->discount > 100) {
                    $validator->errors()->add('discount', 'The percentage must be between 0 and 100.');
                }
            });
        }
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $startDate = Carbon::parse($request->input('start_date'))->format('Y-m-d');
        $endDate = Carbon::parse($request->input('end_date'))->format('Y-m-d');

        $coupon = new Coupon();
        $coupon->name = $request->input('name');
        $coupon->logo = $request->input('logo');
        $coupon->promocode = $request->input('promo_code');
        $coupon->minimum_amount = $request->input('min_order_value');
        $coupon->discount = $request->input('discount');
        $coupon->start_date =  $startDate;
        $coupon->end_date =  $endDate;
        $coupon->max_uses_per_user = $request->input('redeem_per_user');
        $coupon->description = $request->input('description');
        $coupon->terms_and_conditions = $request->input('terms');
        $coupon->status = $request->input('status');
        $coupon->type = $request->input('type');
        $coupon->save();
        $success = true ;
        if($success) {
            return redirect()->route('coupon.index')->with('success', 'Coupon created successfully');
        } else {
            return redirect()->route('coupon.index')->with('error', 'Failed to Create Coupon');
        }
    }
    public function edit($id) {
        $coupon = Coupon::find($id);
        if(!$coupon) {
            return redirect()->route('coupon.index')->with('error', 'Coupon not found');
        }
        $coupon->start_date = Carbon::parse($coupon->start_date)->format('d/m/Y');
        $coupon->end_date = Carbon::parse($coupon->end_date)->format('d/m/Y');
        return view('Coupons.edit', compact('coupon'));
    }
    public function update(Request $request ,$id) {
        // dd($request->all());
        $request->merge([
            'start_date' => Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d'),
            'end_date' => Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d'),
        ]);
        $coupon = Coupon::find($id);
        if(!$coupon) {
            return redirect()->route('coupon.index')->with('error', 'Coupon not found');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'logo' => 'nullable|string',
            'promo_code' => 'required|string',
            'min_order_value' => 'required|numeric|min:1',
            'discount' => 'required|numeric',
            'start_date' => 'required|date', 
            'end_date' => 'required|date|after:start_date',
            'redeem_per_user' => 'required|integer|min:1',   
            'description' => 'nullable|string',
            'terms' => 'nullable|string',
            'status' => 'required|boolean',
           'type' => 'required|in:percentage,fixed',
        ]);
        if ($request->type === 'percentage') {
            $validator->after(function ($validator) use ($request) {
                if ($request->discount < 0 || $request->discount > 100) {
                    $validator->errors()->add('discount', 'The percentage must be between 0 and 100.');
                    return redirect()->back()->withErrors($validator);
                }
            });
        }
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $coupon->name = $request->input('name');
        $coupon->logo = $request->input('logo');
        $coupon->promocode = $request->input('promo_code');
        $coupon->minimum_amount = $request->input('min_order_value');
        $coupon->discount = $request->input('discount');
        $coupon->start_date = $request->input('start_date');
        $coupon->end_date = $request->input('end_date');
        $coupon->max_uses_per_user = $request->input('redeem_per_user');
        $coupon->description = $request->input('description');
        $coupon->terms_and_conditions = $request->input('terms');
        $coupon->status = $request->input('status');
        $coupon->type = $request->input('type');
        $coupon->save();
        $success = true ;
        if($success) {
            return redirect()->route('coupon.index')->with('success', 'Coupon updated successfully');
        } else {
            return redirect()->route('coupon.index')->with('error', 'Failed to update Coupon');
        }
    }
    public function changeStatus(Request $request) {
        $validator = Validator::make($request->all(),[
            'coupon_id' => 'required|exists:coupons,id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $coupon = Coupon::find($request->coupon_id);
        if(!$coupon) { 
            return redirect()->route('coupon.index')->with('error','coupon Not Found');
        }
        $coupon->status = !$coupon->status;
        $coupon->save();
    
        return response()->json([
            'status' => $coupon->status,
            'message' => 'coupon status updated successfully.',
        ]);
    }
    public function destroy($id)
    {
        try {
            $coupon = Coupon::findOrFail($id);
            $coupon->delete();
            Session::flash('success','Coupon deleted successfully!');
            return response()->json(['success' => 'Coupon deleted successfully!'], 200);
        } catch (\Exception $e) {
            Session::flash('error','Failed to delete the Coupon!');
            return response()->json(['error' => 'Failed to delete the Coupon!'], 422);
        }
    }
}
