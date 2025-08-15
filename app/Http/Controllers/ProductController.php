<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\StockTransaction;
use Illuminate\Routing\Controller;


class ProductController extends Controller
{


    // Permissions Security
    public function __construct()
    {
        $this->middleware('permission:view products')->only(methods: ['index','byCategory']);
        $this->middleware('permission:view product')->only(['show']);
        $this->middleware('permission:add product')->only(['create', 'store']);
        $this->middleware('permission:edit product')->only(['edit', 'update']);
        $this->middleware('permission:delete product')->only(['destroy']);
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request['search'] . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request['category_id']);
        }

        $products = $query->latest()->paginate(60);
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));

    }

    // To get products by category
    public function byCategory($id)
    {
        $categories = Category::all();


        $category = Category::findOrFail($id);
        $products = Product::where('category_id', $id)->latest()->paginate(30);

        return view('products.index', [
            'products' => $products,
            'selectedCategory' => $category,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $slug = Str::slug($validated['name']);
        $validated['slug'] = $slug;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = $slug . '-' . time() . '.' . $extension;

            $image->move(public_path('uploads/products'), $imageName);
            $validated['image'] = $imageName;
        }

        Product::create($validated);
        return redirect()->route('products.index')->with('success', __('products.product_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        StockTransaction::where('product_id', $product->id)->get();
        // Fetch stock transactions for the product
        $stockTransactions = $product->stockTransactions()->latest()->get();
        // Pass the product and its stock transactions to the view
        return view('products.show', compact('product', 'stockTransactions'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'discount'  =>  'numeric',
        ]);

        $slug = Str::slug($validated['name']);
        $validated['slug'] = $slug;


        if ($request->hasFile('image')) {

            // Delete old image if exist
            if ($product['image'] && file_exists(public_path('uploads/products/' . $product['image']))) {
                unlink(public_path('uploads/products/' . $product['image']));
            }

            // Save new image
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = $slug . '-' . time() . '.' . $extension;

            $image->move(public_path('uploads/products'), $imageName);
            $validated['image'] = $imageName;
        } else {
            // if not new image -- stay with old image
            $validated['image'] = $product['image'];
        }



        $product->update($validated);

        return redirect()->route('products.index')->with('success', __('products.product_updated'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {

        // Bring image name
        $imagePath = public_path('uploads/products/' . $product['image']);

        // Delete image in file path
        if ($product['image'] && file_exists($imagePath)) {
            unlink($imagePath);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', __('products.product_deleted'));
    }
}
