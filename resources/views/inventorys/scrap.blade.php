@extends('layouts.app')
@section('title', 'Scrap Assets')

@section('content')
<br>
<div class="container">
    <div>
        <div class="container">
            <div class="header-container">
                <div class="back-wrapper">
                    <i class='bx bxs-chevron-left back-icon' id="back-icon"></i>
                    <div class="back-text">
                        <span class="title">Back</span>
                        <span class="small-text">to previous page</span>
                    </div>
                </div>
                <h3 class="dashboard-title">
                    Scrap Assets&nbsp;&nbsp;
                    <span class="icon-wrapper">
                        <i class="fa-solid fa-2xs fa-ban previous-icon"></i>
                    </span>
                </h3>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
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
                </div>

                <div class="form-group">
                    <label for="documentation">Upload Documentation (Reason for Scrapping)</label>
                    <input type="file" class="form-control" id="documentation" name="documentation" accept=".pdf,.doc,.docx,.jpg,.png" required>
                    <small class="form-text text-muted">Please upload the documentation file.</small>
                </div>

                <button type="submit" class="btn btn-danger">Scrap Selected Assets</button>
            </form>
        </div>
    </div>
</div>
<br><br>

<style>
    /* Header Styles */
    .header-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
        margin-top: 30px;
    }

    .back-icon {
        cursor: pointer;
        background: linear-gradient(90deg, rgba(255, 255, 255, 0) -30%, #B66DFF);
        height: 36px;
        width: 36px;
        border-radius: 4px;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.25);
        margin-right: auto;
        transition: background 0.3s ease;
    }

    .back-icon:hover {
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.1) -13%, #B100FF);
    }

    .back-wrapper {
        display: flex;
        align-items: center;
        margin-right: auto;
    }

    .back-text {
        display: flex;
        flex-direction: column;
        margin-left: 10px;
    }

    .back-text .title {
        font-weight: 600;
        font-size: 17px;
    }

    .back-text .small-text {
        font-size: 0.8rem;
        color: #aaa;
        margin-top: -3px;
    }

    .dashboard-title {
        font-weight: bold;
        font-size: 1.125rem;
    }

    .icon-wrapper {
        background: linear-gradient(90deg, rgba(255, 255, 255, 0) -30%, #B66DFF);
        height: 36px;
        width: 36px;
        border-radius: 4px;
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.25);
    }

    .previous-icon {
        font-size: 16px;
    }

    /* Form and Table Styles */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-control {
        font-size: 1rem;
        padding: 10px;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .table-hover tbody tr td,
    .table-hover thead tr th {
        border-bottom: 1px solid #ebedf2;
    }

    .table-hover tbody tr td {
        font-weight: 300;
    }

    .table-hover thead tr th {
        font-weight: 600;
    }
</style>
@endsection
