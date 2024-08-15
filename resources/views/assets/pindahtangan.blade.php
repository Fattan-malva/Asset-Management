@extends('layouts.app')

@section('content')
<br>
<br>
<h1 class="mt-4 text-center">Pindah Tangan</h1>
<br>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Pindah Tangan</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('assets.pindahUpdate', $asset->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="asset_tagging">Asset Tagging</label>
                    <select class="form-control" id="asset_tagging" name="asset_tagging" disabled>
                        @foreach($inventories as $inventory)
                            <option value="{{ $inventory->id }}" {{ $inventory->id == $asset->asset_tagging ? 'selected' : '' }}>
                                {{ $inventory->tagging }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="approval_status" value="Pending">
                <input type="hidden" name="aksi" value="Mutasi">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <select class="form-control" id="nama" name="nama" required>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $customer->id == $asset->nama ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="lokasi">Lokasi</label>
                    <input type="text" class="form-control" id="lokasi" name="lokasi"
                        value="{{ old('lokasi', $asset->lokasi) }}" required>
                </div>

                <div class="form-group">
               
                    <input type="file" class="form-control" id="documentation" name="documentation" accept="image/*" hidden>
                    @if($asset->documentation)
                        <p>Current file: <a href="{{ asset('storage/' . $asset->documentation) }}" target="_blank">View</a>
                        </p>
                    @endif
                </div>

                <button type="submit" class="btn btn-warning">Mutasi</button>
            </form>
        </div>
    </div>
</div>
<br>
<br>
@endsection