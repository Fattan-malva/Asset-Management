@extends('layouts.app')
@section('title', 'Return')

@section('content')
<h1 class="mt-4 text-center fw-bold display-5">Asset Return</h1>
<br>
<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('assets.returnUpdate', $asset->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="aksi" value="Return">
                <input type="hidden" name="asset_tagging" value="{{ $asset->asset_tagging }}">
                <input type="hidden" name="nama" value="{{ $asset->nama }}">
                <input type="hidden" name="lokasi" value="{{ $asset->lokasi }}">

                <div class="form-group">
                    <label for="asset_tagging_display">Asset Tagging</label>
                    <!-- Find the correct tagging value -->
                    @php
                        $taggingValue = $inventories->firstWhere('id', $asset->asset_tagging)->tagging ?? 'Not Found';
                    @endphp
                    <input type="text" class="form-control" id="asset_tagging_display" value="{{ $taggingValue }}"
                        readonly>
                </div>

                <div class="form-group">
                    <label for="nama_display">Owner's Name</label>
                    <input type="text" class="form-control" id="nama_display" value="{{ $asset->customer_name }}"
                        readonly>
                </div>

                <div class="form-group">
                    <label for="keterangan">Reason for return</label>
                    <select class="form-select" id="keterangan" name="keterangan" required>
                        <option value="" disabled selected>Choose a reason</option>
                        <option value="Damaged" {{ $asset->keterangan == 'Damaged' ? 'selected' : '' }}>Damaged</option>
                        <option value="Service" {{ $asset->keterangan == 'Service' ? 'selected' : '' }}>Service</option>
                        <option value="Not yet given" {{ $asset->keterangan == 'Not yet given' ? 'selected' : '' }}>Not
                            yet given</option>
                    </select>
                </div>


                <div class="form-group">
                    <label for="lokasi_display">Location</label>
                    <input type="text" class="form-control" id="lokasi_display" value="{{ $asset->lokasi }}" readonly>
                </div>
                <div class="form-group">
                    <input type="file" class="form-control" id="documentation" name="documentation" accept="image/*"
                        hidden>
                </div>
                <div class="form-group">
                    @if($asset->documentation)
                        <p class="mt-4"
                            style="display: inline-block; background-color: rgba(128, 128, 128, 0.3); padding: 4px 10px; border-radius: 4px; font-weight: bold;">
                            Current file:<a href="{{ asset('storage/' . $asset->documentation) }}" target="_blank"
                                class="text-decoration-underline">View</a>
                        </p>
                    @endif
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-danger">Submit Return</button>
                    <a href="{{ route('assets.indexreturn') }}" class="btn btn-secondary ml-3">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<br>
<br>
@endsection