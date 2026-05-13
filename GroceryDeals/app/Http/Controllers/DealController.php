<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DealController extends Controller
{
    public function index()
    {
        $deals = \App\Models\Deal::where('is_active', true)->get();
        return view('deals.index', compact('deals'));
    }

    public function apiIndex()
    {
        return response()->json([], 200);
    }
}
