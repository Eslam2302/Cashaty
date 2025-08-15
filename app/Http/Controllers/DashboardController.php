<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $todayOrdersCount = Order::whereDate('created_at', today())->count();

        $todayRevenue = Order::whereDate('created_at', today())
            ->where('status', 'completed')
            ->sum('total');

        $lowStockCount = Product::all()
            ->filter(fn($p) => $p->available_stock < 5)
            ->count();

        $inStockProductsCount = Product::all()
            ->filter(fn($p) => $p->available_stock > 0)
            ->count();

        $monthlyRevenue = Order::where('status','completed')
            ->whereMonth('created_at', now()->month)
            ->sum('total');

        $completedOrdersCount = Order::where('status','completed')
            ->whereMonth('created_at', now()->month)
            ->count();

        $customersCount = Customer::count();

        $topProduct = DB::table('order_product')
            ->join('products', 'order_product.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_product.quantity) as qty'))
            ->groupBy('products.name')
            ->orderByDesc('qty')
            ->first();

        $topProductName = $topProduct->name ?? '-';

        $recentOrders = Order::with('customer')
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard', compact(
            'todayOrdersCount',
            'todayRevenue',
            'lowStockCount',
            'inStockProductsCount',
            'monthlyRevenue',
            'completedOrdersCount',
            'customersCount',
            'topProductName',
            'recentOrders'
        ));
    }
}