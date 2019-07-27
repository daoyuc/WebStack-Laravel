<?php

namespace App\Http\Controllers;

use App\Category;

class HomeController extends Controller
{
    public function index()
    {
        $theme = config('common.theme');
        if ($theme == 'default') {
            return view('index', [
                'categories' => Category::with('children', 'sites')->orderBy('order')->get(),
            ]);
        } else  {
            return view($theme . '.index', [
                'categories' => Category::with('children', 'sites')->orderBy('order')->get(),
            ]);
        }
    }

    public function about()
    {
        return view('about');
    }
}
