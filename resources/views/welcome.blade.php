<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Imara | Library Management System</title>

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

<!-- Styles / Scripts -->
@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@endif

<link rel="icon" href="{{ asset('assets/img/favicon/favicon.ico') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/iconify-icons.css') }}">

<script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
<script src="{{ asset('assets/js/config.js') }}"></script>

<style>
  /* ===== ZOOM — Feature Cards ===== */
  .feature-zoom {
    transition: transform 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275),
                box-shadow 0.35s ease;
    cursor: default;
    position: relative;
    overflow: hidden;
  }

  .feature-zoom:hover {
    transform: translateY(-10px) scale(1.04);
    box-shadow: 0 20px 50px rgba(105, 108, 255, 0.2) !important;
  }

  .feature-zoom .feature-icon {
    display: inline-block;
    font-size: 2.5rem;
    margin-bottom: 12px;
    transition: transform 0.35s ease;
  }

  .feature-zoom:hover .feature-icon {
    transform: scale(1.2) rotate(5deg);
  }

  /* Bottom border animation */
  .feature-zoom::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0;
    width: 100%; height: 3px;
    background: linear-gradient(90deg, #696cff, #9155fd);
    transform: scaleX(0);
    transition: transform 0.4s ease;
  }

  .feature-zoom:hover::after {
    transform: scaleX(1);
  }

  /* ===== ZOOM — Book Cards ===== */
  .book-zoom {
    transition: transform 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275),
                box-shadow 0.35s ease,
                border-color 0.35s ease;
    border: 2px solid transparent;
  }

  .book-zoom:hover {
    transform: translateY(-12px) scale(1.03);
    box-shadow: 0 20px 50px rgba(105, 108, 255, 0.25) !important;
    border-color: rgba(105, 108, 255, 0.4);
  }

  /* Image zoom inside book card */
  .book-img-wrap {
    overflow: hidden;
    position: relative;
  }

  .book-img-wrap img {
    transition: transform 0.5s ease;
    width: 100%;
    height: 220px;
    object-fit: cover;
  }

  .book-zoom:hover .book-img-wrap img {
    transform: scale(1.1);
  }

  /* Dark overlay on image hover */
  .book-img-wrap::after {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: linear-gradient(to bottom, transparent 50%, rgba(0,0,0,0.4) 100%);
    opacity: 0;
    transition: opacity 0.4s ease;
  }

  .book-zoom:hover .book-img-wrap::after {
    opacity: 1;
  }

  /* ===== HERO ===== */
  .hero-section {
    background: linear-gradient(135deg, #696cff 0%, #9155fd 60%, #6f42c1 100%);
    padding: 80px 24px;
    text-align: center;
    position: relative;
    overflow: hidden;
  }

  .hero-section::before {
    content: '';
    position: absolute;
    top: -50%; left: -50%;
    width: 200%; height: 200%;
    background:
      radial-gradient(circle at 30% 50%, rgba(255,255,255,0.06) 0%, transparent 50%),
      radial-gradient(circle at 70% 50%, rgba(255,255,255,0.04) 0%, transparent 50%);
    animation: heroGlow 8s ease-in-out infinite alternate;
  }

  @keyframes heroGlow {
    0%  { transform: translate(0, 0) rotate(0deg); }
    100%{ transform: translate(20px, -20px) rotate(3deg); }
  }

  .hero-content {
    position: relative;
    z-index: 1;
    max-width: 700px;
    margin: 0 auto;
  }

  .hero-content h1 {
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 700;
    color: #fff;
    margin-bottom: 16px;
    animation: fadeUp 0.8s ease both;
  }

  .hero-content p {
    color: rgba(255,255,255,0.85);
    font-size: 1.1rem;
    line-height: 1.7;
    margin-bottom: 32px;
    animation: fadeUp 0.8s ease 0.15s both;
  }

  .hero-btns {
    display: flex;
    gap: 14px;
    justify-content: center;
    flex-wrap: wrap;
    animation: fadeUp 0.8s ease 0.3s both;
  }

  .btn-hero {
    padding: 12px 32px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    transition: all 0.3s ease;
  }

  .btn-hero-white {
    background: #fff;
    color: #696cff;
  }

  .btn-hero-white:hover {
    background: #f0f0ff;
    color: #696cff;
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 8px 25px rgba(255,255,255,0.3);
    text-decoration: none;
  }

  .btn-hero-outline {
    background: transparent;
    color: #fff;
    border: 2px solid rgba(255,255,255,0.5);
  }

  .btn-hero-outline:hover {
    background: rgba(255,255,255,0.15);
    border-color: #fff;
    color: #fff;
    transform: translateY(-3px);
    text-decoration: none;
  }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(25px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  /* ===== SECTION TITLE ===== */
  .section-heading {
    font-size: 1.8rem;
    font-weight: 700;
    text-align: center;
    margin-bottom: 32px;
    color: #566a7f;
  }

  /* ===== FADE IN ANIMATION ===== */
  .fade-in-card {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeUp 0.6s ease forwards;
  }

  .fade-in-card:nth-child(1) { animation-delay: 0.1s; }
  .fade-in-card:nth-child(2) { animation-delay: 0.2s; }
  .fade-in-card:nth-child(3) { animation-delay: 0.3s; }
  .fade-in-card:nth-child(4) { animation-delay: 0.4s; }
</style>
</head>

<body>

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-expand-lg bg-navbar-theme shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold fs-4" href="{{ url('/') }}">
      📚 Imara Library
    </a>

    <form class="d-flex ms-auto me-3" method="GET" action="{{ url('/') }}">
      <input class="form-control me-2"
             type="search"
             name="search"
             value="{{ request('search') }}"
             placeholder="Search book or author">
      <button class="btn btn-primary">Search</button>
    </form>

    @auth
      <a href="{{ url('/dashboard') }}" class="btn btn-dark">Dashboard</a>
    @else
      <a href="{{ route('login') }}" class="btn btn-dark">Login</a>
    @endauth
  </div>
</nav>

<!-- ================= HERO ================= -->
<section class="hero-section">
  <div class="hero-content">
    <h1>Smart Library Management System</h1>
    <p>
      Manage books • Authors • Categories • Borrowing • Returns
      <br>Secure system for Admins & Users
    </p>
    <div class="hero-btns">
      <a href="{{ route('login') }}" class="btn-hero btn-hero-white">
        User Login
      </a>
      @if (Route::has('register'))
        <a href="{{ route('register') }}" class="btn-hero btn-hero-outline">
          Register Now
        </a>
      @endif
    </div>
  </div>
</section>

<!-- ================= FEATURES ================= -->
<div class="content-wrapper">
<div class="container-xxl container-p-y">

  <h3 class="section-heading">Why Imara?</h3>

  <div class="row text-center g-4 mb-5">

    <div class="col-md-3 fade-in-card">
      <div class="card p-4 h-100 feature-zoom">
        <span class="feature-icon">📘</span>
        <h5>Book Management</h5>
        <p class="text-muted mt-2">Add, update and track all library books</p>
      </div>
    </div>

    <div class="col-md-3 fade-in-card">
      <div class="card p-4 h-100 feature-zoom">
        <span class="feature-icon">👥</span>
        <h5>User Roles</h5>
        <p class="text-muted mt-2">Separate Admin & Member access control</p>
      </div>
    </div>

    <div class="col-md-3 fade-in-card">
      <div class="card p-4 h-100 feature-zoom">
        <span class="feature-icon">🔄</span>
        <h5>Borrow & Return</h5>
        <p class="text-muted mt-2">Track issued books & return dates</p>
      </div>
    </div>

    <div class="col-md-3 fade-in-card">
      <div class="card p-4 h-100 feature-zoom">
        <span class="feature-icon">💰</span>
        <h5>Fine System</h5>
        <p class="text-muted mt-2">Automatic late return fine calculation</p>
      </div>
    </div>

  </div>

<!-- ================= FILTER ================= -->
  <div class="card mb-4">
    <div class="card-body">
      <form method="GET" action="{{ url('/') }}" class="row g-3">
        <div class="col-md-6">
          <input type="text"
                 name="search"
                 value="{{ request('search') }}"
                 class="form-control"
                 placeholder="Search by title or author">
        </div>
        <div class="col-md-4">
          <select name="category" class="form-select">
            <option value="">All Categories</option>
            @foreach ($categories as $c)
              <option value="{{ $c->id }}" {{ request('category') == $c->id ? 'selected' : '' }}>
                {{ $c->name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2 d-grid">
          <button class="btn btn-primary">Filter</button>
        </div>
      </form>
    </div>
  </div>

<!-- ================= BOOKS ================= -->
  <h3 class="section-heading">Available Books</h3>

  <div class="row g-4">
    @forelse ($books as $b)
      <div class="col-6 col-sm-4 col-md-3 col-lg-2">
        <a href="{{ url('/books/' . $b->id) }}" class="text-decoration-none text-dark">
          <div class="card h-100 book-zoom">

            <div class="book-img-wrap">
              <img src="{{ $b->image
                ? asset('uploads/books/'.$b->image)
                : asset('assets/img/default-book.png') }}"
                   alt="{{ $b->title }}">
            </div>

            <div class="card-body p-2">
              <h6 class="fw-bold text-truncate">{{ $b->title }}</h6>
              <small class="text-dark fw-bold">✍ {{ $b->author ?? '-' }}</small><br>
              <span class="badge bg-secondary me-2">🏷 {{ $b->category ?? '-' }}</span>
              <small class="text-muted fw-bolder">ISBN: {{ $b->isbn ?? '-' }}</small>
              <small class="text-muted d-block">Quantity: {{ $b->quantity ?? '-' }}X</small>
              <span class="badge {{ $b->quantity > 0 ? 'bg-success' : 'bg-danger' }}">
                {{ $b->quantity > 0 ? 'Available' : 'Out of Stock' }}
              </span>
            </div>

          </div>
        </a>
      </div>
    @empty
      <div class="col-12 text-center text-muted py-5">
        <h5>No books found.</h5>
      </div>
    @endforelse
  </div>

</div>

<!-- ================= FOOTER ================= -->
<footer class="content-footer footer bg-footer-theme mt-5">
  <div class="container-xxl text-center py-3">
    © {{ date('Y') }} Imara Library Management System
    <br><small>Designed for Admin & Library Members</small>
  </div>
</footer>

</div><!-- end content-wrapper -->

<script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

</body>
</html>