<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
 
    public function index()
    {
        $total_sellers = User::where('user_type', 'seller')->count();
        
        $pending_sellers = User::where('user_type', 'seller')
            ->whereHas('seller', function($q) {
                $q->where('is_approved', false);
            })->count();

        $total_products = Product::count();
        $pending_products = Product::where('status', 'pending')->count();
        $approved_products = Product::where('status', 'approved')->count();
        $rejected_products = Product::where('status', 'rejected')->count();

        $total_orders = Order::count();
        $pending_orders = Order::where('payment_status', 'pending')->count();
        $completed_orders = Order::where('payment_status', 'paid')->count();

        $total_revenue = Order::where('payment_status', 'paid')
            ->sum('total_amount');

        $stats = compact(
            'total_sellers',
            'pending_sellers',
            'total_products',
            'pending_products',
            'approved_products',
            'rejected_products',
            'total_orders',
            'pending_orders',
            'completed_orders',
            'total_revenue'
        );

        $recent_orders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        $recent_products = Product::with('seller', 'category')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'recent_products'));
    }
}