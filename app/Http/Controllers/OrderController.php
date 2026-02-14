<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->with('orderItems.product')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    // Admin methods
    public function adminIndex()
    {
        $orders = Order::with('user')->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Check if the order belongs to the authenticated user or if user is admin
        if (auth()->id() !== $order->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $order->load('orderItems.product', 'user');
        
        // Return appropriate view based on user role
        if (auth()->user()->isAdmin()) {
            return view('admin.orders.show', compact('order'));
        } else {
            return view('orders.show', compact('order'));
        }
    }

    public function edit(Order $order)
    {
        // Only admins can edit orders
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $order->load('orderItems.product', 'user');
        return view('admin.orders.edit', compact('order'));
    }

    public function userCancel(Order $order)
    {
        // Check if order belongs to authenticated user
        if (auth()->id() !== $order->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow cancellation for pending orders
        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be cancelled.');
        }

        try {
            DB::beginTransaction();

            // Update order status
            $order->update(['status' => 'cancelled']);

            // Restore product stock
            foreach ($order->orderItems as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            // Delete order items
            $order->orderItems()->delete();

            DB::commit();

            return redirect()->route('orders.index')
                ->with('success', 'Order #' . $order->id . ' has been cancelled successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->with('error', 'There was an error cancelling your order. Please try again.');
        }
    }

    public function updateStatus(Request $request, Order $order)
    {
        // Only admins can update orders
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:pending,processing,delivered',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated successfully.');
    }

    public function cancel(Order $order)
    {
        // Only admins can cancel orders
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow cancellation for pending orders
        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be cancelled.');
        }

        try {
            DB::beginTransaction();

            // Update order status
            $order->update(['status' => 'cancelled']);

            // Restore product stock
            foreach ($order->orderItems as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            // Delete order items
            $order->orderItems()->delete();

            DB::commit();

            return redirect()->route('admin.orders.show', $order)
                ->with('success', 'Order #' . $order->id . ' has been cancelled successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->with('error', 'There was an error cancelling the order. Please try again.');
        }
    }
}
