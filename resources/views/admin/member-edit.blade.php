@extends('layouts.app')

@section('content')
<div class="container-xxl py-4">

    <div class="card">
        <div class="card-header">
            <h5>Edit Member</h5>
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('members.update', $member->id) }}">
                @csrf
                @method('PUT')

                {{-- Username --}}
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control"
                           value="{{ $member->username }}">
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ $member->email }}">
                </div>

                {{-- Membership No --}}
                <div class="mb-3">
                    <label class="form-label">Membership No</label>
                    <input type="text" name="membership_no" class="form-control"
                           value="{{ $member->membership_no }}">
                </div>

                <button class="btn btn-primary">Update</button>
                <a href="{{ route('members.index') }}" class="btn btn-secondary">Back</a>

            </form>

        </div>
    </div>

</div>
@endsection