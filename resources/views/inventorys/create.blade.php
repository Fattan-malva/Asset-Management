@extends('layouts.app')
@section('title', 'Add Asset')

@section('content')
<h1 class="mt-4 text-center fw-bold display-5">Add Asset</h1>
<br>
<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('inventorys.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="tagging" class="form-label">Asset Tag</label>
                    <input type="text" class="form-control @error('tagging') is-invalid @enderror" id="tagging"
                        name="tagging" value="{{ old('tagging') }}" placeholder="Enter asset tag">
                    @error('tagging')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="asets" class="form-label">Asset Type</label>
                    <input type="text" class="form-control @error('asets') is-invalid @enderror" id="asets" name="asets"
                        value="{{ old('asets') }}" placeholder="Enter asset type">
                    @error('asets')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
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

                <div class="form-group">
                    <label for="seri" class="form-label">Serial Number</label>
                    <input type="text" class="form-control @error('seri') is-invalid @enderror" id="seri" name="seri"
                        value="{{ old('seri') }}" placeholder="Enter serial number">
                    @error('seri')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type" class="form-label">Type</label>
                    <input type="text" class="form-control @error('type') is-invalid @enderror" id="type" name="type"
                        value="{{ old('type') }}" placeholder="Enter asset type">
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kondisi" class="form-label">Condition</label>
                    <select class="form-select @error('kondisi') is-invalid @enderror" id="kondisi" name="kondisi"
                        required>
                        <option value="New" {{ old('kondisi') == 'New' ? 'selected' : '' }}>New</option>
                        <option value="Good" {{ old('kondisi') == 'Good' ? 'selected' : '' }}>Good</option>
                        <option value="Exception" {{ old('kondisi') == 'Exception' ? 'selected' : '' }}>Exception</option>
                        <option value="Bad" {{ old('kondisi') == 'Bad' ? 'selected' : '' }}>Bad</option>
                    </select>
                    @error('kondisi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tanggalmasuk" class="form-label">Entry Date</label>
                    <input type="date" class="form-control @error('tanggalmasuk') is-invalid @enderror"
                        id="tanggalmasuk" name="tanggalmasuk" value="{{ old('tanggalmasuk') }}"
                        placeholder="Enter the entry date">
                    @error('tanggalmasuk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="documentation" class="form-label">Documentation</label>
                    <input type="file" class="form-control @error('documentation') is-invalid @enderror" id="documentation"
                        name="documentation" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                    @error('documentation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('inventorys.index') }}" class="btn btn-secondary ms-3">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<br>
<br>
@endsection
