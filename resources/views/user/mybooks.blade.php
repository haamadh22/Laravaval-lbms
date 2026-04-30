@extends('layouts.app')

@section('content')

<div class="container mt-4">

<div class="card">
    <div class="card-header">
        <h5>📚 My Borrowed Books</h5>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Book</th>
                    <th>ISBN</th>
                    <th>Issued</th>
                    <th>Due</th>
                    <th>Returned</th>
                    <th>Status</th>
                    <th>Fine</th>
                </tr>
            </thead>

            <tbody>
            @foreach($rows as $r)
                <tr>
                    <td>{{ $r->title }}</td>
                    <td>{{ $r->isbn }}</td>
                    <td>{{ $r->issue_date }}</td>
                    <td>{{ $r->due_date }}</td>
                    <td>{{ $r->return_date ?? '-' }}</td>

                    <td>
                        <span class="badge bg-{{ $r->status == 'issued' ? 'warning' : 'success' }}">
                            {{ ucfirst($r->status) }}
                        </span>
                    </td>

                    <td class="text-danger fw-bold">
                        Rs {{ number_format($r->fine,2) }}
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>
</div>

</div>

@endsection