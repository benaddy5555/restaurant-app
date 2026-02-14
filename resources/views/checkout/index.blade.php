@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('shop.index') }}">Shop</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Cart</a></li>
            <li class="breadcrumb-item active">Checkout</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8">
            <!-- Cart Items Summary -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    @php
        $templateImages = [
            'specials-1.png', 'specials-2.png', 'specials-3.png', 
            'specials-4.png', 'specials-5.png'
        ];
      @endphp
                    @if($cart->cartItems->count() > 0)
                        @foreach($cart->cartItems as $index => $item)
                            <div class="row mb-3 pb-3 border-bottom">
                                <div class="col-md-2">
                                    <img src="{{ asset('images/products/' . $item->product->image) }}" 
     alt="{{ $item->product->name }}" 
     class="img-fluid rounded" style="max-width: 60px;"
     onerror="this.src='{{ asset('assets/img/specials-1.png') }}';">
                                </div>
                                <div class="col-md-6">
                                    <h6>{{ $item->product->name }}</h6>
                                    <small class="text-muted">{{ $item->product->category->name }}</small>
                                </div>
                                <div class="col-md-2 text-center">
                                    <span class="badge bg-secondary">{{ $item->quantity }}</span>
                                </div>
                                <div class="col-md-2 text-center">
                                    <strong>{{ formatCurrency($item->subtotal) }}</strong>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-cart-x fa-3x text-muted mb-3"></i>
                            <h5>Your cart is empty</h5>
                            <p class="text-muted">Please add some products to your cart before checkout.</p>
                            <a href="{{ route('shop.index') }}" class="btn btn-primary">
                                <i class="bi bi-arrow-left"></i> Continue Shopping
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Shipping Information -->
            @if($cart->cartItems->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Shipping Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Full Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ auth()->user()->name }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email Address *</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ auth()->user()->email }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                           value="{{ auth()->user()->phone ?? '' }}" placeholder="+1 234 567 890">
                                </div>
                                <div class="col-md-6">
                                    <label for="address" class="form-label">Delivery Address *</label>
                                    <textarea class="form-control" id="address" name="address" 
                                              rows="3" required placeholder="Enter your full delivery address"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <label for="notes" class="form-label">Order Notes (Optional)</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3" 
                                              placeholder="Special instructions or delivery notes"></textarea>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Back to Cart
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-check-circle"></i> Place Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- Order Summary -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order Total</h5>
                </div>
                <div class="card-body">
                    @if($cart->cartItems->count() > 0)
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal ({{ $cart->total_items }} items):</span>
                            <strong>{{ formatCurrency($cart->total_price) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping:</span>
                            <strong class="text-success">FREE</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tax:</span>
                            <strong>{{ formatCurrency(0) }}</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <h4>Total:</h4>
                            <h4 class="text-primary">{{ formatCurrency($cart->total_price) }}</h4>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            <strong>Free Shipping</strong> on all orders over {{ formatCurrency(50) }}!
                        </div>

                        <div class="text-muted small">
                            <p><i class="bi bi-shield-check"></i> Secure checkout powered by Marina Fish</p>
                            <p><i class="bi bi-arrow-repeat"></i> 30-day freshness guarantee</p>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-cart-x fa-3x text-muted mb-3"></i>
                            <h5>No items to checkout</h5>
                            <p class="text-muted">Your cart is empty.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.breadcrumb {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 30px;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: ">";
    float: none;
    padding: 0 0.5rem;
    color: #6c757d;
}

.breadcrumb-item.active {
    color: var(--color-primary);
}

.card {
    border: none;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
}

.form-control:focus {
    border-color: var(--color-primary);
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}
</style>
@endsection
