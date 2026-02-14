@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Order Details</h1>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back to Orders
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <!-- Order Information -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6 class="text-muted mb-3">Order Information</h6>
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Order ID:</strong></td>
                            <td>#{{ $order->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Customer:</strong></td>
                            <td>{{ $order->user->name }} ({{ $order->user->email }})</td>
                        </tr>
                        <tr>
                            <td><strong>Order Date:</strong></td>
                            <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                <span class="badge bg-{{ $order->status_color }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Total Amount:</strong></td>
                            <td class="h4 text-primary">{{ formatCurrency($order->total_price) }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted mb-3">Update Status</h6>
                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="d-inline">
                        @csrf
                        <div class="input-group">
                            <select name="status" class="form-select" required>
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            </select>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Update Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Items -->
            <h6 class="text-muted mb-3">Items Ordered</h6>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                            <tr>
                                <td>
                                    <div>
                                        <strong>{{ $item->product->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $item->product->category->name }}</small>
                                    </div>
                                </td>
                                <td>
                                    <img src="{{ asset('images/products/' . $item->product->image) }}" 
                                         alt="{{ $item->product->name }}" 
                                         class="img-fluid rounded" 
                                         style="max-width: 60px; max-height: 60px; object-fit: cover;"
                                         onerror="this.src='{{ asset('assets/img/specials-1.png') }}';">
                                </td>
                                <td>{{ formatCurrency($item->price) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="fw-bold">{{ formatCurrency($item->subtotal) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Order Summary -->
            <div class="row mt-4">
                <div class="col-md-8"></div>
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title">Order Summary</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>{{ formatCurrency($order->total_price) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping:</span>
                                <span>Free</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax:</span>
                                <span>{{ formatCurrency(0) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total:</strong>
                                <strong class="h4 text-primary">{{ formatCurrency($order->total_price) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex gap-2">
                        @if($order->status === 'pending')
                            <form action="{{ route('admin.orders.cancel', $order) }}" method="POST" class="d-inline-block"
                                  onsubmit="return confirm('Are you sure you want to cancel this order? This will restore product stock and cannot be undone.');">
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-x-circle"></i> Cancel Order
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Order
                        </a>
                        
                        @if($order->status === 'cancelled')
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">
                                <i class="bi bi-plus"></i> Create New Order
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
