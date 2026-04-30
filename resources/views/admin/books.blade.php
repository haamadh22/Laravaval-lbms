@extends('layouts.app')

@section('content')

<div class="text-center mb-5">
    <h2 class="fw-bold">Smart Library Management System</h2>
    <p class="text-muted">Browse our collection of books</p>
</div>

@php
    $editBook = $editBook ?? null;
@endphp

{{-- ADD / EDIT BOOK FORM --}}
<div class="card mb-4">
    <div class="card-body">

        <h5>{{ $editBook ? 'Edit Book' : 'Add New Book' }}</h5>

        <form method="POST"
              action="{{ $editBook ? route('books.update', $editBook->id) : route('books.store') }}"
              enctype="multipart/form-data">

            @csrf
            @if($editBook)
                @method('PUT')
            @endif

            <div class="row g-3">

                {{-- TITLE --}}
                <div class="col-md-3">
                    <input type="text" name="title"
                           class="form-control"
                           value="{{ $editBook->title ?? '' }}"
                           placeholder="Book Title" required>
                </div>

                {{-- AUTHOR --}}
                <div class="col-md-3">
                    <select name="author_id" class="form-select" required>
                        <option value="">Select Author</option>
                        @foreach($authors ?? [] as $a)
                            <option value="{{ $a->id }}"
                                {{ isset($editBook) && $editBook->author_id == $a->id ? 'selected' : '' }}>
                                {{ $a->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- CATEGORY --}}
                <div class="col-md-3">
                    <select name="category_id" class="form-select" required>
                        <option value="">Select Category</option>
                        @foreach($categories ?? [] as $c)
                            <option value="{{ $c->id }}"
                                {{ isset($editBook) && $editBook->category_id == $c->id ? 'selected' : '' }}>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

              {{-- QUANTITY --}}
                <div class="col-md-2">
                    <input type="number" name="quantity"
                           class="form-control"
                           value="{{ $editBook->quantity ?? '' }}"
                           placeholder="Qty" required>
                </div>

                {{-- ISBN --}}
                <div class="col-md-3">
                    <input type="text" name="isbn"
                           class="form-control"
                           value="{{ $editBook->isbn ?? '' }}"
                           placeholder="ISBN (optional)">
                </div>

                {{-- IMAGE --}}
                <div class="col-md-3">
                    @if($editBook && $editBook->image)
                        <img src="{{ asset('uploads/books/'.$editBook->image) }}"
                             width="60" class="mb-2">
                    @endif

                    <input type="file" name="image" class="form-control">
                </div>

                {{-- BUTTON --}}
                <div class="col-md-1">
                    <button class="btn btn-success w-100">
                        {{ $editBook ? 'Update' : '+' }}
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

{{-- BOOK LIST --}}
<div class="row">
@forelse($books ?? [] as $b)

    <div class="col-md-4 mb-4">
        <div class="card h-100">

            <div class="card-body text-center">

                

                {{-- IMAGE --}}
                @if($b->image)
                    <img src="{{ asset('uploads/books/'.$b->image) }}"
                         class="img-fluid mb-2"
                         style="height:120px; object-fit:cover;">
                @endif

                <h6>{{ $b->title }}</h6>

                <small class="text-muted">Author: {{ $b->author ?? 'Unknown' }}</small><br>

                <span class="badge bg-secondary">
                    {{ $b->category ?? 'General' }}
                </span><br>

                <small>ISBN: {{ $b->isbn }}</small><br>
                <small>Qty: {{ $b->quantity }}</small><br>

                <span class="badge mt-1 {{ $b->quantity > 0 ? 'bg-success' : 'bg-danger' }}">
                    {{ $b->quantity > 0 ? 'Available' : 'Out of Stock' }}
                </span>

                {{-- ACTIONS --}}
                <div class="mt-3 d-flex justify-content-center gap-2">
             <a href="{{ url('/admin/books') }}?edit={{ $b->id }}"
                class="btn btn-sm btn-outline-primary me-1">
                    Edit
                </a>

                    <form method="POST"
                          action="{{ route('books.destroy', $b->id) }}"
                          onsubmit="return confirm('Delete this book?')">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>

                </div>

            </div>
        </div>
    </div>

@empty
    <div class="col-12 text-center text-muted">
        No books found
    </div>
@endforelse
</div>

@endsection