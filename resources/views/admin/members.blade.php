@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bx bx-group me-1"></i> All Members</h5>
            <a href="{{ route('members.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-user-plus me-1"></i> Register Member
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Membership No</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $i => $member)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $member->username }}</td>
                                <td>{{ $member->email }}</td>
                                <td><span class="badge bg-label-primary">{{ $member->membership_no }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($member->created_at)->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('members.edit', $member->id)}}" class="btn btn-sm btn-outline-primary me-1">
                                        Edit
                                    </a>
                                    <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this member?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No members found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection