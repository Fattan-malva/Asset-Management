@extends('layouts.app')
@section('title', 'Assets Scrap')

@section('content')
<div class="container">
    <h3>Assets Scrap</h3>
    
    <form action="{{ route('inventorys.delete') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('DELETE')

        <div class="form-group">
            <label for="tagging">Select Assets to Scrap</label>
            <select class="form-control" id="tagging" name="ids[]" multiple="multiple" required>
                @foreach($inventories as $inventory)
                    <option value="{{ $inventory->id }}">{{ $inventory->tagging }}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Hold down the Ctrl (Windows) / Command (Mac) button to select multiple items.</small>
        </div>

        <div class="form-group">
            <label for="documentation">Upload Documentation (Reason for Scrapping)</label>
            <input type="file" class="form-control" id="documentation" name="documentation" accept=".pdf,.doc,.docx,.jpg,.png" required>
            <small class="form-text text-muted">Please upload the documentation file.</small>
        </div>

        <button type="submit" class="btn btn-danger">Scrap Selected Assets</button>
    </form>
</div>
@endsection
