<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * The Controller in MVC:
 * Acts as an intermediary between Models and Views. It listens to user 
 * requests, processes business logic, fetches data, and returns a View.
 */
class WelcomeController extends Controller
{
    public function index()
    {
        // Fetch featured products for the homepage
        $products = \App\Models\Product::limit(8)->get();

        // Returns the 'welcome' view with products data
        return view('welcome', compact('products'));
    }
}
