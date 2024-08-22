@extends('layouts.app')

@section('content')
<br>
<br>
<h1 class="mt-4 text-center">Approve Asset</h1>
<br>
<div class="container">
    <div class="card">
        <div class="card-body">
            @if($asset->aksi !== 'Return')
                <form action="{{ route('assets.updateserahterima', $asset->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="asset_tagging">Asset Tagging</label>
                        <input type="text" class="form-control" id="asset_tagging" name="asset_tagging_display"
                            value="{{ $inventories->where('id', $asset->asset_tagging)->first()->tagging ?? 'N/A' }}"
                            readonly>
                        <input type="hidden" name="asset_tagging" value="{{ $asset->asset_tagging }}">
                    </div>

                    <input type="hidden" name="approval_status" value="Approved">

                    <div class="form-group">
                        <label for="nama">Name</label>
                        <input type="text" class="form-control" id="nama" name="nama_display"
                            value="{{ $customers->where('id', $asset->nama)->first()->name ?? 'N/A' }}" readonly>
                        <input type="hidden" name="nama" value="{{ $asset->nama }}">
                    </div>

                    <div class="form-group">
                        <label for="lokasi">Location</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi"
                            value="{{ old('lokasi', $asset->lokasi) }}" readonly>
                    </div>

                    <input type="hidden" name="status" value="{{ $asset->status }}">
                    <input type="hidden" name="o365" value="{{ $asset->o365 }}">
                    <input type="hidden" name="kondisi" value="{{ $asset->kondisi }}">

                    <div class="form-group">
                        <label for="documentation">Documentation</label>
                        <input type="file" class="form-control" id="documentation" name="documentation" accept="image/*" required>
                        @if($asset->documentation)
                            <p>Current file: <a href="{{ asset('storage/' . $asset->documentation) }}" target="_blank">View</a></p>
                        @endif
                    </div>

                    <div class="text-center">
                        @if($asset->aksi !== 'Return')
                            <button type="submit" class="btn btn-success">Approve</button>
                        @endif
                        <a href="{{ route('assets.index') }}" class="btn btn-secondary ml-3">Cancel</a>
                    </div>
                </form>
            @endif

            @if($asset->aksi === 'Return')
                <form action="{{ route('assets-user.delete', $asset->id) }}" method="POST" class="mt-3">
                    @csrf
                    @method('DELETE')

                    <div class="form-group">
                        <label for="asset_tagging">Asset Tagging</label>
                        <input type="text" class="form-control" id="asset_tagging" name="asset_tagging"
                            value="{{ $inventories->where('id', $asset->asset_tagging)->first()->tagging ?? 'N/A' }}"
                            readonly>
                        <input type="hidden" name="asset_tagging" value="{{ $asset->asset_tagging }}">
                    </div>

                    <div class="form-group">
                        <label for="nama">Name</label>
                        <input type="text" class="form-control" id="nama" name="nama"
                            value="{{ $customers->where('id', $asset->nama)->first()->name ?? 'N/A' }}" readonly>
                        <input type="hidden" name="nama" value="{{ $asset->nama }}">
                    </div>

                    <div class="form-group">
                        <label for="lokasi">Location</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi"
                            value="{{ old('lokasi', $asset->lokasi) }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="documentation">Documentation</label>
                        <input type="file" class="form-control" id="documentation" name="documentation" accept="image/*" required>
                        @if($asset->documentation)
                            <p>Current file: <a href="{{ asset('storage/' . $asset->documentation) }}" target="_blank">View</a></p>
                        @endif
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-danger">Return Asset</button>
                        <a href="{{ route('assets.index') }}" class="btn btn-secondary ml-3">Cancel</a>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
<br>
<br>
@endsection
