@extends('layouts.app')

@section('content')
<br>
<br>
<h1 class="mt-4 text-center">Asset Total</h1>
<br>
<br>
<br>
<div class="container">
    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive">
                <table id="inventoryTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Asets Name</th>
                            <th scope="col">Merk</th>
                            <th scope="col">Total Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inventorySummary as $index => $summary)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $summary->asets }}</td>
                                <td>{{ $summary->merk }}</td>
                                <td>{{ $summary->total_quantity }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center" style="padding: 50px; padding-bottom: 100px; padding-top: 100px; font-size: 1.2em;">No Assets found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<br>
<br>
@endsection
