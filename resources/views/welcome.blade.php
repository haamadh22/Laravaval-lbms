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

<!-- ================= CONTENT ================= -->
<div class="content-wrapper">

<!-- ================= HERO ================= -->
<div class="container-xxl container-p-y text-center">
  <h1 class="fw-bold display-5">
    Smart Library Management System
  </h1>
  <p class="text-muted mt-3 fs-5">
    Manage books • Authors • Categories • Borrowing • Returns
    <br>Secure system for Admins & Users
  </p>

  <div class="mt-4">
    <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2">
      User Login
    </a>
    @if (Route::has('register'))
      <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
        Register
      </a>
    @endif
  </div>
</div>

<!-- ================= FEATURES ================= -->
<div class="container-xxl mb-5">
  <div class="row text-center g-4">

    <div class="col-md-3">
      <div class="card p-4 h-100">
        <h5>📘 Book Management</h5>
        <p class="text-muted mt-2">Add, update and track all library books</p>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card p-4 h-100">
        <h5>👥 User Roles</h5>
        <p class="text-muted mt-2">Separate Admin & Member access control</p>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card p-4 h-100">
        <h5>🔄 Borrow & Return</h5>
        <p class="text-muted mt-2">Track issued books & return dates</p>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card p-4 h-100">
        <h5>💰 Fine System</h5>
        <p class="text-muted mt-2">Automatic late return fine calculation</p>
      </div>
    </div>

  </div>
</div>

<!-- ================= FILTER ================= -->
<div class="container-xxl mb-4">
  <div class="card">
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
</div>

<!-- ================= BOOKS ================= -->
<div class="container-xxl">
  <h3 class="fw-bold mb-4 text-center">Available Books</h3>

  <div class="row g-4">

    @forelse ($books as $b)
      <div class="col-6 col-sm-4 col-md-3 col-lg-2">
        <a href="{{ url('/books/' . $b->id) }}" class="text-decoration-none text-dark">
          <div class="card h-100">

            <img src="{{ $b->image
            ? asset('uploads/books/'.$b->image)
            : asset('assets/img/default-book.png') }}"
                 class="card-img-top"
                 style="height:220px;object-fit:cover"
                 alt="{{ $b->title }}">

            <div class="card-body p-2">
              <h6 class="fw-bold text-truncate">{{ $b->title }}</h6>
             <small class="text-dark fw-bold">✍ {{ $b->author ?? '-' }}</small>
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