<?php

namespace App\Http\Controllers;

use App\Models\stockTransaction;
use Illuminate\Http\Request;
use App\Models\Product;

class StockTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = stockTransaction::with('product')->latest();
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->whereHas('product', function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                })
                ->orWhere('type', 'like', '%' . $request->search . '%')
                ->orWhere('quantity', 'like', '%' . $request->search . '%')
                ->orWhere('created_at', 'like', '%' . $request->search . '%');
            });
        }

        $stockTransactions = $query->with(['lastActivity.causer'])->get();

        return view('stockTransactions.index', compact( 'stockTransactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('stockTransactions.create',compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated   = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:in,out',
            'notes' => 'nullable|string|max:255',
        ]);

        stockTransaction::create($validated);
        return redirect()->route('stockTransactions.index')->with('success', __('stockTransactions.transaction_success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(stockTransaction $stockTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(stockTransaction $stockTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, stockTransaction $stockTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(stockTransaction $stockTransaction)
    {
        //
    }
}
