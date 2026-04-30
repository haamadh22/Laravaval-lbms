@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Return Book</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Member</th>
                            <th>Book</th>
                            <th>Issue Date</th>
                            <th>Due Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($issues as $k => $i)
                            <tr>
                                <td>{{ $k + 1 }}</td>
                                <td>{{ $i->username }}</td>
                                <td>{{ $i->title }}</td>
                                <td>{{ $i->issue_date }}</td>
                                <td>
                                    <span class="badge bg-{{ now()->gt($i->due_date) ? 'danger' : 'success' }}">
                                        {{ $i->due_date }}
                                    </span>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('return.store') }}">
                                        @csrf
                                        <input type="hidden" name="return_id" value="{{ $i->issue_id }}">
                                                            <button class="btn btn-sm btn-outline-success"
                                    onclick="return confirm('Return this book?')">
                                Return
                            </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No issued books found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection