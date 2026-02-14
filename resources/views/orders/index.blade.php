@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">My Orders</h1>
        </div>
    </div>

    @if($orders->count() > 0)
        <div class="row">
            @foreach($orders as $order)
                <div class="col-lg-12 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Order #{{ $order->id }}</h5>
                            <span class="badge bg-{{ $order->status_color }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h6>Order Details</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>Order Date:</strong></td>
                                            <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Amount:</strong></td>
                                            <td class="text-primary h5">{{ formatCurrency($order->total_price) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                <span class="badge bg-{{ $order->status_color }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>

                                    <h6 class="mt-4">Items Ordered</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
        $templateImages = [
            'specials-1.png', 'specials-2.png', 'specials-3.png', 
            'specials-4.png', 'specials-5.png'
        ];
      @endphp
                @foreach($order->orderItems as $index => $item)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ asset('assets/img/' . $templateImages[$index % 5]) }}" 
                                                                     alt="{{ $item->product->name }}" 
                                                                     class="img-fluid rounded me-2" 
                                                                     style="max-width: 40px; max-height: 40px;">
                                                                {{ $item->product->name }}
                                                            </div>
                                                        </td>
                                                        <td>{{ formatCurrency($item->price) }}</td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td class="fw-bold">{{ formatCurrency($item->subtotal) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="alert alert-info">
                                        <h6><i class="bi bi-info-circle"></i> Order Status</h6>
                                        <div class="mb-3">
                                            <strong>Current Status:</strong><br>
                                            <span class="badge bg-{{ $order->status_color }} fs-6">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>

                                        @switch($order->status)
                                            @case('pending')
                                                <p class="mb-0">Your order has been received and is being processed.</p>
                                                <p class="small text-muted">We'll send you updates as your order progresses.</p>
                                                @break
                                            
                                            @case('processing')
                                                <p class="mb-0">Your order is being prepared for shipment.</p>
                                                <p class="small text-muted">Expected delivery in 1-2 business days.</p>
                                                @break
                                            
                                            @case('delivered')
                                                <p class="mb-0">Your order has been delivered!</p>
                                                <p class="small text-muted">Thank you for choosing Marina Fish.</p>
                                                <p class="small text-muted">Enjoy your fresh seafood!</p>
                                                @break
                                        @endswitch
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        @if($order->status === 'pending')
                                            <form action="{{ route('orders.userCancel', $order) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="bi bi-x-circle"></i> Cancel Order
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <a href="{{ route('shop.index') }}" class="btn btn-outline-primary">
                                            <i class="bi bi-plus-circle"></i> Order Again
                                        </a>
                                        <button class="btn btn-outline-secondary" onclick="window.print()">
                                            <i class="bi bi-printer"></i> Print Receipt
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links() }}
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-box-seam fa-4x text-muted mb-3"></i>
                <h4>No orders yet</h4>
                <p class="text-muted">You haven't placed any orders yet. Start shopping to see your orders here!</p>
                <a href="{{ route('shop.index') }}" class="btn btn-primary">
                    <i class="bi bi-cart-plus"></i> Start Shopping
                </a>
            </div>
        </div>
    @endif
</div>

<style>
.table th {
    border-top: none;
    font-weight: 600;
    color: #6c757d;
}

.badge {
    font-size: 0.875rem;
}
</style>
@endsection
