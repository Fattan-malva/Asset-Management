@extends('layouts.app')

@section('content')
<br>
<br>
<h1 class="mt-4 text-center">Add Asset</h1>
<br>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Add New Asset</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('inventorys.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="tagging" class="form-label">Asset Tag</label>
                    <input type="text" class="form-control @error('tagging') is-invalid @enderror" id="tagging" name="tagging"
                        value="{{ old('tagging') }}">
                    @error('tagging')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="asets" class="form-label">Asset Type</label>
                    <input type="text" class="form-control @error('asets') is-invalid @enderror" id="asets" name="asets"
                        value="{{ old('asets') }}">
                    @error('asets')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="merk" class="form-label">Merk</label>
                    <select class="form-select @error('merk') is-invalid @enderror" id="merk" name="merk">
                        <option value="">Select Merk</option>
                        @foreach($merkes as $merk)
                            <option value="{{ $merk->id }}" {{ old('merk') == $merk->id ? 'selected' : '' }}>
                                {{ $merk->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('merk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="seri" class="form-label">Serial Number</label>
                    <input type="text" class="form-control @error('seri') is-invalid @enderror" id="seri" name="seri"
                        value="{{ old('seri') }}">
                    @error('seri')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Type</label>
                    <input type="text" class="form-control @error('type') is-invalid @enderror" id="type" name="type"
                        value="{{ old('type') }}">
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kondisi" class="form-label">Kondisi</label>
                    <select class="form-control" id="kondisi" name="kondisi" required>
                        <option value="Good">Good</option>
                        <option value="Exception">Exception</option>
                        <option value="Bad">Bad</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('inventorys.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
<br>
<br>
@endsection