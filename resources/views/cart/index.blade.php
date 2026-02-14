@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Shopping Cart</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($cart->cartItems->count() > 0)
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Cart Items ({{ $cart->total_items }})</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $templateImages = [
                                'specials-1.png', 'specials-2.png', 'specials-3.png', 
                                'specials-4.png', 'specials-5.png'
                            ];
                        @endphp
                        @foreach($cart->cartItems as $index => $item)
                            <div class="row mb-3 pb-3 border-bottom">
                                <div class="col-md-2">
                                    <img src="{{ asset('images/products/' . $item->product->image) }}" 
     alt="{{ $item->product->name }}" 
     class="img-fluid rounded" style="max-width: 60px;"
     onerror="this.src='{{ asset('assets/img/specials-1.png') }}';">
                                </div>
                                <div class="col-md-4">
                                    <h6>{{ $item->product->name }}</h6>
                                    <small class="text-muted">{{ $item->product->category->name }}</small>
                                    <p class="mb-0 small">{{ \Illuminate\Support\Str::limit($item->product->description, 100) }}</p>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group input-group-sm">
                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                                   min="1" max="{{ $item->product->stock }}" 
                                                   class="form-control form-control-sm" 
                                                   onchange="this.form.submit()">
                                        </form>
                                    </div>
                                    <small class="text-muted">Stock: {{ $item->product->stock }}</small>
                                </div>
                                <div class="col-md-2 text-center">
                                    <strong>{{ formatCurrency($item->subtotal) }}</strong>
                                </div>
                                <div class="col-md-2 text-center">
                                    <form action="{{ route('cart.remove', $item) }}" method="POST" 
                                          onsubmit="return confirm('Remove this item from cart?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal ({{ $cart->total_items }} items):</span>
                            <strong>{{ formatCurrency($cart->total_price) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping:</span>
                            <strong>Free</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <h5>Total:</h5>
                            <h5>{{ formatCurrency($cart->total_price) }}</h5>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('checkout.index') }}" class="btn btn-primary">
                                <i class="bi bi-credit-card"></i> Proceed to Checkout
                            </a>
                            <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Continue Shopping
                            </a>
                            <form action="{{ route('cart.clear') }}" method="POST" 
                                  onsubmit="return confirm('Clear entire cart?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                    <i class="bi bi-trash"></i> Clear Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-cart3 fa-4x text-muted mb-3"></i>
                <h4>Your cart is empty</h4>
                <p class="text-muted">Looks like you haven't added any seafood products to your cart yet.</p>
                <a href="{{ route('shop.index') }}" class="btn btn-primary">
                    <i class="bi bi-fish"></i> Start Shopping
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
