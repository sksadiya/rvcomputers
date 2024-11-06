<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\paymentSettings;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class checkoutController extends Controller
{
    public function index() {
        // Get the cart session
        $cart = session()->get('cart');
        $customer = Auth::guard('customer')->user();
        // Initialize the cart total
        $cartTotal = 0;
    
        // Check if there are items in the cart
        if ($cart) {
            // Loop through the cart and fetch product details for each item
            foreach ($cart as $key => &$item) {
                // Fetch the product using the product_id
                $product = Product::find($item['product_id']);
                
                // If the product exists, add its details to the cart item
                if ($product) {
                    $item['product'] = $product;
                    $item['product_name'] = $product->name;
                    $item['product_slug'] = $product->slug;
                    $item['product_price'] = $product->unit_price;
                    $item['product_image'] = $product->image; // Example if you have an image field
                }
                $cartTotal += $item['subtotal'];
            }
        }
        // dd($cart);
        $countries = Country::where('status' , 1)->get();
        return view('checkout', compact('cart', 'cartTotal','customer','countries'));
    }

    public function applyCoupon(Request $request)
    {
        // Validate the coupon code
        $request->validate([
            'coupon_code' => 'required|string',
            'cart_total'  => 'required|numeric',
        ]);
    
        $couponCode = $request->coupon_code;
        $cartTotal = $request->cart_total;
    
        // Fetch the coupon details from the database
        $coupon = Coupon::where('promocode', $couponCode)->first();
    
        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid coupon code']);
        }
        if (!$coupon->isValid()) {
            return response()->json(['success' => false, 'message' => 'Coupon has expired']);
        }
        // Calculate the discount based on the coupon
        $discount = 0;
        if ($coupon->type == 'fixed') {
            $discount = $coupon->discount;  // Fixed discount
        } elseif ($coupon->type == 'percentage') {
            $discount = ($cartTotal * $coupon->discount) / 100;  // Percentage discount
        }
    
        // Ensure the discount doesn't exceed the cart total
        $discount = min($discount, $cartTotal);
    
        // Return the discount amount and message
        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'discount' => $discount,
        ]);
    }
    
    
}
