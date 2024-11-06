<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Session::get('cart', []);
        $cartProducts = [];  
        $totalPrice = 0;    
    
        foreach ($cartItems as $item) {
            $product = Product::find($item['product_id']);
            
            if ($product) {
                $cartProducts[] = [
                    'product' => $product,
                    'variant_id' => $item['variant_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'attributes' => $item['attributes'],
                ];
                $totalPrice += $item['price'] * $item['quantity'];
            }
        }
    
        return view('Cart.index', compact('cartProducts', 'totalPrice'));
    }
    

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'variant_id' => 'nullable|integer', // Allow variant_id to be nullable
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric',
            'variants' => 'nullable|array', // Make variants optional for products without variants
        ]);
    
        $product_id = $request->input('product_id');
        $variant_id = $request->input('variant_id');
        $quantity = $request->input('quantity');
        $price = $request->input('price');
        $attributes = $request->input('variants', []);
    
        // If there is no variant_id, use product_id as the key in the cart
        $cartKey = $variant_id ?? $product_id;
        $cart = session()->get('cart', []);
    
        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                'product_id' => $product_id,
                'variant_id' => $variant_id,
                'quantity' => $quantity,
                'attributes' => $attributes,
                'price' => $price,
            ];
        }
    
        session()->put('cart', $cart);
        \Log::info('Updated Cart:', session()->get('cart'));
        return response()->json(['success' => true, 'message' => 'Item added to cart']);
    }
    
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'variant_id' => 'nullable|integer',
        ]);
    
        $productId = $request->input('product_id');
        $variantId = $request->input('variant_id');
        $cart = session()->get('cart', []);
    
        // Find the item in the cart
        $itemKey = $variantId ? $variantId : $productId;
    
        if (isset($cart[$itemKey])) {
            unset($cart[$itemKey]); // Remove the item from the cart
            session()->put('cart', $cart); // Update the session
    
            // Calculate the new total price
            $totalPrice = array_reduce($cart, function ($sum, $item) {
                return $sum + ($item['price'] * $item['quantity']);
            }, 0);
    
            return response()->json([
                'success' => true,
                'cartTotal' => number_format($totalPrice, 2),
                'message' => 'Item removed from cart',
            ]);
        }
    
        return response()->json(['success' => false, 'message' => 'Item not found in cart']);
    }
    

public function updateQuantity(Request $request)
{
    $request->validate([
        'product_id' => 'required|integer',
        'variant_id' => 'nullable|integer', // variant_id is now nullable
        'quantity' => 'required|integer|min:1'
    ]);

    $productId = $request->input('product_id');
    $variantId = $request->input('variant_id');
    $newQuantity = $request->input('quantity');

    // Determine cart key: use variant_id if present, otherwise use product_id
    $cartKey = $variantId ?? $productId;

    // Get the cart from the session
    $cart = session()->get('cart', []);

    // Check if the item exists in the cart
    if (isset($cart[$cartKey])) {
        // Update the quantity
        $cart[$cartKey]['quantity'] = $newQuantity;
        
        // Calculate new subtotal for the item
        $itemSubtotal = $cart[$cartKey]['price'] * $newQuantity;
        $cart[$cartKey]['subtotal'] = $itemSubtotal;

        // Update the cart in the session
        session()->put('cart', $cart);

        // Calculate the updated total for the entire cart
        $cartTotal = array_reduce($cart, function ($total, $item) {
            return $total + ($item['price'] * $item['quantity']);
        }, 0);

        return response()->json([
            'success' => true,
            'itemSubtotal' => number_format($itemSubtotal, 2),
            'cartTotal' => number_format($cartTotal, 2)
        ]);
    } else {
        return response()->json(['success' => false, 'message' => 'Item not found in cart'], 404);
    }
}


}
