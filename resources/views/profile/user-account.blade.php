@extends('layouts.app')

@section('title', 'My Account')

@section('content')
<section class="contact section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="section-title">
      <h2>My Account</h2>
      <p>Manage your account information and preferences.</p>
    </div>

    @if(session('status'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if(auth()->check())
      <!-- User Information Card -->
      <div class="row mb-4">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header bg-primary text-white">
              <h5 class="card-title mb-0">
                <i class="bi bi-person-circle me-2"></i>Account Information
              </h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-8">
                  <table class="table table-borderless">
                    <tr>
                      <td width="150"><strong>Full Name:</strong></td>
                      <td>{{ auth()->user()->name }}</td>
                    </tr>
                    <tr>
                      <td><strong>Email Address:</strong></td>
                      <td>{{ auth()->user()->email }}</td>
                    </tr>
                    <tr>
                      <td><strong>User Role:</strong></td>
                      <td>
                        <span class="badge bg-{{ auth()->user()->isAdmin() ? 'success' : 'primary' }}">
                          {{ ucfirst(auth()->user()->role) }}
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Member Since:</strong></td>
                      <td>{{ auth()->user()->created_at->format('F d, Y') }}</td>
                    </tr>
                    <tr>
                      <td><strong>Last Updated:</strong></td>
                      <td>{{ auth()->user()->updated_at->format('F d, Y') }}</td>
                    </tr>
                  </table>
                </div>
                <div class="col-md-4 text-center">
                  <div class="avatar-placeholder">
                    <i class="bi bi-person-circle" style="font-size: 80px; color: #007bff;"></i>
                    <h5 class="mt-2">{{ auth()->user()->name }}</h5>
                    <p class="text-muted">{{ ucfirst(auth()->user()->role) }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Action Cards -->
      <div class="row">
        <!-- Update Profile -->
        <div class="col-lg-6 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <h5 class="card-title">
                <i class="bi bi-pencil-square me-2"></i>Update Profile
              </h5>
              <p class="card-text">Update your personal information and email address.</p>
              
              <form action="{{ route('profile.update') }}" method="POST" class="mt-3">
                @csrf
                @method('PATCH')
                
                <div class="mb-3">
                  <label for="name" class="form-label">Full Name</label>
                  <input type="text" class="form-control" name="name" id="name" 
                         value="{{ old('name', auth()->user()->name) }}" required>
                </div>
                
                <div class="mb-3">
                  <label for="email" class="form-label">Email Address</label>
                  <input type="email" class="form-control" name="email" id="email" 
                         value="{{ old('email', auth()->user()->email) }}" required>
                </div>
                
                <div class="mb-3">
                  <label for="password" class="form-label">New Password (leave blank to keep current)</label>
                  <input type="password" class="form-control" name="password" id="password">
                </div>
                
                <div class="mb-3">
                  <label for="password_confirmation" class="form-label">Confirm New Password</label>
                  <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                </div>

                @if(auth()->user()->isAdmin())
                  <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" name="role" id="role">
                      <option value="user" {{ old('role', auth()->user()->role) == 'user' ? 'selected' : '' }}">User</option>
                      <option value="admin" {{ old('role', auth()->user()->role) == 'admin' ? 'selected' : '' }}">Admin</option>
                    </select>
                  </div>
                @endif>
                
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-check-circle me-2"></i>Update Profile
                </button>
              </form>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-6 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <h5 class="card-title">
                <i class="bi bi-lightning me-2"></i>Quick Actions
              </h5>
              <p class="card-text">Access your account features and settings.</p>
              
              <div class="d-grid gap-2 mt-3">
                <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                  <i class="bi bi-cart-check me-2"></i>View My Orders
                </a>
                
                <a href="{{ route('cart.index') }}" class="btn btn-outline-success">
                  <i class="bi bi-cart3 me-2"></i>My Shopping Cart
                </a>
                
                @if(auth()->user()->isAdmin())
                  <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-warning">
                    <i class="bi bi-speedometer2 me-2"></i>Admin Dashboard
                  </a>
                @endif>
                
                <a href="{{ route('contact') }}" class="btn btn-outline-info">
                  <i class="bi bi-envelope me-2"></i>Contact Support
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Account Statistics -->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header bg-info text-white">
              <h5 class="card-title mb-0">
                <i class="bi bi-graph-up me-2"></i>Account Statistics
              </h5>
            </div>
            <div class="card-body">
              <div class="row text-center">
                <div class="col-md-3">
                  <div class="stat-box">
                    <h3 class="text-primary">{{ \App\Models\Order::where('user_id', auth()->id())->count() }}</h3>
                    <p class="text-muted">Total Orders</p>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="stat-box">
                    <h3 class="text-success">{{ \App\Models\Order::where('user_id', auth()->id())->where('status', 'delivered')->count() }}</h3>
                    <p class="text-muted">Completed Orders</p>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="stat-box">
                    <h3 class="text-warning">{{ \App\Models\Order::where('user_id', auth()->id())->where('status', 'pending')->count() }}</h3>
                    <p class="text-muted">Pending Orders</p>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="stat-box">
                    <h3 class="text-info">{{ auth()->user()->cart ? auth()->user()->cart->total_items : 0 }}</h3>
                    <p class="text-muted">Cart Items</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Account Management -->
      <div class="row mt-4">
        <div class="col-lg-12">
          <div class="card border-danger">
            <div class="card-header bg-danger text-white">
              <h5 class="card-title mb-0">
                <i class="bi bi-shield-exclamation me-2"></i>Account Management
              </h5>
            </div>
            <div class="card-body">
              <div class="alert alert-warning">
                <h6><i class="bi bi-exclamation-triangle me-2"></i>Danger Zone</h6>
                <p class="mb-2">These actions are irreversible. Please be careful.</p>
              </div>
              
              <form action="{{ route('profile.destroy') }}" method="POST" class="d-inline">
                @csrf
                <div class="mb-3">
                  <label for="password" class="form-label">Confirm Password to Delete Account</label>
                  <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
                  <i class="bi bi-trash me-2"></i>Delete My Account
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>

    @else
      <div class="alert alert-warning">
        <h5>Not Authenticated</h5>
        <p>Please <a href="{{ route('login') }}">log in</a> to view your account information.</p>
      </div>
    @endif
  </div>
</section>

<style>
.stat-box {
  padding: 20px;
  border-radius: 8px;
  background: #f8f9fa;
  margin-bottom: 20px;
}

.stat-box h3 {
  font-size: 2.5rem;
  font-weight: bold;
  margin-bottom: 5px;
}

.stat-box p {
  margin: 0;
  font-size: 0.9rem;
}

.avatar-placeholder {
  padding: 20px;
  border-radius: 8px;
  background: #f8f9fa;
}
</style>
@endsection
