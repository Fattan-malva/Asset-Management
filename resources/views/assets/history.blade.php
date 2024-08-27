@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4 fw-bold display-5">Asset History</h1>
    <br>
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Asset Tagging</th>
                            <th scope="col">Merk</th>
                            <th scope="col">Jenis Aset</th>
                            <th scope="col">Old Holder</th>
                            <th scope="col">New Holder</th>
                            <th scope="col">Changed At</th>
                            <th scope="col">Action</th>
                            <th scope="col">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($history as $assetTagging => $items)
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->asset_tagging }}</td>
                                    <td>{{ $item->merk }}</td>
                                    <td>{{ $item->jenis_aset_old }}</td>
                                    <td>{{ $item->nama_old }}</td>
                                    <td>{{ $item->nama_new }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->changed_at)->format('d-m-Y H:i:s') }}</td>
                                    <td>
                                        @if ($item->action === 'CREATE')
                                            <span class="badge badge-custom bg-success"
                                                style="font-size: 0.8rem; padding: 0.2em 1em; color: black; border-radius: 0.5em;">Handover</span>
                                        @elseif ($item->action === 'UPDATE')
                                            <span class="badge badge-custom bg-warning"
                                                style="font-size: 0.8rem; padding: 0.2em 1em; color: black; border-radius: 0.5em;">Mutasi</span>
                                        @elseif ($item->action === 'DELETE')
                                            <span class="badge badge-custom bg-danger"
                                                style="font-size: 0.8rem; padding: 0.2em 1em; color: black; border-radius: 0.5em;">Return</span>
                                        @else
                                            <span class="badge badge-custom bg-secondary"
                                                style="font-size: 0.8rem; padding: 0.2em 1em; color: black; border-radius: 0.5em;">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->action === 'CREATE')
                                            New asset added. Holder: <span
                                                class="badge badge-custom bg-primary" style="font-size: 0.8rem; padding: 0.2em 1em; color: white; border-radius: 0.5em;">{{ $item->nama_old }}</span>
                                        @elseif ($item->action === 'UPDATE')
                                            Mutation from <span class="badge badge-custom bg-secondary" style="font-size: 0.8rem; padding: 0.2em 1em; color: white; border-radius: 0.5em;">{{ $item->nama_old }}</span>
                                            to <span class="badge badge-custom bg-primary" style="font-size: 0.8rem; padding: 0.2em 1em; color: white; border-radius: 0.5em;">{{ $item->nama_new }}</span>
                                        @elseif ($item->action === 'DELETE')
                                            Asset returned by: <span
                                                class="badge badge-custom bg-secondary" style="font-size: 0.8rem; padding: 0.2em 1em; color: white; border-radius: 0.5em;">{{ $item->nama_old }}</span>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="8" class="text-center" style="padding: 50px; font-size: 1.2em;">No history
                                    found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection