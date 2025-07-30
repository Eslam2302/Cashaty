<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Log;



class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        $categories = Category::with('products')->get();

        return view('orders.create', compact('customers','products','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        Log::info($request->all());


        try {
            $order = Order::create([
                'total' => floatval($request->total),
            ]);

            foreach ($request->items as $item) {
                $order->products()->attach($item['id'], [
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }

            return response()->json(['message' => '✅ تم حفظ الأوردر بنجاح']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => '❌ حصل خطأ أثناء الحفظ',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}