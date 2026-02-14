@extends('layouts.app')

@section('content')
<!-- Page Title -->
<div class="page-title" style="background-image: url('{{ asset('assets/img/page-title-bg.webp') }}');">
  <div class="container position-relative">
    <h1 data-aos="fade-up">Contact Us</h1>
    <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Contact</li>
      </ol>
    </nav>
  </div>
</div>

<!-- Contact Section -->
<section id="contact" class="contact section">

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row gy-4">
      <div class="col-lg-4">
        <div class="info-item">
          <i class="bi bi-geo-alt flex-shrink-0"></i>
          <div>
            <h4 style="background-color: #000000ff; color: white; padding: 10px; border-radius: 5px;">Address</h4>
            <p>{{ config('contact.address') }}</p>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="info-item">
          <i class="bi bi-envelope flex-shrink-0"></i>
          <div>
            <h4 style="background-color: #000000ff; color: white; padding: 10px; border-radius: 5px;">Email</h4>
            <p><a href="mailto:info@marinafish.com">info@marinafish.com</a></p>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="info-item">
          <i class="bi bi-phone flex-shrink-0"></i>
          <div>
            <h4 style="background-color: #000000ff; color: white; padding: 10px; border-radius: 5px;">Call Us</h4>
            <p><strong>Phone:</strong> {{ config('contact.phone') }}<br><strong>Hours:</strong> Mon-Fri: 9AM-6PM</p>
          </div>
        </div>
      </div>

    </div>

  </div>

  <div class="container mt-5" data-aos="fade-up" data-aos-delay="200">
    <div class="row gy-4">
      <div class="col-lg-6">
        <div class="info-item">
          <i class="bi bi-clock flex-shrink-0"></i>
          <div>
            <h4 style="background-color: #000000ff; color: white; padding: 10px; border-radius: 5px;">Business Hours</h4>
            <p>
              <strong>Monday - Friday:</strong> 9:00 AM - 6:00 PM<br>
              <strong>Saturday:</strong> 10:00 AM - 4:00 PM<br>
              <strong>Sunday:</strong> Closed
            </p>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="info-item">
          <i class="bi bi-truck flex-shrink-0"></i>
          <div>
            <h4 style="background-color: #000000ff; color: white; padding: 10px; border-radius: 5px;">Delivery Information</h4>
            <p>
              <strong>Local Delivery:</strong> Same-day delivery for orders before 2 PM<br>
              <strong>Shipping:</strong> 2-3 business days nationwide<br>
              <strong>Free Shipping:</strong> On orders over {{ formatCurrency(50) }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

</section>

<!-- Contact Form Section -->
<section id="contact-form" class="contact section">

  <div class="container" data-aos="fade-up" data-aos-delay="300">
    <div class="section-title">
      <h2>Send Us a Message</h2>
      <p>Have questions about our seafood? We'd love to hear from you!</p>
    </div>

    <div class="row">
      <div class="col-lg-6">
        <form action="{{ route('contact.submit') }}" method="POST" class="php-email-form">
          @csrf
          <div class="row gy-4">
            <div class="col-md-6">
              <label for="name" class="form-label">Your Name *</label>
              <input type="text" class="form-control" name="name" id="name" required>
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label">Your Email *</label>
              <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="col-md-12">
              <label for="subject" class="form-label">Subject *</label>
              <input type="text" class="form-control" name="subject" id="subject" required>
            </div>
            <div class="col-md-12">
              <label for="message" class="form-label">Message *</label>
              <textarea class="form-control" name="message" id="message" rows="6" required></textarea>
            </div>
            <div class="col-md-12 text-center">
              <div class="loading">Loading</div>
              <div class="error-message"></div>
              <div class="sent-message">Your message has been sent. Thank you!</div>
              <button type="submit" class="btn btn-primary">Send Message</button>
            </div>
          </div>
        </form>
      </div>

      <div class="col-lg-6">
        <div class="card">
          <div class="card-body text-center">
            <i class="bi bi-chat-dots fa-3x text-primary mb-3"></i>
            <h4 style="background-color: #000000ff; color: white; padding: 10px; border-radius: 5px;">Need Quick Help?</h4>
            <p>Our customer service team is ready to assist you with any questions about our products or orders.</p>
            <div class="d-grid gap-2 mt-3">
              <a href="tel:{{ str_replace(' ', '', config('contact.phone')) }}" class="btn btn-outline-primary">
                <i class="bi bi-telephone"></i> Call Now
              </a>
              <a href="mailto:{{ config('contact.email') }}" class="btn btn-outline-secondary">
                <i class="bi bi-envelope"></i> Email Us
              </a>
            </div>
            <div class="mt-3">
              <h6 style="background-color: #000000ff; color: white; padding: 10px; border-radius: 5px;">Business Hours</h6>
              <p class="small text-muted">
                Monday - Friday: 9:00 AM - 6:00 PM<br>
                Saturday: 10:00 AM - 4:00 PM<br>
                Sunday: Closed
              </p>
            </div>
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

.info-item {
  background: white;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
  height: 100%;
  display: flex;
  align-items: center;
  margin-bottom: 20px;
}

.info-item i {
  font-size: 24px;
  color: var(--color-primary);
  margin-right: 20px;
  flex-shrink: 0;
}

.info-item h4 {
  font-size: 18px;
  font-weight: 600;
  margin-bottom: 10px;
}

.info-item p {
  margin: 0;
  color: #6c757d;
}

.php-email-form .form-control:focus {
  border-color: var(--color-primary);
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}
</style>
@endsection
