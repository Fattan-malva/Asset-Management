@extends('layouts.app')
@section('title', 'Maintenance')

@section('content')
<div class="container">
    <br>
    <br>
    <h1 class="mt-4 text-center">Maintenance</h1>
    <br>
    <br>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('inventorys.update', $inventory->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="tagging" class="form-label">Asset Tagging</label>
                    <input type="text" class="form-control" id="tagging" name="tagging"
                        value="{{ $inventory->tagging }}" readonly>
                </div>

                <div class="form-group">
                    <label for="asets" class="form-label">Inventory Name</label>
                    <input type="text" class="form-control" id="asets" name="asets" value="{{ $inventory->asets }}"
                        readonly>
                </div>

                <div class="form-group">
                    <label for="merk" class="form-label">Merk</label>
                    <!-- Hidden field to submit the value -->
                    <input type="hidden" name="merk" value="{{ $inventory->merk }}">
                    <input type="text" class="form-control" value="{{ $merks[$inventory->merk] }}" readonly>
                </div>

                <div class="form-group">
                    <label for="seri" class="form-label">Serial Number</label>
                    <input type="text" class="form-control" id="seri" name="seri" value="{{ $inventory->seri }}"
                        readonly>
                </div>

                <div class="form-group">
                    <label for="type" class="form-label">Type</label>
                    <input type="text" class="form-control" id="type" name="type" value="{{ $inventory->type }}"
                        readonly>
                </div>

                <div class="form-group">
                    <label for="maintenance" class="form-label">Maintenance</label>
                    <input type="date" class="form-control" id="maintenance" name="maintenance"
                        value="{{ \Carbon\Carbon::parse($inventory->maintenance)->format('Y-m-d') }}" required>
                </div>


                <div class="form-group">
                    <label for="kondisi" class="form-label">Kondisi</label>
                    <select id="kondisi" name="kondisi" class="form-select" required>
                        <option value="Good" {{ $inventory->kondisi === 'Good' ? 'selected' : '' }}>Good</option>
                        <option value="Exception" {{ $inventory->kondisi === 'Exception' ? 'selected' : '' }}>Exception
                        </option>
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