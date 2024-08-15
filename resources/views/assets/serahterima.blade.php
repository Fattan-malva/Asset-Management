@extends('layouts.app')

@section('content')
<br>
<br>
<h1 class="mt-4 text-center">Approve Asset</h1>
<br>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Approve Asset</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('assets.updateserahterima', $asset->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="asset_tagging">Asset Tagging</label>
                    <select class="form-control" id="asset_tagging" name="asset_tagging" readonly>
                        @foreach($inventories as $inventory)
                            <option value="{{ $inventory->id }}" {{ $inventory->id == $asset->asset_tagging ? 'selected' : '' }}>
                                {{ $inventory->tagging }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="asset_tagging_hidden" value="{{ $asset->asset_tagging }}">
                </div>
                <input type="hidden" name="approval_status" value="Approved">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <select class="form-control" id="nama" name="nama" readonly>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $customer->id == $asset->nama ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="nama_hidden" value="{{ $asset->nama }}">
                </div>

                <div class="form-group">
                    <label for="lokasi">Lokasi</label>
                    <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ old('lokasi', $asset->lokasi) }}" readonly>
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

                <button type="submit" class="btn btn-success">Approve</button>
            </form>
        </div>
    </div>
</div>
<br>
<br>
@endsection
