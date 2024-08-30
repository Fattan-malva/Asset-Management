@extends('layouts.app')

@section('content')
<h1 class="mt-4 text-center fw-bold display-5">Asset Mutation</h1>
<br>
<div class="container">
    <div class="card">
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
                    <label for="nama">New Holder Name</label>
                    <select class="form-control" id="nama" name="nama" required>
                        @foreach($customers->filter(fn($customer) => $customer->id != $asset->nama) as $customer)
                            <option value="{{ $customer->id }}">
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
                        <p class="mt-2">Current file: <a href="{{ asset('storage/' . $asset->documentation) }}" target="_blank">View</a></p>
                    @endif
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-warning">Mutation</button>
                    <a href="{{ route('assets.indexmutasi') }}" class="btn btn-secondary ml-3">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<br>
<br>
@endsection
