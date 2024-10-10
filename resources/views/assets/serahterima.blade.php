@extends('layouts.app')
@section('title', 'Approve Assets')

@section('content')
<br>
<br>
<h1 class="mt-4 text-center fw-bold display-5">Approve Assets</h1>
<br>
<div class="container form-container">
    <div class="card">
        <div class="card-body">
            <!-- Approve all form -->
            <form action="{{ route('assets.updateserahterima') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    @foreach($assets as $asset)
                        @if($asset->aksi !== 'Return')
                            <div class="col-md-3 mb-4"> <!-- Keep the column for 4 items -->
                                <div class="asset-wrapper"> <!-- New wrapper for each asset -->
                                    <div class="form-group">
                                        <label for="asset_tagging_{{ $asset->id }}">Asset Tagging</label>
                                        @php
                                            $taggingValue = $inventories->where('id', $asset->asset_tagging)->first();
                                        @endphp
                                        <input type="text" class="form-control" id="asset_tagging_{{ $asset->id }}"
                                            name="asset_tagging_display[]"
                                            value="{{ is_string($taggingValue->tagging ?? null) ? htmlspecialchars($taggingValue->tagging) : 'N/A' }}"
                                            readonly>
                                        <input type="hidden" name="asset_tagging[]" value="{{ $asset->asset_tagging }}">
                                    </div>
                                    <input type="hidden" name="assets[]" value="{{ $asset->id }}">
                                    <input type="hidden" name="approval_status[]" value="Approved">

                                    <div class="form-group">
                                        <label for="nama_{{ $asset->id }}">Name</label>
                                        @php
                                            $customerName = $customers->where('id', $asset->nama)->first();
                                        @endphp
                                        <input type="text" class="form-control" id="nama_{{ $asset->id }}" name="nama_display[]"
                                            value="{{ is_string($customerName->name ?? null) ? htmlspecialchars($customerName->name) : 'N/A' }}"
                                            readonly>
                                        <input type="hidden" name="nama[]" value="{{ $asset->nama }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="lokasi_{{ $asset->id }}">Location</label>
                                        @php
                                            $lokasiValue = old('lokasi')[$asset->id] ?? $asset->lokasi;
                                        @endphp
                                        <input type="text" class="form-control" id="lokasi_{{ $asset->id }}" name="lokasi[]"
                                            value="{{ is_string($lokasiValue) ? htmlspecialchars($lokasiValue) : 'N/A' }}"
                                            readonly>
                                    </div>

                                    <input type="hidden" name="status[]" value="{{ $asset->status }}">
                                    <input type="hidden" name="o365[]" value="{{ $asset->o365 }}">
                                    <input type="hidden" name="kondisi[]" value="{{ $asset->kondisi }}">
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                @if($assets->where('aksi', '!=', 'Return')->count() > 0) <!-- Only show this if there are assets not returned -->
                    <div class="form-group">
                        <label for="documentation">Documentation</label>
                        <input type="file" class="form-control" id="documentation" name="documentation" accept="image/*" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Approve All</button>
                        <a href="{{ route('shared.homeUser') }}" class="btn btn-secondary ml-3">Cancel</a>
                    </div>
                @endif
            </form>

            <!-- Return all form -->
            <form action="{{ route('assets-user.returnmultiple') }}" method="POST" enctype="multipart/form-data" class="mt-5">
                @csrf
                @method('DELETE')

                <div class="row">
                    @foreach($assets as $asset)
                        @if($asset->aksi === 'Return')
                            <div class="col-md-3 mb-4"> <!-- Keep the column for 4 items -->
                                <div class="asset-wrapper"> <!-- New wrapper for each asset -->
                                    <div class="form-group">
                                        <label for="asset_tagging">Asset Tagging</label>
                                        <input type="text" class="form-control" id="asset_tagging"
                                            value="{{ htmlspecialchars($inventories->where('id', $asset->asset_tagging)->first()->tagging ?? 'N/A', ENT_QUOTES) }}"
                                            readonly>
                                        <input type="hidden" name="asset_tagging[]" value="{{ $asset->asset_tagging }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="nama">Name</label>
                                        <input type="text" class="form-control" id="nama"
                                            value="{{ htmlspecialchars($customers->where('id', $asset->nama)->first()->name ?? 'N/A', ENT_QUOTES) }}"
                                            readonly>
                                        <input type="hidden" name="nama[]" value="{{ $asset->nama }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="keterangan">Reason</label>
                                        <input type="text" class="form-control" id="keterangan"
                                            value="{{ old('keterangan', $asset->keterangan) }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="note">Notes</label>
                                        <input type="text" class="form-control" id="note"
                                            value="{{ old('note', $asset->note) }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="lokasi">Location</label>
                                        <input type="text" class="form-control" id="lokasi" value="{{ old('lokasi', $asset->lokasi) }}"
                                            readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="documentation_return">Documentation</label>
                                        <input type="file" class="form-control" id="documentation_return" name="documentation[]" accept="image/*" required>
                                        @if($asset->documentation)
                                            <p class="mt-2"
                                                style="display: inline-block; background-color: rgba(128, 128, 128, 0.3); padding: 4px 8px; border-radius: 4px;">
                                                <span class="bold-text">Current file:</span>
                                                <a href="{{ asset('storage/' . $asset->documentation) }}" target="_blank"
                                                    class="text-decoration-underline">View</a>
                                            </p>
                                        @endif
                                    </div>

                                    <input type="hidden" name="assets[]" value="{{ $asset->id }}">
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                @if($assets->where('aksi', 'Return')->count() > 0) <!-- Only show this if there are assets to return -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-danger">Return All</button>
                        <a href="{{ route('shared.homeUser') }}" class="btn btn-secondary ml-3">Cancel</a>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
<br>
<br>
@endsection

<style>
    .form-container {
        max-width: 1000px; /* Increased width for better layout */
        margin: 0 auto;
        padding: 2rem;
        border-radius: 8px;
    }

    .asset-wrapper {
        border: 1px solid #ced4da; /* Border for each asset wrapper */
        border-radius: 8px; /* Rounded corners */
        padding: 1rem; /* Padding inside the wrapper */
        background-color: #f8f9fa; /* Light background color for better visibility */
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        border-radius: 4px;
        border: 1px solid #ced4da;
        padding: 0.5rem;
    }

    .form-group input[type="submit"] {
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
        padding: 0.75rem 1.5rem;
        border-radius: 4px;
    }

    .form-group input[type="submit"]:hover {
        background-color: #0056b3;
    }

    @media (max-width: 768px) {
        .form-container {
            padding: 1rem;
            max-width: 100%;
        }
    }
</style>
