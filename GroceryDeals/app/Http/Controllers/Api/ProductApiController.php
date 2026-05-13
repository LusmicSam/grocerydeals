<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductApiController extends Controller
{
    /**
     * Display a paginated listing of products with filters.
     * GET /api/products
     */
    public function index(Request $request)
    {
        $query = Product::active();

        // Filter by category
        if ($request->has('category')) {
            $query->byCategory($request->category);
        }

        // Search by name (Regex search)
        if ($request->has('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        // Sort by price
        if ($request->sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $products = $query->paginate(12);

        return response()->json([
            'status' => 'success',
            'data' => $products
        ], 200);
    }

    /**
     * Store a newly created product.
     * POST /api/products
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'original_price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();
        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $data['is_active'] ?? true;

        $product = Product::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    /**
     * Display the specified product.
     * GET /api/products/{id}
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $product
        ], 200);
    }

    /**
     * Update the specified product.
     * PUT/PATCH /api/products/{id}
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);
    }

    /**
     * Remove the specified product.
     * DELETE /api/products/{id}
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully'
        ], 200);
    }

    /**
     * Demonstrating MongoDB Specific Features
     */
    public function mongodbFeatures(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) return response()->json(['message' => 'Product not found'], 404);

        // 1. $product->push('images', $newImage) — add to array
        if ($request->has('new_image')) {
            $product->push('images', $request->new_image);
        }

        // 2. Product::where('tags', 'all', ['organic', 'fresh']) — array query
        $organicFresh = Product::where('tags', 'all', ['organic', 'fresh'])->get();

        // 3. Product::raw(['$text' => ['$search' => $query]]) — text search
        // Note: Requires a text index on the collection
        $searchResult = [];
        if ($request->has('q')) {
            $searchResult = Product::raw(function($collection) use ($request) {
                return $collection->find(['$text' => ['$search' => $request->q]]);
            });
        }

        return response()->json([
            'pushed_image' => $product->images,
            'organic_fresh_count' => $organicFresh->count(),
            'raw_search_count' => count($searchResult->toArray())
        ]);
    }
}
