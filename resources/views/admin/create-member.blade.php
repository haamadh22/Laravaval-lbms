@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('members.index') }}" class="btn btn-outline-secondary btn-sm me-3">
            <i class="bx bx-arrow-back me-1"></i> Back to Members
        </a>
        <h5 class="mb-0">Register Member</h5>
    </div>

    {{-- Section A: Add existing user as member --}}
    <div class="card border mb-4">
        <div class="card-header bg-light">
            <h6 class="mb-0">Add Existing User as Member</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('members.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">Select User</label>
                        <select name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                            <option value="">-- Choose a user --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->username }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Membership No</label>
                        <input type="text" name="membership_no" class="form-control"
                            value="{{ $newMembershipNo }}" readonly />
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Add as Member</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Section B: Register new user & add as member --}}
    <div class="card border">
        <div class="card-header bg-light">
            <h6 class="mb-0">Register New User & Add as Member</h6>
        </div>
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('members.register') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Username</label>
                        <input type="text" name="username"
                            class="form-control @error('username') is-invalid @enderror"
                            value="{{ old('username') }}" placeholder="johndoe" />
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" placeholder="john@example.com" />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Password</label>
                        <div class="input-group input-group-merge form-password-toggle">
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="············" />
                            <span class="input-group-text cursor-pointer">
                                <i class="bx bx-hide"></i>
                            </span>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-success">
                            Register & Add Member
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection