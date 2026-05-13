<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switchLanguage($lang)
    {
        session(['locale' => $lang]);
        return redirect()->back();
    }
}
