<?php

namespace App\Http\Controllers;

use App\Models\BillingAddress;
use App\Models\City;
use App\Models\Country;
use App\Models\Customer;
use App\Models\ShippingAddress;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class customerCrud extends Controller
{
    public function index() {
       return view('custome.index');
    }
    public function getData(Request $request)
    {
        $query = Customer::latest();
    
        // Filtering
        if ($request->has('search') && !empty($request->get('search')['value'])) {
            $searchValue = $request->get('search')['value'];
            $query->where('name', 'like', "%{$searchValue}%")
            ->orWhere('email', 'like', "%{$searchValue}%");
        }
    
        // Sorting
        if ($request->has('order')) {
            $columnIndex = $request->get('order')[0]['column'];
            $columnName = $request->get('columns')[$columnIndex]['data'];
            $direction = $request->get('order')[0]['dir'];
    
            // Define mapping for columns in DataTable to actual columns in the database
            $columnMap = [
                'name' => 'name',
                'email' => 'email',
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
    
        $customers = $query->skip($page * $perPage)->take($perPage)->get(); // Fetch records
    
        return response()->json([
            'draw' => intval($request->get('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, // Assuming no additional filtering beyond search
            'data' => $customers->map(function ($customer) {
                return [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'status' =>   $this->getStatusBadge($customer),
                    'options' => $this->generateCustomersOptions($customer)
                ];
            })
        ]);
    }
    private function generateCustomersOptions($customer)
    {
        $actions = '';
        if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<a href="'.route('customer.edit',$customer->id).'" name="btn-edit" class="btn btn-info me-2" data-id="7" title="Edit"><i class="fas fa-edit"></i></a>';
        }
        if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<button type="button" name="btn-delete" class="btn btn-danger" data-id="'. $customer->id .'" title="Delete"><i class="fas fa-trash"></i></button>';
        }
        return $actions ? '<div class="">' . $actions . '</div>' : '';
    }
    public function getStatusBadge($customer)
    {
        $isChecked = $customer->status == 1 ? 'checked' : '';

        return '
            <div class="form-check form-switch form-switch-md">
                <input class="form-check-input customer_status_change" type="checkbox" data-id="' . $customer->id . '" ' . $isChecked . '>
                <label class="form-check-label"></label>
            </div>
        ';
        // if ($customer->status == 1) {
        //     return '<a href="javascript:void(0)" class="fs-4 customer_status_change" data-id="' . $customer->id . '"><i class="text-success fs-4 bx bxs-lock-open-alt"></i></a>'; 
        // } else {
        //     return '<a href="javascript:void(0)" class="fs-4 customer_status_change"data-id="' . $customer->id . '"><i class="text-danger bx bxs-lock-alt"></i></a>'; 
        // }
    }
    public function create() {
        $countries = Country::where('status',1)->get();
        $states = State::where('status',1)->get();
        $cities = City::where('status',1)->get();
        return view('custome.create',compact('countries','states','cities'));
    }
    public function store(Request $request) {
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:6',
            'email' => 'required|email|max:255|string|unique:customers',
            'mobile_number' => 'nullable|numeric',
            'password' => 'required|string|confirmed',
            'status' => 'required|boolean',
            'avatar' => 'required|string',
            'billing_address' => 'nullable|string',
            'billing_country' => 'nullable|exists:country_info,id',
            'billing_state' => 'nullable|exists:state_info,id',
            'billing_city' => 'nullable|exists:city_info,id',
            'billing_postal' => 'nullable|string',
            'shipping_address' => 'nullable|string',
            'shipping_country' => 'nullable|exists:country_info,id',
            'shipping_state' => 'nullable|exists:state_info,id',
            'shipping_city' => 'nullable|exists:city_info,id',
            'shipping_postal' => 'nullable|string',
            'shipping_phone' => 'nullable|numeric',
            'billing_phone' => 'nullable|numeric',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->contact = $request->mobile_number;
        $customer->avatar = $request->avatar;
        $customer->password = Hash::make($request->password);
        $customer->status = $request->status;
        $customer->save();


        $billing = new BillingAddress();
        $billing->customer_id = $customer->id;
        $billing->address_line_1 = $request->billing_address;
        $billing->country_id = $request->billing_country;
        $billing->state_id = $request->billing_state;
        $billing->city_id = $request->billing_city;
        $billing->postal_code = $request->billing_postal;
        $billing->contact = $request->billing_phone;
        $billing->save();

        $shipping = new ShippingAddress();
        $shipping->customer_id = $customer->id;
        $shipping->address_line_1 = $request->shipping_address;
        $shipping->country_id = $request->shipping_country;
        $shipping->state_id = $request->shipping_state;
        $shipping->city_id = $request->shipping_city;
        $shipping->postal_code = $request->shipping_postal;
        $shipping->contact = $request->shipping_phone;
        $shipping->save();
        $success = true;
        if($success) {
            return redirect()->route('customer.index')->with('success','Customer created successfully');
            } else {
                return redirect()->back()->with('error','Customer creation failed');
        }
    }
    public function edit($id) {
        $customer = Customer::with('billingAddress','shippingAddress')->find($id);
        if(!$customer) {
            return redirect()->route('customer.index')->with('error','Customer not found');
        }
        $countries = Country::where('status',1)->get();
        $states = State::where('status',1)->get();
        $cities = City::where('status',1)->get();
        return view('custome.edit',compact('countries','states','cities','customer'));
    }
    public function update(Request $request,$id) {
        // dd($request->all());
        $customer = Customer::find($id);
        if(!$customer) {
            return redirect()->route('customer.index')->with('error','Customer Not Found');
        }
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:6',
            'email' => 'required|email|max:255|string|unique:customers,email,' . $customer->id,
            'mobile_number' => 'nullable|numeric',
            'password' => 'nullable|string|confirmed',
            'status' => 'required|boolean',
            'avatar' => 'required|string',
            'billing_address' => 'nullable|string',
            'billing_country' => 'nullable|exists:country_info,id',
            'billing_state' => 'nullable|exists:state_info,id',
            'billing_city' => 'nullable|exists:city_info,id',
            'billing_postal' => 'nullable|string',
            'shipping_address' => 'nullable|string',
            'shipping_country' => 'nullable|exists:country_info,id',
            'shipping_state' => 'nullable|exists:state_info,id',
            'shipping_city' => 'nullable|exists:city_info,id',
            'shipping_postal' => 'nullable|string',
            'shipping_phone' => 'nullable|numeric',
            'billing_phone' => 'nullable|numeric',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->contact = $request->mobile_number;
        $customer->status = $request->status;
        $customer->avatar = $request->avatar;
        if ($request->filled('password')) {
            $customer->password = Hash::make($request->input('password')); 
        }
        if ($customer->save()) {
            // Uncomment this to handle billing and shipping addresses
            $customer->billingAddress()->updateOrCreate(
                ['customer_id' => $customer->id],
                [
                    'address_line_1' => $request->billing_address,
                    'country_id' => $request->billing_country,
                    'state_id' => $request->billing_state,
                    'city_id' => $request->billing_city,
                    'postal_code' => $request->billing_postal,
                    'contact' => $request->billing_phone,
                ]
            );
            $customer->shippingAddress()->updateOrCreate(
                ['customer_id' => $customer->id],
                [
                    'address_line_1' => $request->shipping_address,
                    'country_id' => $request->shipping_country,
                    'state_id' => $request->shipping_state,
                    'city_id' => $request->shipping_city,
                    'postal_code' => $request->shipping_postal,
                    'contact' => $request->shipping_phone,
                ]
            );
    
            return redirect()->route('customer.index')->with('success', 'Customer updated successfully');
        } else {
            return redirect()->back()->with('error', 'Customer update failed');
        }
    }
    public function destroy($id) {
        $customer = Customer::find($id);
    if (!$customer) {
        if (request()->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found',
            ], 404);
        }
        return redirect()->route('customer.index')->with('error', 'Customer Not Found');
    }
    // Delete the billing address if it exists
    if ($customer->billingAddress) {
        $customer->billingAddress->delete();
    }

    // Delete the shipping address if it exists
    if ($customer->shippingAddress) {
        $customer->shippingAddress->delete();
    }
    // Delete customer
    $customer->delete();

    // Return success response for AJAX requests
    if (request()->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Customer deleted successfully',
        ]);
    }

    // Return redirect for non-AJAX requests
    return redirect()->route('customer.index')->with('success', 'Customer deleted successfully');
    }
    public function changeStatus(Request $request) {
        $validator = Validator::make($request->all(),[
            'customer_id' => 'required|exists:customers,id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $customer = Customer::find($request->customer_id);
        if(!$customer) { 
            return redirect()->route('customer.index')->with('error','Customer Not Found');
        }
        $customer->status = !$customer->status;
        $customer->save();
    
        return response()->json([
            'status' => $customer->status,
            'message' => 'Customer status updated successfully.',
        ]);
    }
}
