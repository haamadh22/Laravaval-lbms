<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>{{ $book->title }} | Imara Library</title>

<link rel="icon" href="{{ asset('assets/img/favicon/favicon.ico') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/iconify-icons.css') }}">

<style>
html, body { overflow-x: hidden; }
.book-cover {
  height: 360px;
  object-fit: cover;
  border-radius: 8px;
}
</style>
</head>

<body>

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-expand-lg bg-navbar-theme shadow-sm">
  <div class="container-lg">
    <a class="navbar-brand fw-bold fs-4" href="{{ url('/') }}">📚 Imara Library</a>
    <div class="ms-auto">
      @auth
        <a href="{{ url('/dashboard') }}" class="btn btn-dark me-2">Dashboard</a>
      @else
        <a href="{{ route('login') }}" class="btn btn-dark me-2">Login</a>
        @if (Route::has('register'))
          <a href="{{ route('register') }}" class="btn btn-outline-primary">Register</a>
        @endif
      @endauth
    </div>
  </div>
</nav>

<!-- ================= CONTENT ================= -->
<div class="container-lg my-5">
  <div class="row g-5">

    <!-- BOOK IMAGE -->
    <div class="col-md-4 text-center">
      <img src="{{ $book->image ? asset('uploads/books/' . $book->image) : asset('assets/img/default-book.png') }}"
           class="img-fluid book-cover"
           alt="{{ $book->title }}">
    </div>

    <!-- BOOK DETAILS -->
    <div class="col-md-8">
      <h2 class="fw-bold">{{ $book->title }}</h2>

      <p class="text-muted fs-5">
        ✍ {{ $book->author->name ?? '-' }}
      </p>

      <p>
        <span class="badge bg-dark me-2">{{ $book->category->name ?? '-' }}</span>
        @if ($book->quantity > 0)
          <span class="badge bg-success">Available</span>
        @else
          <span class="badge bg-danger">Out of Stock</span>
        @endif
      </p>

      <hr>

      <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
      <p><strong>Available Quantity:</strong> {{ $book->quantity }}</p>

      <hr>

      <!-- CTA -->
      @if ($book->quantity > 0)
        @auth
          <div class="alert alert-success">
            ✅ You are logged in. Visit your dashboard to borrow books.
          </div>
          <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-lg">
            Go to Dashboard
          </a>
        @else
          <div class="alert alert-info">
            🔐 Please login to borrow this book
          </div>
          <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2">
            Login to Borrow
          </a>
          @if (Route::has('register'))
            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
              Register
            </a>
          @endif
        @endauth
      @else
        <div class="alert alert-danger">
          ❌ This book is currently not available
        </div>
      @endif

    </div>
  </div>
</div>

<!-- ================= FOOTER ================= -->
<footer class="bg-footer-theme py-3 mt-5">
  <div class="container-lg text-center">
    © {{ date('Y') }} Imara Library Management System
    <br><small>Public Book Catalog</small>
  </div>
</footer>

<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
</body>
</html>