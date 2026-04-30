@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @error('name')
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @enderror

    {{-- ADD FORM --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Add Author</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('authors.store') }}" class="d-flex gap-2">
                @csrf
                <input name="name" class="form-control" placeholder="Author name" required>
                <button class="btn btn-primary px-4">Add</button>
            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">All Authors</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th style="width:50px">#</th>
                            <th>Name</th>
                            <th style="width:120px" class="text-center">Update</th>
                            <th style="width:100px" class="text-center">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($authors as $key => $a)
                        <tr>
                            <td class="align-middle">{{ $key + 1 }}</td>

                            {{-- Inline edit form spans Name + Update columns --}}
                            <form method="POST" action="{{ route('authors.update', $a->id) }}">
                                @csrf
                                @method('PUT')
                                <td class="align-middle">
                                    <input name="name" value="{{ $a->name }}"
                                           class="form-control form-control-sm">
                                </td>
                                <td class="align-middle text-center">
                                    <button class="btn btn-sm btn-outline-primary">Update</button>
                                </td>
                            </form>

                            <td class="align-middle text-center">
                                <form method="POST" action="{{ route('authors.destroy', $a->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Delete this author?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No authors found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection