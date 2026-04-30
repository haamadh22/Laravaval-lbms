@extends('layouts.app')

@section('content')

<div class="container-xxl">

    <div class="card">
        <div class="card-header">
            <h5>Borrow History</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Book</th>
                        <th>Issued</th>
                        <th>Returned</th>
                        <th>Status</th>
                        <th>Fine</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($history as $h)
                    <tr>
                        <td>{{ $h->username }}</td>
                        <td>{{ $h->title }}</td>
                        <td>{{ $h->issue_date }}</td>
                        <td>{{ $h->return_date ?? '-' }}</td>

                        <td>
                            <span class="badge bg-{{ $h->status == 'issued' ? 'warning' : 'success' }}">
                                {{ ucfirst($h->status) }}
                            </span>
                        </td>

                        <td class="text-danger">
                            Rs {{ number_format($h->fine ?? 0, 2) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            No history found
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection