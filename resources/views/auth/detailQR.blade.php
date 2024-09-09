<!-- resources/views/auth/detailQR.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Asset Detail</h3>
        </div>
        <div class="card-body">
            <p><strong>Assets Tag:</strong> {{ $inventory->tagging }}</p>
            <p><strong>Assets Name:</strong> {{ $inventory->asets }}</p>
            <p><strong>Merk:</strong> {{ $inventory->merk_name }}</p>
            <p><strong>Serial Number:</strong> {{ $inventory->seri }}</p>
            <p><strong>Type:</strong> {{ $inventory->type }}</p>
        </div>
    </div>
</div>
@endsection
