<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\DataTables\ProductDataTable;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductDataTable $dataTable)
    {
        return $dataTable->render('products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'images' => function($query) {
            $query->orderBy('created_at', 'desc');
        }, 'reviews']);
        
        // Ensure images relationship is always initialized
        if (!$product->relationLoaded('images') || $product->images === null) {
            $product->setRelation('images', collect());
        }
        
        // Ensure reviews relationship is always initialized
        if (!$product->relationLoaded('reviews') || $product->reviews === null) {
            $product->setRelation('reviews', collect());
        }
        
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
    
    /**
     * Search for products using Laravel Scout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        if ($query) {
            $products = Product::search($query)->where('is_active', true)->get();
        } else {
            $products = Product::where('is_active', true)->get();
        }
        
        $categories = Category::all();
        
        return view('products.index', compact('products', 'categories'));
    }
}
