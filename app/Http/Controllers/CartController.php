<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Use firstOrCreate to ensure cart exists
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        
        $cart->load('cartItems.product');
        
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        // DEBUG: Log incoming data
        \Log::info('Add to cart called', [
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => $request->quantity,
            'user_id' => auth()->id(),
            'user_authenticated' => auth()->check()
        ]);

        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock,
        ]);

        $user = auth()->user();
        
        // DEBUG: Check user
        \Log::info('User check', [
            'user_exists' => $user ? true : false,
            'user_id' => $user->id ?? null
        ]);
        
        // Use firstOrCreate to ensure cart is created
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        
        // DEBUG: Check cart
        \Log::info('Cart check', [
            'cart_id' => $cart->id,
            'cart_user_id' => $cart->user_id
        ]);

        $cartItem = $cart->cartItems()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($newQuantity > $product->stock) {
                return back()->with('error', 'Not enough stock available. Only ' . $product->stock . ' items left.');
            }
            $cartItem->update(['quantity' => $newQuantity]);
            \Log::info('Cart item updated', ['cart_item_id' => $cartItem->id, 'new_quantity' => $newQuantity]);
        } else {
            \Log::info('Creating new cart item', [
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity
            ]);
            
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
            
            \Log::info('Cart item created', ['cart_item_id' => $cartItem->id]);
        }

        \Log::info('Cart items count after add', ['count' => $cart->cartItems()->count()]);

        return back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $cartItem->product->stock,
        ]);

        if ($request->quantity > $cartItem->product->stock) {
            return back()->with('error', 'Not enough stock available. Only ' . $cartItem->product->stock . ' items left.');
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cart updated successfully!');
    }

    public function remove(CartItem $cartItem)
    {
        $cartItem->delete();

        return back()->with('success', 'Item removed from cart!');
    }

    public function clear()
    {
        $user = auth()->user();
        if ($user->cart) {
            $user->cart->cartItems()->delete();
        }

        return back()->with('success', 'Cart cleared successfully!');
    }

    public function getCartCount()
    {
        $user = auth()->user();
        if (!$user || !$user->cart) {
            return 0;
        }

        return $user->cart->total_items;
    }
}
