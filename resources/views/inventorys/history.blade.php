@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4 fw-bold display-5">Entry & Scrap History</h1>
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
                            <th scope="col">No.</th>
                            <th scope="col">Tagging</th>
                            <th scope="col">Merk</th>
                            <th scope="col">Seri</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inventory_histories as $index => $history)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $history->tagging }}</td>
                                <td>{{ $history->merk_name }}</td>
                                <td>{{ $history->seri }}</td>
                                <td>{{ \Carbon\Carbon::parse($history->action_time)->format('d-m-Y') }}</td>
                                <td>
                                    @if ($history->action === 'INSERT')
                                        <span class="badge bg-success"
                                            style="font-size: 0.8rem; padding: 0.2em 1em; color: black; border-radius: 0.5em;"">Entry</span>
                                    @elseif ($history->action === 'DELETE')
                                                        <span class=" badge bg-danger"
                                        style="font-size: 0.8rem; padding: 0.2em 1em; color: black; border-radius: 0.5em;">Scrap</span>
                                    @else
                                        <span class="badge bg-secondary"
                                            style="font-size: 0.8rem; padding: 0.2em 1em; color: black; border-radius: 0.5em;">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center" style="padding: 50px; font-size: 1.2em;">No history
                                    found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    <ul class="list-unstyled legend-list">
                        <li>
                            <span class="badge bg-success legend-badge" style="color:black;">Entry</span> : <span
                                class="legend-description">Assets added.</span>
                        </li>
                        <li>
                            <span class="badge bg-danger legend-badge" style="color:black;">Scrap</span> : <span
                                class="legend-description">assets have been removed or destroyed</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    /* CSS untuk menghapus garis tabel pada modal */
    .no-border-table th,
    .no-border-table td {
        border: none !important;
        padding: 0.5rem;
    }

    .modal-title {
        font-weight: bold;
        text-align: center;
        width: 100%;
    }

    .legend-list {
        font-size: 0.875em;
        line-height: 1.5;
    }

    .legend-list li {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
    }

    .legend-list li .badge {
        min-width: 80px;
        margin-right: 10px;
    }

    .legend-list li .legend-description {
        margin-left: 10px;
        text-align: left;
    }
</style>

@endsection