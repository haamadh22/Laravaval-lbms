@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Issue Book</h5>
        </div>
        <div class="card-body">

            <form method="POST" action="{{ route('issue.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Book</label>
                    <select name="book_id" class="form-select @error('book_id') is-invalid @enderror" required>
                        <option value="">-- Select Book --</option>
                        @foreach($books as $b)
                            <option value="{{ $b->id }}">
                                {{ $b->title }} ({{ $b->quantity }} available)
                            </option>
                        @endforeach
                    </select>
                    @error('book_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Member</label>
                    <select name="member_id" class="form-select @error('member_id') is-invalid @enderror" required>
                        <option value="">-- Select Member --</option>
                        @foreach($members as $m)
                            <option value="{{ $m->id }}">
                                {{ $m->username }} ({{ $m->membership_no }})
                            </option>
                        @endforeach
                    </select>
                    @error('member_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary">Issue Book</button>
            </form>

        </div>
    </div>

</div>
@endsection