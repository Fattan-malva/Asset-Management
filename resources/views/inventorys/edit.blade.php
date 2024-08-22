@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <br>
    <h1 class="mt-4 text-center">Update Asets</h1>
    <br>
    <br>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('inventorys.update', $inventory->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="tagging" class="form-label">Asset Tagging</label>
                    <input type="text" class="form-control" id="tagging" name="tagging" value="{{ $inventory->tagging }}" required>
                </div>
                <div class="form-group">
                    <label for="asets" class="form-label">Inventory Name</label>
                    <input type="text" class="form-control" id="asets" name="asets" value="{{ $inventory->asets }}" required>
                </div>
                <div class="form-group">
                    <label for="merk" class="form-label">Merk</label>
                    <select id="merk" name="merk" class="form-select" required>
                        @foreach($merks as $id => $name)
                            <option value="{{ $id }}" {{ $id == $inventory->merk ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="seri" class="form-label">Serial Number</label>
                    <input type="text" class="form-control" id="seri" name="seri" value="{{ $inventory->seri }}" required>
                </div>
                <div class="form-group">
                    <label for="type" class="form-label">Type</label>
                    <input type="text" class="form-control" id="type" name="type" value="{{ $inventory->type }}" required>
                </div>
                <div class="form-group">
                    <label for="kondisi" class="form-label">kondisi</label>
                    <select id="kondisi" name="kondisi" class="form-select" required>
                        <option value="Good" {{ $inventory->kondisi === 'Good' ? 'selected' : '' }}>Good</option>
                        <option value="Exception" {{ $inventory->kondisi === 'Exception' ? 'selected' : '' }}>Exception</option>
                        <option value="Bad" {{ $inventory->kondisi === 'Bad' ? 'selected' : '' }}>Bad</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('inventorys.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
