@extends('layouts.app')
@section('title', 'Asset Total')
@section('content')

<br>
<div class="container">
    <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px; margin-top: 30px;">
        <i class='bx bx-arrow-back' id="back-icon" style="cursor:pointer; background: linear-gradient(135deg, #FFFFFF, #B66DFF); height: 36px; width: 36px; border-radius: 4px; color: #fff; display: flex; align-items: center; justify-content: center; box-shadow: 0 3px 8.3px .7px rgba(163, 93, 255, .35); margin-right: auto;">
        </i>
        <h3 style="font-weight: bold; font-size: 1.125rem;">
            Asset Total&nbsp;&nbsp;
            <span style="background: linear-gradient(135deg, #FFFFFF, #B66DFF); height: 36px; width: 36px; border-radius: 4px; color: #fff; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 3px 8.3px .7px rgba(163, 93, 255, .35);">
                <i class="fa-solid fa-2xs fa-database" style="font-size: 16px;"></i>
            </span>
        </h3>
    </div>
    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive">
                <table id="inventoryTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Asets Name</th>
                            <th scope="col">Merk</th>
                            <th scope="col">Total Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inventorySummary as $summary)
                            <tr>
                                <td>{{ $summary->asets }}</td>
                                <td>{{ $summary->merk }}</td>
                                <td>{{ $summary->total_quantity }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center" style="padding: 50px; padding-bottom: 100px; padding-top: 100px; font-size: 1.2em;">No Assets found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<br>
<br>

<style>
    /* CSS for table row borders */
    .table-hover tbody tr td,
    .table-hover thead tr th {
        border-bottom: 1px solid #ebedf2; /* Add a border to the bottom of each row */
        background-color: #fff;
    }

    .table-hover tbody tr td {
        font-weight: 300;
    }

    .table-hover thead tr th {
        font-weight: 600;
    }

    /* Remove any cell borders */
    .table-hover th,
    .table-hover td {
        border: none; /* Remove borders from cells */
        padding: 10px; /* Keep padding for cells */
    }
</style>
@endsection