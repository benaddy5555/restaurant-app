<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Use firstOrCreate to ensure cart exists
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        
        $cart->load('cartItems.product');
        
        if ($cart->cartItems->count() === 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Please add some products first.');
        }

        // Check stock availability
        foreach ($cart->cartItems as $item) {
            if ($item->quantity > $item->product->stock) {
                return redirect()->route('cart.index')
                    ->with('error', 'Sorry, ' . $item->product->name . ' is out of stock or has insufficient quantity.');
            }
        }

        return view('checkout.index', compact('cart'));
    }

    public function process(Request $request)
    {
        $user = auth()->user();
        
        // Use firstOrCreate to ensure cart exists
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        
        $cart->load('cartItems.product');

        if ($cart->cartItems->count() === 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        // Validate stock one more time
        foreach ($cart->cartItems as $item) {
            if ($item->quantity > $item->product->stock) {
                return redirect()->route('cart.index')
                    ->with('error', 'Sorry, ' . $item->product->name . ' is out of stock.');
            }
        }

        try {
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $cart->total_price,
                'status' => 'pending',
            ]);

            // Create order items and update stock
            foreach ($cart->cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                // Update product stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Clear cart
            $cart->cartItems()->delete();

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Order placed successfully! Your order #' . $order->id . ' has been received.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('checkout.index')
                ->with('error', 'There was an error processing your order. Please try again.');
        }
    }
}
