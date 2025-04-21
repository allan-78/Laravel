<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Imports\ProductsImport;
use App\DataTables\ProductDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(ProductDataTable $dataTable)
    {
        return $dataTable->render('admin.products.index');
    }



    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'nullable|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $product = Product::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'nullable|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'images_to_delete' => 'nullable|array',
            'images_to_delete.*' => 'exists:product_images,id'
        ]);

        // Handle image deletion if images are selected to be deleted
        if ($request->has('delete_images') && $request->has('images_to_delete')) {
            foreach ($request->images_to_delete as $imageId) {
                $image = ProductImage::find($imageId);
                if ($image && $image->product_id === $product->id) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }
            return back()->with('success', 'Selected images have been deleted.');
        }

        $product->update($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    /**
     * Show import form
     */
    public function showImportForm()
    {
        \Log::info('Import form accessed - checking middleware');
        if (!auth()->check()) {
            \Log::warning('User not authenticated');
        }
        if (!auth()->user()->isAdmin()) { // Adjust based on your admin check
            \Log::warning('User is not admin');
        }
        
        return view('admin.products.import');
    }

    /**
     * Import products from Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048'
        ]);
    
        try {
            Excel::import(new ProductsImport, $request->file('file'));
            return redirect()->route('admin.products.index')
                       ->with('success', 'Products imported successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error importing file: '.$e->getMessage());
        }
    }

    /**
     * Delete a product image.
     */
    public function destroyImage(ProductImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();
        return back()->with('success', 'Image deleted successfully.');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }
}