@extends('layouts.app')
@section('title', 'Maintenance')

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
                    Maintenance&nbsp;&nbsp;
                    <span class="icon-wrapper">
                        <i class="fa-solid fa-2xs fa-screwdriver-wrench previous-icon"></i>
                    </span>
                </h3>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body" style="padding: 30px;">
            <form method="POST" action="{{ route('inventorys.update') }}">
                @csrf
                @method('PUT')

                <div class="row mb-3">


                    <div class="col-md-6 form-group">
                        <label for="tagging">Select Assets to Maintenance</label>
                        <select class="form-control select-dark" id="tagging" name="ids[]" multiple="multiple" required>
                            @foreach($inventories as $inventory)
                                                        @php
                                                            // Determine if the asset needs maintenance
                                                            $tanggalMasuk = $inventory->tanggalmasuk;
                                                            $tanggalMaintenance = $inventory->maintenance ?? null;
                                                            $tanggalAcuan = $tanggalMaintenance ?? $tanggalMasuk;
                                                            $bulanSejakAcuan = now()->diffInMonths($tanggalAcuan);
                                                        @endphp

                                                        @if ($bulanSejakAcuan >= 1) {{-- Only show assets that need maintenance --}}
                                                            <option value="{{ $inventory->id }}">{{ $inventory->tagging }}</option>
                                                        @endif
                            @endforeach
                        </select>
                    </div>


                  
                </div>

                <div class="row mb-3">
                   
                </div>

                <div class="row mb-3">
            
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
                            <option value="Exception" {{ $inventory->kondisi === 'Exception' ? 'selected' : '' }}>
                                Exception</option>
                            <option value="Bad" {{ $inventory->kondisi === 'Bad' ? 'selected' : '' }}>Bad</option>
                        </select>
                    </div>
                </div>

                <div class="mt-3 mb-2" style="text-align: right;">
                    <button type="submit" class="btn" style="background-color:#1bcfb4;">Submit</button>
                    <a href="{{ route('inventorys.index') }}" class="btn ml-3"
                        style="background-color:#FE7C96;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

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
        /* Transition untuk efek hover */
    }

    .back-icon:hover {
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.1) -13%, #B100FF);
        /* Warna gradien saat hover dengan putih sedikit di kiri */
    }

    .back-wrapper {
        display: flex;
        align-items: center;
        /* Center vertically */
        margin-right: auto;
        /* Push the dashboard title to the right */
    }

    .back-text {
        display: flex;
        flex-direction: column;
        /* Stack text vertically */
        margin-left: 10px;
        /* Space between icon and text */
    }

    .back-text .title {
        font-weight: 600;
        font-size: 17px;
    }

    .back-text .small-text {
        font-size: 0.8rem;
        /* Smaller font size for the second line */
        color: #aaa;
        /* Optional: a lighter color for the smaller text */
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

    .btn {
        margin: 0 0.5rem;
        font-size: 16px;
        font-weight: bold;
        color: white;
    }
</style>
@endsection