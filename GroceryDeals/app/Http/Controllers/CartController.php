<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Display the cart
    public function index()
    {
        // Show storing and accessing session data
        $sessionData = session()->all();
        $hasCart = session()->has('cart');
        
        $cart = session()->get('cart', []);
        
        return view('cart.index', compact('cart', 'hasCart', 'sessionData'));
    }

    public function addToCart($productId)
    {
        // Example: session()->get()
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'id' => $productId,
                'quantity' => 1
            ];
        }

        // Example: session()->put()
        session()->put('cart', $cart);
        
        // Flash messages
        session()->flash('success', 'Item added to cart!');

        return redirect()->back();
    }

    public function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            
            // Example: session()->put()
            session()->put('cart', $cart);
            
            session()->flash('success', 'Item removed from cart!');
        }

        return redirect()->back();
    }

    public function getCart()
    {
        // Return all cart items
        return response()->json(session()->get('cart', []));
    }

    public function clearCart()
    {
        // Example: Session::forget('cart')
        Session::forget('cart');
        // Equivalent to: session()->forget('cart');
        
        // Note: to clear EVERYTHING from the session, use session()->flush()
        // Example: session()->flush(); // Un-commenting this would clear all session data including login
        
        session()->flash('success', 'Cart cleared successfully!');
        
        return redirect()->back();
    }
}
