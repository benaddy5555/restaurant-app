@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section id="hero" class="hero section dark-background">

  <img src="{{ asset('assets/img/hero-bg.jpg') }}" alt="" data-aos="fade-in">

  <div class="container">
    <div class="row">
      <div class="col-lg-8 d-flex flex-column align-items-center align-items-lg-start">
        <h2 data-aos="fade-up" data-aos-delay="100">Welcome to <span>Marina Fish</span></h2>
        <p data-aos="fade-up" data-aos-delay="200">Premium seafood delivered fresh to your door!</p>
        <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
          <a href="{{ route('shop.index') }}" class="cta-btn">Shop Now</a>
          <a href="{{ route('about') }}" class="cta-btn">Learn More</a>
        </div>
      </div>
      <div class="col-lg-4 d-flex align-items-center justify-content-center mt-5 mt-lg-0">
      </div>
    </div>
  </div>

</section><!-- End Hero Section -->

<!-- About Section -->
<section id="about" class="about section">

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row gy-4">
      <div class="col-lg-6 order-1 order-lg-2">
        <img src="{{ asset('assets/img/about.jpg') }}" class="img-fluid about-img" alt="Fresh Seafood">
      </div>
      <div class="col-lg-6 order-2 order-lg-1 content">
        <h3>Why Choose Marina Fish?</h3>
        <p class="fst-italic">
          We bring the ocean's finest seafood directly to your table, ensuring freshness and quality in every bite.
        </p>
        <ul>
          <li><i class="bi bi-check2-all"></i> <span>Premium quality seafood sourced daily</span></li>
          <li><i class="bi bi-check2-all"></i> <span>Sustainable and responsible fishing practices</span></li>
          <li><i class="bi bi-check2-all"></i> <span>Fresh delivery guaranteed or your money back</span></li>
        </ul>
        <p>
          Experience the difference that fresh, premium seafood makes in your favorite dishes.
        </p>
      </div>
    </div>

  </div>

</section><!-- End About Section -->

<!-- Featured Products Section -->
<section id="featured-products" class="menu section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Featured Products</h2>
    <p>Our Premium Seafood Selection</p>
  </div><!-- End Section Title -->

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row">
      @php
        $templateImages = [
          'specials-1.png', 'specials-2.png', 'specials-3.png', 
          'specials-4.png', 'specials-5.png'
        ];
        $featuredProducts = \App\Models\Product::with('category')->inRandomOrder()->take(6)->get();
      @endphp

      @foreach($featuredProducts as $index => $product)
        <div class="col-lg-4 menu-item">
          <div class="card h-100">
            <img src="{{ asset('assets/img/' . $templateImages[$index % 5]) }}" 
                 class="card-img-top" alt="{{ $product->name }}" 
                 style="height: 200px; object-fit: cover;">
            
            <div class="card-body">
              <h5 class="card-title">{{ $product->name }}</h5>
              <p class="card-text">{{ \Illuminate\Support\Str::limit($product->description, 80) }}</p>
              <div class="d-flex justify-content-between align-items-center">
                <span class="h4 text-primary">{{ formatCurrency($product->price) }}</span>
                <small class="text-muted">Stock: {{ $product->stock }}</small>
              </div>
              <div class="mt-3">
                <a href="{{ route('shop.show', $product) }}" class="btn btn-primary w-100">View Details</a>
                <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-2">
                  @csrf
                  <div class="input-group">
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control" placeholder="Qty">
                    <button type="submit" class="btn btn-outline-primary">
                      <i class="bi bi-cart-plus"></i> Add to Cart
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="text-center mt-4">
      <a href="{{ route('shop.index') }}" class="btn btn-outline-primary btn-lg">
        <i class="bi bi-grid"></i> View All Products
      </a>
    </div>

  </div>

</section><!-- End Featured Products Section -->

<!-- Call to Action Section -->
<section id="cta" class="cta section">
  <div class="container" data-aos="zoom-in">

    <div class="text-center">
      <h3>Ready to Order Fresh Seafood?</h3>
      <p>Join thousands of satisfied customers who trust Marina Fish for quality and freshness.</p>
      <a class="cta-btn" href="{{ route('shop.index') }}">Shop Now</a>
    </div>

  </div>
</section>

<style>
.cta-btn {
    display: inline-block;
    padding: 12px 30px;
    background: var(--color-primary);
    color: white;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 500;
    transition: all 0.3s ease;
    margin: 0 10px;
}

.cta-btn:hover {
    background: var(--color-primary-dark);
    transform: translateY(-2px);
}

.dark-background {
    background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ asset('assets/img/hero-bg.jpg') }}');
    background-size: cover;
    background-position: center;
    color: white;
    padding: 120px 0;
}

.about-img {
    border-radius: 10px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}
</style>
@endsection
