@extends('layouts.noheader')
@section('title', 'Maintenance')

@section('content')
<div class="container">
    <br><br>
    <div class="card shadow">
        <h2 style="margin-top: 25px; margin-bottom: 20px; text-align: center; font-weight: 600;">Maintenance</h2>
        <hr style="width: 80%; margin: 0 auto;">
        <div class="card-body" style="padding: 30px;">
            <form method="POST" action="{{ route('inventorys.update', $inventory->id) }}">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tagging" class="form-label">Asset Tagging</label>
                        <input type="text" class="form-control" id="tagging" name="tagging"
                            value="{{ $inventory->tagging }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="asets" class="form-label">Inventory Name</label>
                        <input type="text" class="form-control" id="asets" name="asets" value="{{ $inventory->asets }}"
                            readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="merk" class="form-label">Merk</label>
                        <input type="hidden" name="merk" value="{{ $inventory->merk }}">
                        <input type="text" class="form-control" value="{{ $merks[$inventory->merk] }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="seri" class="form-label">Serial Number</label>
                        <input type="text" class="form-control" id="seri" name="seri" value="{{ $inventory->seri }}"
                            readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="type" class="form-label">Type</label>
                        <input type="text" class="form-control" id="type" name="type" value="{{ $inventory->type }}"
                            readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="maintenance" class="form-label">Maintenance</label>
                        <input type="date" class="form-control" id="maintenance" name="maintenance"
                            value="{{ \Carbon\Carbon::parse($inventory->maintenance)->format('Y-m-d') }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="kondisi" class="form-label">Kondisi</label>
                        <select id="kondisi" name="kondisi" class="form-select" required>
                            <option value="Good" {{ $inventory->kondisi === 'Good' ? 'selected' : '' }}>Good</option>
                            <option value="Exception" {{ $inventory->kondisi === 'Exception' ? 'selected' : '' }}>Exception</option>
                            <option value="Bad" {{ $inventory->kondisi === 'Bad' ? 'selected' : '' }}>Bad</option>
                        </select>
                    </div>
                </div>

                <div class="mt-3 mb-2" style="text-align: right;">
                    <button type="submit" class="btn btn-save">Save Changes</button>
                    <a href="{{ route('inventorys.index') }}" class="btn btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-label {
        font-weight: 550;
    }
    .form-control {
        border: 1px solid #000;
    }
    .btn-save {
        background-color: transparent;
        border: 1.3px solid #1bcfb4;
        color: #1bcfb4;
        transition: background-color 0.3s, color 0.3s;
        font-weight: 500;
        padding: 5px 25px;
    }
    .btn-save:hover {
        background-color: #1bcfb4;
        color: #fff;
        padding: 5px 25px;
    }
    .btn-cancel {
        background-color: #fe7c96;
        border: 1.3px solid #fe7c96;
        color: #fff;
        transition: background-color 0.3s, color 0.3s;
        font-weight: 500;
        margin-left: 5px;
        padding: 5px 15px;
    }
    .btn-cancel:hover {
        background-color: transparent;
        border: 1.3px solid #fe7c96;
        color: #fe7c96;
        padding: 5px 15px;
    }
</style>
@endsection