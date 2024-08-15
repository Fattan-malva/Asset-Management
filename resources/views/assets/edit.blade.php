@extends('layouts.app')

@section('content')
<br>
<br>
<h1 class="mt-4 text-center">Edit Asset</h1>
<br>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Edit Asset</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('assets.update', $asset->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="asset_tagging">Asset Tagging</label>
                    <select class="form-control" id="asset_tagging" name="asset_tagging" required>
                        @foreach($inventories as $inventory)
                            <option value="{{ $inventory->id }}" {{ $inventory->id == $asset->asset_tagging ? 'selected' : '' }}>
                                {{ $inventory->tagging }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="approval_status" value="Pending">

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
                    <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ old('lokasi', $asset->lokasi) }}" required>
                </div>

                <div class="form-group">
                    <select class="form-control" id="status" name="status" hidden>
                        <option value="Operation" {{ $asset->status == 'Operation' ? 'selected' : '' }}>Operation</option>
                        <option value="Inventory" {{ $asset->status == 'Inventory' ? 'selected' : '' }}>Inventory</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="o365">O365</label>
                    <select class="form-control" id="o365" name="o365" required>
                        <option value="Partner License" {{ $asset->o365 == 'Partner License' ? 'selected' : '' }}>Partner License</option>
                        <option value="Business" {{ $asset->o365 == 'Business' ? 'selected' : '' }}>Business</option>
                        <option value="Business Standard" {{ $asset->o365 == 'Business Standard' ? 'selected' : '' }}>Business Standard</option>
                        <option value="No License" {{ $asset->o365 == 'No License' ? 'selected' : '' }}>No License</option>
                    </select>
                </div>

                <div class="form-group">
                    <select class="form-control" id="kondisi" name="kondisi" hidden>
                        <option value="Good" {{ $asset->kondisi == 'Good' ? 'selected' : '' }}>Good</option>
                        <option value="Exception" {{ $asset->kondisi == 'Exception' ? 'selected' : '' }}>Exception</option>
                        <option value="Bad" {{ $asset->kondisi == 'Bad' ? 'selected' : '' }}>Bad</option>
                    </select>
                </div>

                <div class="form-group">
        <label for="documentation">Documentation</label>
        <input type="file" class="form-control" id="documentation" name="documentation" accept="image/*">
        @if($asset->documentation)
            <p>Current file: <a href="{{ asset('storage/' . $asset->documentation) }}" target="_blank">View</a></p>
        @endif
    </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
<br>
<br>
@endsection
