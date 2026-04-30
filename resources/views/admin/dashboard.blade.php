@extends('layouts.app')

@section('content')

<div class="container-xxl py-4">

    {{-- Welcome Card --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card position-relative">
                <div class="card-body">
                    <h5 class="card-title mb-1">Welcome Admin 🎉</h5>
                    <p class="mb-2">Welcome to Imara Library Management System</p>
                    <a href="{{ route('books.index') }}" class="btn btn-sm btn-primary">
                        View Books
                    </a>
                </div>

                <img src="{{ asset('uploads/d.png') }}"
                     class="position-absolute bottom-0 end-0 me-4 mb-4"
                     width="100"
                     alt="Books">
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row gy-3">

        {{-- Total Books --}}
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Books</h6>
                    <h2 class="fw-bold">{{ $totalBooks }}</h2>
                </div>
            </div>
        </div>

       {{-- Total Members --}}
<div class="col-md-3">
    <div class="card text-center shadow-sm">
        <div class="card-body">
            <h6 class="text-muted">Total Members</h6>
            <h2 class="fw-bold text-danger">{{ $totalMembers }}</h2>
        </div>
    </div>
</div>

        {{-- Issued --}}
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Issued</h6>
                    <h2 class="fw-bold text-warning">{{ $issued }}</h2>
                </div>
            </div>
        </div>

        {{-- Returned --}}
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Returned</h6>
                    <h2 class="fw-bold text-success">{{ $returned }}</h2>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection