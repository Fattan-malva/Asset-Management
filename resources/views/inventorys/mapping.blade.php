@extends('layouts.app')

@section('content')
<h1 class="mt-4 text-center fw-bold display-5">Assets Location</h1>
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
                <table id="mappingTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Location</th>
                            <th scope="col">Aset Type</th>
                            <th scope="col">Aset Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $index => $item)
                            <tr>
                                <td>{{ $item->lokasi }}</td>
                                <td>{{ $item->jenis_aset }}</td>
                                <td>{{ $item->jumlah_aset }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center" style="padding: 50px; padding-bottom: 100px; padding-top: 100px; font-size: 1.2em;">No Data found.</td>
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
