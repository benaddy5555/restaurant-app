@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('shop.index') }}">Shop</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        @php
        $templateImages = [
            'specials-1.png', 'specials-2.png', 'specials-3.png', 
            'specials-4.png', 'specials-5.png'
        ];
      @endphp
        <div class="col-lg-6">
            <div class="card">
                <img src="{{ asset('images/products/' . $product->image) }}" 
     class="card-img-top" alt="{{ $product->name }}" 
     style="height: 400px; object-fit: cover;"
     onerror="this.src='{{ asset('assets/img/specials-1.png') }}';">
                
                <div class="card-body">
                    <h2 class="card-title">{{ $product->name }}</h2>
                    <p class="badge bg-info mb-2">{{ $product->category->name }}</p>
                    <p class="card-text">{{ $product->description }}</p>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="h3 text-primary">{{ formatCurrency($product->price) }}</span>
                        <span class="badge {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                            {{ $product->stock }} in stock
                        </span>
                    </div>

                    @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product) }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input type="number" name="quantity" value="1" min="1" 
                                           max="{{ $product->stock }}" class="form-control" id="quantity">
                                    <small class="text-muted">Maximum: {{ $product->stock }} items</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <i class="bi bi-cart-plus"></i> Add to Cart
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else
                        <button class="btn btn-secondary btn-lg w-100" disabled>
                            <i class="bi bi-x-circle"></i> Out of Stock
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <!-- Product Details -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Product Details</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Category:</strong></td>
                            <td>{{ $product->category->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Price:</strong></td>
                            <td class="text-primary h4">{{ formatCurrency($product->price) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Availability:</strong></td>
                            <td>
                                <span class="badge {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>SKU:</strong></td>
                            <td>MF-{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Related Products</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($relatedProducts as $index => $relatedProduct)
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100">
                                        <img src="{{ asset('assets/img/' . $templateImages[($index + 1) % 5]) }}" 
                                             class="card-img-top" alt="{{ $relatedProduct->name }}" 
                                             style="height: 120px; object-fit: cover;">
                                        
                                        <div class="card-body">
                                            <h6 class="card-title small">{{ $relatedProduct->name }}</h6>
                                            <p class="text-primary fw-bold">{{ formatCurrency($relatedProduct->price) }}</p>
                                            
                                            <div class="d-grid gap-1">
                                                <a href="{{ route('shop.show', $relatedProduct) }}" 
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-eye"></i> View
                                                </a>
                                                
                                                @if($relatedProduct->stock > 0)
                                                    <form action="{{ route('cart.add', $relatedProduct) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            <i class="bi bi-cart-plus"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-secondary btn-sm" disabled>
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.card-img-top {
    border-radius: 8px 8px 0 0;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

.breadcrumb {
    background: transparent;
    padding: 1rem 0;
    margin-bottom: 2rem;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: ">";
    float: none;
    padding: 0 0.5rem;
}
</style>
@endsection
