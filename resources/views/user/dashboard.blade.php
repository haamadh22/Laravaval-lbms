@extends('layouts.app')

@section('content')

<div class="container mt-4">

<div class="row mb-4 text-center">

    <div class="col-md-4">
        <div class="card p-3 shadow">
            <h6>Total Borrowed</h6>
            <h3>{{ $totalBorrowed ?? 0 }}</h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3 shadow">
            <h6>Issued</h6>
            <h3>{{ $totalIssued ?? 0 }}</h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3 shadow">
            <h6>Returned</h6>
            <h3>{{ $totalReturned ?? 0 }}</h3>
        </div>
    </div>

</div>

<form method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control" placeholder="Search books...">
        <button class="btn btn-primary">Search</button>
    </div>
</form>

@if(!empty($search))
<table class="table table-bordered table-striped">
@foreach($books as $b)
<tr>
<td>{{ $b->title }}</td>
<td>{{ $b->author }}</td>
<td>
    <span class="badge bg-{{ $b->quantity > 0 ? 'success' : 'danger' }}">
        {{ $b->quantity > 0 ? 'Available' : 'Out of Stock' }}
    </span>
</td>
</tr>
@endforeach
</table>
@endif

<h5 class="mt-4">Recent Books</h5>

<table class="table table-bordered">
<thead>
<tr>
<th>Title</th>
<th>Date</th>
<th>Status</th>
</tr>
</thead>

<tbody>
@foreach($recent as $r)
<tr>
<td>{{ $r->title }}</td>
<td>{{ $r->issue_date }}</td>
<td>
    <span class="badge bg-info">
        {{ $r->status }}
    </span>
</td>
</tr>
@endforeach
</tbody>

</table>

</div>

@endsection