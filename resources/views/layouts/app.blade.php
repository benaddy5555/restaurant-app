<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Marina Fish - {{ isset($title) ? $title : 'Fresh Seafood Online' }}</title>
  <meta name="description" content="Fresh seafood delivered to your door. Premium quality fish, shellfish, and seafood specialties.">
  <meta name="keywords" content="seafood, fresh fish, lobster, crab, salmon, online seafood store">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

  <!-- Laravel CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
<style>
.cart-link {
  position: relative;
}

.cart-count {
  position: absolute;
  top: -8px;
  right: -8px;
  background: #dc3545;
  color: white;
  border-radius: 50%;
  width: 18px;
  height: 18px;
  font-size: 11px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
}
</style>

</head>

<body class="index-page">

  <header id="header" class="header fixed-top">

    <div class="branding d-flex align-items-center">
      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="{{ route('home') }}" class="logo d-flex align-items-center me-auto me-xl-0">
          <h1 class="sitename">Marina Fish</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('shop.index') }}" class="{{ request()->routeIs('shop.*') ? 'active' : '' }}">Shop</a></li>
            <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a></li>
            <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
            
            @guest
              <li class="dropdown"><a href="#"><span>Account</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="{{ route('login') }}">Login</a></li>
                  <li><a href="{{ route('register') }}">Register</a></li>
                </ul>
              </li>
            @else
              <li class="dropdown">
                <a href="#">
                  <span>{{ auth()->user()->name }}</span> 
                  <i class="bi bi-chevron-down toggle-dropdown"></i>
                </a>
                <ul>
                  <li><a href="{{ route('account.user') }}">My Account</a></li>
                  <li><a href="{{ route('orders.index') }}">My Orders</a></li>
                  @if(auth()->user()->isAdmin())
                    <li><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                  @endif
                  <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                </ul>
              </li>
            @endauth
            
            <li>
              <a href="{{ route('cart.index') }}" class="cart-link">
                <i class="bi bi-cart3"></i>
                Cart
                @if(auth()->check() && auth()->user()->cart && auth()->user()->cart->total_items > 0)
                  <span class="cart-count">{{ auth()->user()->cart->total_items }}</span>
                @endif
              </a>
            </li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

      </div>
    </div>

  </header>

  <main class="main">
    @yield('content')
  </main>

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-4 col-md-6 footer-about">
            <a href="{{ route('home') }}" class="logo d-flex align-items-center">
              <span class="sitename">Marina Fish</span>
            </a>
            <div class="footer-contact pt-3">
              <p>{{ config('contact.description') }}</p>
              <p><strong>Phone:</strong> <span>{{ config('contact.phone') }}</span></p>
              <p><strong>Email:</strong> <span>{{ config('contact.email') }}</span></p>
            </div>
          </div>

          <div class="col-lg-2 col-md-3 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><a href="{{ route('home') }}">Home</a></li>
              <li><a href="{{ route('shop.index') }}">Shop</a></li>
              <li><a href="{{ route('about') }}">About Us</a></li>
              <li><a href="{{ route('contact') }}">Contact</a></li>
            </ul>
          </div>

          <div class="col-lg-2 col-md-3 footer-links">
            <h4>Our Products</h4>
            <ul>
              <li><a href="#">Fresh Fish</a></li>
              <li><a href="#">Shellfish</a></li>
              <li><a href="#">Seafood Specialties</a></li>
              <li><a href="#">Smoked & Cured</a></li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-12 footer-newsletter">
            <h4>Our Newsletter</h4>
            <p>Subscribe to our newsletter and receive exclusive offers and new product updates!</p>
            <form action="" method="post">
              <div class="newsletter-form">
                <input type="email" name="email"><input type="submit" value="Subscribe">
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>

    <div class="footer-legal">
      <div class="container">
        <div class="row justify-content-between">
          <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
            <div class="copyright">
              © Copyright <strong><span>Marina Fish</span></strong>. All Rights Reserved
            </div>
          </div>

          <div class="col-md-6">
            <div class="social-links mb-3 mb-md-0">
              <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
              <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

  <!-- Laravel Logout Form -->
  @auth
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
    </form>
  @endauth

  <!-- Flash Messages -->
  @if(session('success'))
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        alert('{{ session('success') }}');
      });
    </script>
  @endif

  @if(session('error'))
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        alert('{{ session('error') }}');
      });
    </script>
  @endif

</body>

</html>
