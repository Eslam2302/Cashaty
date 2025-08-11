<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Category;
use App\Models\StockTransaction;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Routing\Controller;



class OrderController extends Controller
{


    // Permissions Security
    public function __construct()
    {
        $this->middleware('permission:view orders')->only(['index','show']);
        $this->middleware('permission:create order')->only(['create', 'store']);
        $this->middleware('permission:edit order')->only(['edit', 'update','completed','cancel','refund',]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Order::with('customer', 'products')->latest();

        if($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('id', 'like', '%' . $request->search . '%')
                ->orWhereHas('customer', function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                })
                ->orWhereDate('created_at', $request->search)
                ->orWhere('status', 'like', '%' . $request->search . '%');
            });
        }

        $orders = $query->with(['lastActivity.causer'])->get();


        return view('orders.index', compact('orders'));
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

        try {
            $data = $request->all();

            // لو جاي مصفوفة جواها كائن
            if (isset($data[0])) {
                $data = $data[0];
            }

            $order = Order::create([
                'total' =>  $data['total'],
                'customer_id' => $data['customer_id'] ?? null,
            ]);

            foreach ($data['items'] as $item) {
                $order->products()->attach($item['id'], [
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);

                // تسجيل خروج من المخزن
                StockTransaction::create([
                    'product_id' => $item['id'],
                    'type' => 'out',
                    'quantity' => $item['quantity'],
                    'notes' => 'Order #' . $order->id,
                ]);
            }

            return response()->json([
                'message' => __('orders.order_saved'),
                'order_id' => $order->id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => __('orders.order_error'),
                'error' => $e->getMessage()
            ], 500);
        };




    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('products', 'customer');

        return view('orders.show', compact('order'));

    }

    /**
     * Change the status of the order.
     */

    public function completed(Request $request, Order $order){

        if($order->status != 'pending'){
            return back()->with('error', __(key: 'orders.only_pending_completed'));
        }

        $validated = $request->validate([
            'payment_method'    =>  'required|in:cash,visa,instapay,credit',
        ]);

        $order->update([
            'status' => 'completed',
            'payment_method'    =>  $validated['payment_method']
        ]);
        $order->save();

        // ناقص رسالة الايرور لو محترناش طريقة الدفع

        return back()->with('success', __('orders.order_completed'));
    }

    public function cancel(Order $order){

        if($order->status != 'pending'){
            return back()->with('error', __(key: 'orders.only_pending_cancelled'));
        }

        // رجع الكمية لكل منتج
        foreach ($order->products as $product) {
            StockTransaction::create([
            'product_id' => $product->id,
            'quantity'   => $product->pivot->quantity, // الكمية اللي كانت في الأوردر
            'type'       => 'in', // دخول مخزون
            'notes'       => __('orders.transaction_in_cancel') . $order->id,
            ]);
        }

        $order->update(['status' => 'cancelled']);

        $order->save();

        return back()->with('success', __('orders.order_cancelled'));

    }

    public function refund(Order $order){

        if($order->status != 'completed'){
            return back()->with('error', __(key: 'orders.only_completed_refund'));
        }

        // رجع الكمية لكل منتج
        foreach ($order->products as $product) {
            StockTransaction::create([
            'product_id' => $product->id,
            'quantity'   => $product->pivot->quantity, // الكمية اللي كانت في الأوردر
            'type'       => 'in', // دخول مخزون
            'notes'      => __('orders.transaction_in_refund') . $order->id,
            ]);
        }

        $order->update(['status' => 'refunded']);
        $order->save();
        return back()->with('success', __('orders.order_refunded'));


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