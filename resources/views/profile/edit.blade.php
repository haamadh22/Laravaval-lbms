@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
    <div class="py-12">
        <div class="container-xxl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <h4 class="mb-4">My Profile</h4>
            </div>

            <div class="card p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <p><strong>Username:</strong> {{ $user->username }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
            </div>
        </div>
    </div>
@endsection
