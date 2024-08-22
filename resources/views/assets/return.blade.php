@extends('layouts.app')

@section('content')
<br>
<br>
<h1 class="mt-4 text-center">Asset Return</h1>
<br>
<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('assets.returnUpdate', $asset->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="aksi" value="Return">
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

                <div class="form-group">
                    <label for="nama">Owner's Name</label>
                    <select class="form-control" id="nama" name="nama" required>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $customer->id == $asset->nama ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="lokasi">Location</label>
                    <input type="text" class="form-control" id="lokasi" name="lokasi"
                        value="{{ old('lokasi', $asset->lokasi) }}" required>
                </div>

                <div class="form-group">
                    <label for="documentation">Documentation</label>
                    <input type="file" class="form-control" id="documentation" name="documentation" accept="image/*">
                    @if($asset->documentation)
                        <p>Current file: <a href="{{ asset('storage/' . $asset->documentation) }}" target="_blank">View</a>
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