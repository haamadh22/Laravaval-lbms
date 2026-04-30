@extends('layouts.app')

@section('content')

<div class="container-xxl">

    <div class="card">
        <div class="card-header">
            <h5>Issued Books</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Book</th>
                        <th>Member</th>
                        <th>Issued</th>
                        <th>Due</th>
                        <th>Status</th>
                        <th>Fine</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($issuedBooks as $issue)
                        <tr>
                            <td>{{ $issue->book->title ?? '-' }}</td>
                            <td>{{ $issue->member->user->username ?? '-' }}</td>
                            <td>{{ $issue->issue_date ?? '-' }}</td>
                            <td>{{ $issue->due_date ?? '-' }}</td>

                            <td>
                                <span class="badge bg-{{ $issue->status == 'issued' ? 'warning' : 'success' }}">
                                    {{ ucfirst($issue->status) }}
                                </span>
                            </td>

                            <td class="text-danger">
                                Rs {{ $issue->fine ?? '0.00' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                No issued books found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>

@endsection