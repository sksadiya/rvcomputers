<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class reviewController extends Controller
{
    public function index() {
        return view('reviews.index');
    }
    public function getData(Request $request)
    {
        $query = Review::latest();
    
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
    
        $reviews = $query->skip($page * $perPage)->take($perPage)->get(); // Fetch records
    
        return response()->json([
            'draw' => intval($request->get('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, // Assuming no additional filtering beyond search
            'data' => $reviews->map(function ($review) {
                return [
                    'id' => $review->id,
                    'name' => $review->name,
                    'comment' => $review->comment,
                    'status' => $review->status == 1 
                    ? '<span class="badge rounded-pill badge-soft-primary font-size-12">Approve</span>' 
                    : '<span class="badge rounded-pill badge-soft-danger font-size-12">Disapprove</span>',
                    'approve' =>   $this->getStatusBadge($review),
                    'options' => $this->generateReviewOptions($review)
                ];
            })
        ]);
    }
    private function generateReviewOptions($review)
    {
        $actions = '';
        if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<a target="_blank" href="'.route('reviews.show',$review->id).'" name="btn-edit" class="btn btn-info me-2" title="Show"><i class="fas fa-eye me-2"></i>View</a>';
        }
        if (Auth::user()->hasRole('Super Admin')) {
            $actions .= '<button type="button" name="btn-delete" class="btn btn-danger" data-id="'. $review->id .'" title="Delete"><i class="fas fa-trash"></i></button>';
        }
        return $actions ? '<div class="">' . $actions . '</div>' : '';
    }
    public function getStatusBadge($review)
    {
        $isChecked = $review->status == 1 ? 'checked' : '';

        return '
            <div class="form-check form-switch form-switch-md">
                <input class="form-check-input review_status_change" type="checkbox" data-id="' . $review->id . '" ' . $isChecked . '>
                <label class="form-check-label"></label>
            </div>
        ';
    }
    public function store(Request $request) {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'product' => 'required|exists:products,id',
            'customer' => 'nullable|exists:customers,id',
            'rating' => 'required|numeric|min:1|max:5', 
            'comment' => 'nullable|string|max:500', 
            'name' => 'nullable|string|max:255|required_without:customer',
        'email' => 'nullable|email|max:255|required_without:customer',
        ], [
            'name.required_without' => 'The name field is required.',
            'email.required_without' => 'The email field is required.',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $review = new Review();
        if($request->customer) {
            $customer = Customer::find($request->customer);
            $review->name = $customer->name;
            $review->email = $customer->email;
        }  else {
            $review->name = $request->name;
            $review->email = $request->email;
        }
        $review->product_id = $request->product;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();
        return redirect()->back()->with('success', 'Review Submitted.');
    }

    public function destroy($id)
    {
        try {
            $review = Review::findOrFail($id);
            $review->delete();
            Session::flash('success','review deleted successfully!');
            return response()->json(['success' => 'review deleted successfully!'], 200);
        } catch (\Exception $e) {
            Session::flash('error','Failed to delete the review!');
            return response()->json(['error' => 'Failed to delete the review!'], 422);
        }
    }

    public function changeStatus(Request $request) {
        $validator = Validator::make($request->all(),[
            'review_id' => 'required|exists:reviews,id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $review = Review::find($request->review_id);
        if(!$review) { 
            return redirect()->route('reviews.index')->with('error','Review Not Found');
        }
        $review->status = !$review->status;
        $review->save();
    
        return response()->json([
            'status' => $review->status,
            'message' => 'review status updated successfully.',
        ]);
    }
    public function show($id)
    {
       $review = Review::find($id);
       if(!$review) {
        return redirect()->route('reviews.index')->with('error','Review Not Found');
       }
       return view('reviews.show' , compact('review'));
    }
}
