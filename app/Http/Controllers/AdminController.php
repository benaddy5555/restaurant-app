<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_price');

        $recentOrders = Order::with('user')->latest()->take(5)->get();
        
        // Get top sold products, but if none have been sold, show latest products
        $soldProducts = Product::with('category')
            ->withCount('orderItems')
            ->whereHas('orderItems')
            ->orderByDesc('order_items_count')
            ->take(5)
            ->get();
            
        if ($soldProducts->count() > 0) {
            $topProducts = $soldProducts;
        } else {
            // Show latest products if none have been sold
            $topProducts = Product::with('category')
                ->latest()
                ->take(5)
                ->get();
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalProducts', 
            'totalOrders',
            'totalRevenue',
            'recentOrders',
            'topProducts'
        ));
    }
}
