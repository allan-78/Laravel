<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $query = $request->input('q');
        
        if ($query) {
            // Use Laravel Scout with database driver to search for products
            $products = Product::search($query)
                ->query(function ($builder) {
                    $builder->where('is_active', true);
                })
                ->paginate(6);
        } else {
            // When not searching, fetch featured products
            // Get active products to display on the home page
            $products = Product::where('is_active', true)
                ->latest()
                ->take(3)
                ->get();
        }
        
        return view('home', compact('products'));
    }
}
