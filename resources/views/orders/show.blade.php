@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">My Orders</a></li>
            <li class="breadcrumb-item active">Order #{{ $order->id }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <strong>Order Number:</strong><br>
                            #{{ $order->id }}
                        </div>
                        <div class="col-md-6">
                            <strong>Order Date:</strong><br>
                            {{ $order->created_at->format('M d, Y H:i') }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <strong>Order Status:</strong><br>
                            <span class="badge bg-{{ $order->status_color }} fs-6">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <strong>Total Amount:</strong><br>
                            <span class="h4 text-primary">{{ formatCurrency($order->total_price) }}</span>
                        </div>
                    </div>

                    <h6>Items Ordered</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Unit Price</th>
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
                                                <img src="{{ asset('images/products/' . $item->product->image) }}" 
     alt="{{ $item->product->name }}" 
     class="img-fluid rounded me-3" 
     style="max-width: 50px; max-height: 50px;"
     onerror="this.src='{{ asset('assets/img/specials-1.png') }}';">
                                                <div>
                                                    <strong>{{ $item->product->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $item->product->category->name }}</small>
                                                </div>
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

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5>Order Total: <span class="text-primary">{{ formatCurrency($order->total_price) }}</span></h5>
                                <div>
                                    @if($order->status === 'pending')
                                        <form action="{{ route('orders.userCancel', $order) }}" method="POST" class="d-inline-block"
                                              onsubmit="return confirm('Are you sure you want to cancel this order? This will restore product stock and cannot be undone.');">
                                            @csrf
                                            <button type="submit" class="btn btn-danger me-2">
                                                <i class="bi bi-x-circle"></i> Cancel Order
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <a href="{{ route('shop.index') }}" class="btn btn-outline-primary">
                                        <i class="bi bi-plus-circle"></i> Order Again
                                    </a>
                                    <button class="btn btn-outline-secondary" onclick="window.print()">
                                        <i class="bi bi-printer"></i> Print
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Customer Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Customer Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>{{ $order->user->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ $order->user->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Customer ID:</strong></td>
                            <td>#{{ str_pad($order->user->id, 5, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Order Status Timeline -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order Status</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item {{ $order->status == 'pending' ? 'active' : 'completed' }}">
                            <div class="timeline-dot bg-primary"></div>
                            <div class="timeline-content">
                                <h6>Order Received</h6>
                                <p class="small">{{ $order->created_at->format('M d, Y H:i') }}</p>
                                <p>Your order has been received and is being processed.</p>
                            </div>
                        </div>

                        <div class="timeline-item {{ $order->status == 'processing' || $order->status == 'delivered' ? 'active' : '' }}">
                            <div class="timeline-dot bg-info"></div>
                            <div class="timeline-content">
                                <h6>Processing</h6>
                                <p class="small">Your order is being prepared for shipment.</p>
                                <p>We're carefully selecting and packaging your seafood items.</p>
                            </div>
                        </div>

                        <div class="timeline-item {{ $order->status == 'delivered' ? 'active' : '' }}">
                            <div class="timeline-dot bg-success"></div>
                            <div class="timeline-content">
                                <h6>Delivered</h6>
                                <p class="small">Expected: {{ $order->created_at->addDays(2)->format('M d, Y') }}</p>
                                <p>Your fresh seafood has been delivered!</p>
                            </div>
                        </div>
                    </div>
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

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding-bottom: 30px;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -30px;
    top: 0;
    height: 100%;
    width: 2px;
    background: #e9ecef;
}

.timeline-item.completed::before {
    background: var(--color-primary);
}

.timeline-dot {
    position: absolute;
    left: -38px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
}

.timeline-content {
    margin-left: 20px;
}

.timeline-content h6 {
    margin-bottom: 5px;
}

.timeline-item.active .timeline-content h6 {
    color: var(--color-primary);
}
</style>
@endsection
