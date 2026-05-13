<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;

class CartController extends Controller
{
    // Display the cart
    public function index()
    {
        $cart  = session()->get('cart', []);
        $total = 0;
        $cleaned = [];

        // Enrich cart with latest product data from DB
        // Also removes stale items that lack price (old session data before fix)
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $item['name']     = $product->name;
                $item['price']    = round($product->price * (1 - ($product->discount_percentage ?? 0) / 100), 2);
                $item['image']    = $product->image_url ?? null;
                $item['category'] = $product->category ?? '';
                $item['discount'] = $product->discount_percentage ?? 0;
                $total += $item['price'] * ($item['quantity'] ?? 1);
                $cleaned[$id] = $item;
            }
            // stale items (product deleted or old session without price) are silently dropped
        }

        // Persist cleaned cart back to session
        session()->put('cart', $cleaned);
        $cart = $cleaned;

        return view('cart.index', compact('cart', 'total'));
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'id'       => $productId,
                'quantity' => 1,
                'name'     => $product->name,
                'price'    => $product->price * (1 - ($product->discount_percentage ?? 0) / 100),
                'image'    => $product->image_url ?? null,
                'category' => $product->category ?? '',
            ];
        }

        session()->put('cart', $cart);
        session()->flash('success', '✅ ' . $product->name . ' added to cart!');

        return redirect()->back();
    }

    public function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $name = $cart[$productId]['name'] ?? 'Item';
            unset($cart[$productId]);
            session()->put('cart', $cart);
            session()->flash('success', $name . ' removed from cart.');
        }

        return redirect()->back();
    }

    public function getCart()
    {
        return response()->json(session()->get('cart', []));
    }

    public function clearCart()
    {
        Session::forget('cart');
        session()->flash('success', 'Cart cleared successfully!');
        return redirect()->route('cart.index');
    }
}
