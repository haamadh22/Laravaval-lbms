@extends('layouts.app')

@section('content')

<div class="container mt-4">

<div class="card p-4">
    <h4>My Profile</h4>

    <p><strong>Username:</strong> {{ $user->username }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
</div>

</div>

@endsection
