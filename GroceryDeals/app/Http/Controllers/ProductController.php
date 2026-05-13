<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ProductController extends Controller
{
    /**
     * Display a listing of the grocery products.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->paginate(12);

        // 8. Attach a cookie remembering the last viewed category (cookie name: last_category, expire: 60 minutes)
        Cookie::queue('last_category', $request->category ?? 'all_products', 60);

        // 5. Show how to pass data to views using compact() and with()
        return view('products.index', compact('products'))->with('title', 'Grocery Products');
    }

    /**
     * Show the form for creating a new grocery product.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created grocery product in storage.
     * Uses StoreProductRequest Form Request for full validation.
     */
    public function store(StoreProductRequest $request)
    {
        // $request->validated() returns only the validated fields
        $validated = $request->validated();

        // Handle file upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $deal = Product::create($validated);

        // Show how to retrieve, store, and forget cookies
        $lastCategory = request()->cookie('last_category'); // Retrieve
        $forgetCookie = cookie()->forget('last_category');  // Forget
        $newCookie = Cookie::make('new_deal', $deal->name, 60); // Create

        // Email functionality example
        $user = \App\Models\User::first();
        if ($user) {
            // Send to a single user
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\DealAlertMail($deal, $user));

            // Send to multiple users
            $users = \App\Models\User::all();
            if ($users->isNotEmpty()) {
                \Illuminate\Support\Facades\Mail::to($users)->send(new \App\Mail\DealAlertMail($deal, $user));
            }
        }

        return redirect()->route('products.index')
            ->with('success', 'Grocery deal added successfully!')
            ->withCookie($newCookie)
            ->withCookie($forgetCookie);
    }

    /**
     * Display the specified grocery product.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified grocery product.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified grocery product in storage.
     * Uses StoreProductRequest — image is nullable on update because
     * the Form Request detects the route('product') parameter.
     */
    public function update(StoreProductRequest $request, $id)
    {
        $validated = $request->validated();

        $product = Product::findOrFail($id);

        // Only replace image if a new file was uploaded
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        } else {
            // Keep the existing image — remove from validated to avoid overwriting with null
            unset($validated['image']);
        }

        $product->update($validated);

        return redirect()->route('products.show', $product->_id)->with('success', 'Grocery deal updated successfully!');
    }

    /**
     * Remove the specified grocery product from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Grocery product removed.');
    }

    public function apiIndex()
    {
        $products = Product::all();

        // 9. Show a JSON response for the API endpoint with proper headers and status codes
        return response()->json($products, 200, [
            'Content-Type' => 'application/json',
            'X-API-Version' => '1.0'
        ]);
    }

    // =========================================================================
    // TASK #9 — Alternative: Inline Validation directly in controller
    // (no Form Request class needed)
    // =========================================================================
    /**
     * Example of validating directly in the controller using $request->validate()
     * and Validator::make() — useful for simple endpoints.
     *
     * NOTE: For MongoDB we always do manual unique checks (no unique:products).
     */
    public function storeWithInlineValidation(Request $request)
    {
        // --- Option A: $request->validate() — simplest inline form ---
        $validated = $request->validate([
            'name'           => 'required|string|min:3|max:100',
            'price'          => 'required|numeric|min:0.01',
            'original_price' => 'required|numeric|gte:price',
            'category'       => 'required|in:fruits,vegetables,dairy,bakery,beverages,snacks',
            'stock'          => 'required|integer|min:0',
            'image'          => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description'    => 'nullable|string|max:500',
        ], [
            // Custom messages inline (no messages() method needed)
            'name.required'      => 'A product name is essential.',
            'original_price.gte' => 'Original price must be >= sale price.',
            'category.in'        => 'Pick a valid category.',
            'image.required'     => 'An image is required for new products.',
        ]);

        // MongoDB-compatible unique check — after $request->validate() passes
        if (Product::where('name', $validated['name'])->exists()) {
            return back()
                ->withErrors(['name' => 'A product with this name already exists.'])
                ->withInput();
        }

        // Discount business-rule check (replaces ValidDiscount rule)
        if ($request->filled('discount') && $request->discount > 90) {
            return back()
                ->withErrors(['discount' => 'Discount cannot exceed 90%.'])
                ->withInput();
        }

        // --- Option B: Validator::make() — for more control ---
        // $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
        //     'name' => 'required|string|min:3|max:100',
        //     ...
        // ]);
        //
        // $validator->after(function ($v) use ($request) {
        //     if (Product::where('name', $request->name)->exists()) {
        //         $v->errors()->add('name', 'A product with this name already exists.');
        //     }
        // });
        //
        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->withInput();
        // }
        // $validated = $validator->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created!');
    }
}
