@extends('layouts.app')

@section('content')
<!-- Page Title -->
<div class="page-title" style="background-image: url('{{ asset('assets/img/page-title-bg.webp') }}');">
  <div class="container position-relative">
    <h1 data-aos="fade-up">About Marina Fish</h1>
    <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">About</li>
      </ol>
    </nav>
  </div>
</div>

<!-- About Section -->
<section id="about" class="about section">

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row gy-4">
      <div class="col-lg-6 order-1 order-lg-2">
        <img src="{{ asset('assets/img/about.jpg') }}" class="img-fluid about-img" alt="About Marina Fish">
      </div>
      <div class="col-lg-6 order-2 order-lg-1 content">
        <h3>Our Story</h3>
        <p class="fst-italic">
          Founded in 2024, Marina Fish brings the ocean's finest seafood directly to your table. 
          We believe that everyone deserves access to fresh, high-quality seafood, 
          sourced responsibly and delivered with care.
        </p>
        <ul>
          <li><i class="bi bi-check2-all"></i> <span>Daily fresh catches from local fishermen</span></li>
          <li><i class="bi bi-check2-all"></i> <span>Sustainable and responsible sourcing</span></li>
          <li><i class="bi bi-check2-all"></i> <span>Quality guarantee on every order</span></li>
          <li><i class="bi bi-check2-all"></i> <span>Fast, reliable delivery service</span></li>
        </ul>
        <p>
          Our commitment to quality and freshness has made us the trusted choice for seafood lovers 
          who demand nothing but the best for their families and restaurants.
        </p>
      </div>
    </div>

  </div>

</section>

<!-- Why Us Section -->
<section id="why-us" class="why-us section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Why Choose Marina Fish?</h2>
    <p>What Makes Us Different</p>
  </div>

  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
        <div class="card-item">
          <span>01</span>
          <h4>Fresh Quality</h4>
          <p>We source our seafood daily and maintain strict quality control from ocean to your door.</p>
        </div>
      </div>

      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
        <div class="card-item">
          <span>02</span>
          <h4>Sustainable Sourcing</h4>
          <p>We partner with responsible fishermen who share our commitment to ocean conservation.</p>
        </div>
      </div>

      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
        <div class="card-item">
          <span>03</span>
          <h4>Expert Curation</h4>
          <p>Our seafood experts personally select and inspect every product for quality and freshness.</p>
        </div>
      </div>
    </div>
  </div>

</section>

<!-- Contact Information Section -->
<section id="contact-info" class="contact-info section">

  <div class="container" data-aos="fade-up" data-aos-delay="400">

    <div class="row gy-4">
      <div class="col-lg-4">
        <div class="info-item">
          <i class="bi bi-geo-alt flex-shrink-0"></i>
          <div>
            <h4 style="background-color: #000000ff; color: white; padding: 10px; border-radius: 5px;">Our Location</h4>
            <p>{{ config('contact.address') }}</p>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="info-item">
          <i class="bi bi-phone flex-shrink-0"></i>
          <div>
            <h4 style="background-color: #000000ff; color: white; padding: 10px; border-radius: 5px;">Contact Us</h4>
            <p><strong>Phone:</strong> {{ config('contact.phone') }}<br>
            <strong>Email:</strong> {{ config('contact.email') }}</p>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="info-item">
          <i class="bi bi-clock flex-shrink-0"></i>
          <div>
            <h4 style="background-color: #000000ff; color: white; padding: 10px; border-radius: 5px;">Business Hours</h4>
            <p><strong>Monday - Friday:</strong> {{ config('contact.business_hours.monday_friday') }}<br>
            <strong>Saturday:</strong> {{ config('contact.business_hours.saturday') }}<br>
            <strong>Sunday:</strong> {{ config('contact.business_hours.sunday') }}</p>
          </div>
        </div>
      </div>
    </div>

  </div>

</section>


<style>
.page-title {
  background-size: cover;
  background-position: center;
  padding: 120px 0 80px;
  position: relative;
}

.page-title h1 {
  font-size: 48px;
  font-weight: 700;
  color: white;
  margin-bottom: 20px;
}

.breadcrumb {
  background: rgba(255, 255, 255, 0.1);
  padding: 15px;
  border-radius: 50px;
}

.breadcrumb-item {
  color: rgba(255, 255, 255, 0.8);
}

.breadcrumb-item.active {
  color: white;
}

.about-img {
  border-radius: 15px;
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.card-item {
  background: white;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
  text-align: center;
  height: 100%;
}

.card-item span {
  display: block;
  font-size: 36px;
  font-weight: 700;
  color: var(--color-primary);
  margin-bottom: 15px;
}

.team-member {
  text-align: center;
  margin-bottom: 30px;
}

.member-img {
  width: 180px;
  height: 180px;
  border-radius: 50%;
  overflow: hidden;
  margin: 0 auto 15px;
}

.member-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.member-info h4 {
  font-size: 18px;
  font-weight: 600;
  margin-bottom: 5px;
}

.member-info span {
  display: block;
  font-size: 13px;
  color: #6c757d;
  margin-bottom: 15px;
}

.social a {
  color: #6c757d;
  margin-right: 10px;
  font-size: 16px;
}

.social a:hover {
  color: var(--color-primary);
}
</style>
@endsection
