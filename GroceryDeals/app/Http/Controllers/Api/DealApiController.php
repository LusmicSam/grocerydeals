<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use Illuminate\Http\Request;

class DealApiController extends Controller
{
    /**
     * Display a listing of active deals with products.
     * GET /api/deals
     */
    public function index()
    {
        $deals = Deal::active()->get();
        
        $data = $deals->map(function($deal) {
            return [
                'id' => $deal->_id,
                'title' => $deal->title,
                'description' => $deal->description,
                'discount_percent' => $deal->discount_percent,
                'expires_at' => $deal->expires_at,
                'products' => $deal->getProducts()
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }
}
