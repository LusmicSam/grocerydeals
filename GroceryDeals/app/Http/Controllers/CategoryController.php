<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function apiIndex()
    {
        return response()->json([], 200);
    }
}
