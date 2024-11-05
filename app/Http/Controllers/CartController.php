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
        'variant_id' => 'required|integer',
        'quantity' => 'required|integer|min:1',
        'price' => 'required|numeric',
        'variants' => 'required|array', 
    ]);

    $product_id = $request->input('product_id');
    $variant_id = $request->input('variant_id');
    $quantity = $request->input('quantity');
    $price = $request->input('price');
    $attributes = $request->all()['variants'];

    $cart = session()->get('cart', []);

    if (isset($cart[$variant_id])) {
        $cart[$variant_id]['quantity'] += $quantity;
    } else {
        $cart[$variant_id] = [
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
        'variant_id' => 'required|integer',
    ]);

    $variantId = $request->input('variant_id');
    $cart = session()->get('cart', []);

    // Check if the item exists in the cart
    if (isset($cart[$variantId])) {
        unset($cart[$variantId]); // Remove the item from the cart
        session()->put('cart', $cart); // Update the session

        // Calculate the new total price
        $totalPrice = 0;
        foreach ($cart as $item) {
            // Assuming each item in the cart has 'price' and 'quantity'
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'cartTotal' => number_format($totalPrice, 2), // Return the updated cart total
            'message' => 'Item removed from cart'
        ]);
    }

    return response()->json(['success' => false, 'message' => 'Item not found in cart']);
}

public function updateQuantity(Request $request)
{
    $request->validate([
        'variant_id' => 'required|integer',
        'quantity' => 'required|integer|min:1'
    ]);

    $variantId = $request->input('variant_id');
    $newQuantity = $request->input('quantity');
    
    // Get the cart from the session
    $cart = session()->get('cart', []);
    
    // Check if the item exists in the cart
    if (isset($cart[$variantId])) {
        // Update the quantity
        $cart[$variantId]['quantity'] = $newQuantity;
        // Calculate new subtotal for the item
        $itemSubtotal = $cart[$variantId]['price'] * $newQuantity;
        $cart[$variantId]['subtotal'] = $itemSubtotal;
        
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
