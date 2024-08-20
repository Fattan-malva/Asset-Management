@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">Asset History</h1>
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">Asset History</h3>
        </div>
        <div class="card-body">
            @foreach ($history as $assetTagging => $changes)
                <div class="mb-3">
                    <button class="btn asset-tagging-button w-100 text-start" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse-{{ Str::slug($assetTagging) }}" aria-expanded="false"
                        aria-controls="collapse-{{ Str::slug($assetTagging) }}">
                        Asset Tagging: {{ $assetTagging }}
                        <i class="bi bi-chevron-down float-end"></i>
                    </button>
                    <div class="collapse" id="collapse-{{ Str::slug($assetTagging) }}">
                        <div class="timeline mt-3">
                            @foreach ($changes as $change)
                                <div class="timeline-item {{ $change->action }}">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <h5>{{ \Carbon\Carbon::parse($change->changed_at)->format('d M Y, H:i') }}</h5>
                                        <p>
                                            @if ($change->action === 'CREATE')
                                                Initial Holder: <strong>{{ $change->nama_old }}</strong>
                                            @elseif ($change->action === 'UPDATE')
                                                <strong>{{ $change->nama_old }}</strong> to <strong>{{ $change->nama_new }}</strong>
                                            @elseif ($change->action === 'DELETE')
                                                Holder: <strong>{{ $change->nama_old }}</strong>
                                            @endif
                                        </p>
                                        <p>Merk: {{ $change->merk }}</p>
                                        <span
                                            class="badge {{ $change->action === 'CREATE' ? 'bg-success' : ($change->action === 'UPDATE' ? 'bg-warning' : 'bg-danger') }}">
                                            {{ $change->action === 'CREATE' ? 'Handover' : ($change->action === 'UPDATE' ? 'Mutation' : 'Return') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

<style>
    .timeline {
        position: relative;
        padding: 20px 0;
    }

    .timeline-item {
        display: flex;
        align-items: flex-start;
        position: relative;
        padding: 10px 0;
        margin-bottom: 20px;
        border-left: 2px solid #ddd;
    }

    .timeline-dot {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background-color: #ddd;
        border: 2px solid #fff;
        margin-right: 15px;
    }

    .timeline-item.CREATE .timeline-dot {
        background-color: #28a745;
    }

    .timeline-item.UPDATE .timeline-dot {
        background-color: #ffc107;
    }

    .timeline-item.DELETE .timeline-dot {
        background-color: #dc3545;
    }

    .timeline-content {
        flex: 1;
    }

    .timeline-content h5 {
        margin: 0;
        font-size: 1.1em;
    }

    .timeline-content p {
        margin: 0.5em 0;
    }

    .badge.bg-success {
        background-color: #28a745;
        color: #fff;
    }

    .badge.bg-warning {
        background-color: #ffc107;
        color: #212529;
    }

    .badge.bg-danger {
        background-color: #dc3545;
        color: #fff;
    }

    .badge {
        padding: 0.5em 1em;
        border-radius: 0.25em;
    }

    .btn.asset-tagging-button {
        color: #000;
        font-size: 1.25em;
        font-weight: bold;
        text-align: left;
        background: none;
        border: none;
        padding: 10px;
        box-shadow: none;
    }

    .btn.asset-tagging-button:hover,
    .btn.asset-tagging-button:focus {
        color: #000;
        text-decoration: none;
        background: none;
    }

    .btn.asset-tagging-button .bi-chevron-down {
        font-size: 1.2em;
    }
</style>
