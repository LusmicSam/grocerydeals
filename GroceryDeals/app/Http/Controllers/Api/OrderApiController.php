<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderApiController extends Controller
{
    /**
     * Create a new order (Auth Required).
     * POST /api/orders
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array',
            'items.*.product_id' => 'required',
            'items.*.qty' => 'required|integer|min:1',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $total = 0;
        $orderItems = [];

        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $price = $product->price;
                $subtotal = $price * $item['qty'];
                $total += $subtotal;

                $orderItems[] = [
                    'product_id' => $product->_id,
                    'name' => $product->name,
                    'price' => $price,
                    'qty' => $item['qty'],
                    'image' => $product->image
                ];
            }
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'items' => $orderItems,
            'total' => $total,
            'status' => 'pending',
            'address' => $request->address
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order created successfully',
            'data' => $order
        ], 201);
    }

    /**
     * Display user's orders (Auth Required).
     * GET /api/orders
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => $orders
        ], 200);
    }
}
