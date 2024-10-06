@extends('layouts.app')
@section('title', 'Merk')

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
                    Merk&nbsp;&nbsp;
                    <span class="icon-wrapper">
                        <i class="fa-solid fa-2xs fa-tag  previous-icon"></i>
                    </span>
                </h3>
            </div>
        </div>
    </div>

    <div class="row d-flex align-items-stretch">
        <!-- Create Form -->
        <div class="col-md-6">
            <div class="card flex-fill">
                <div class="card-header">
                    <h2 class="text-center card-title">Add New Merk</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('merk.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label label-weight">Merk Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror input-bg"
                                id="name" placeholder="Merk Name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-add">
                                <i class="fa-solid fa-circle-plus"></i> Add
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Index Table -->
        <div class="col-md-6">
            <div class="card flex-fill">
                <div class="card-header">
                    <h2 class="text-center card-title">Merk List</h2>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <div class="table-container">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Merk Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($merkes as $merk)
                                        <tr>
                                            <td>{{ $merk->name }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-edit" onclick="editMerk({{ $merk->id }})">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </button>
                                                <form action="{{ route('merk.destroy', $merk->id) }}" method="POST" class="d-inline" id="delete-form-{{ $merk->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-delete" onclick="confirmDelete({{ $merk->id }})">
                                                        <i class="bi bi-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateMerkModal" tabindex="-1" aria-labelledby="updateMerkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #f8f8f8;">
                <h5 class="modal-title" id="updateMerkModalLabel" style="font-weight: 600;">Update Merk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateMerkForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="update_name" class="form-label" style="font-weight: 600;">Merk Name</label>
                        <input type="text" class="form-control" id="update_name" name="name" required>
                    </div>

                    <input type="hidden" id="update_merk_id" name="id">
                    <div style="text-align: right;">
                        <button type="submit" class="btn btn-update">Update</button>
                    </div>
                </form>
            </div>
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

    .row {
        display: flex;
        align-items: stretch; /* Ensure the columns stretch to the same height */
    }

    .card-title {
        font-weight: bold;
        margin-top: 15px;
    }

    .label-weight {
        font-weight: 600;
    }

    .input-bg {
        background-color: #f8f8f8;
    }

    .text-end {
        text-align: right;
    }

    .btn-add {
        background-color: #1bcfb4; 
        color: #fff; 
        font-weight: 500; 
        padding: 5px 20px;
    }

    .btn-add:hover {
        background-color: transparent;
        border: 1.4px solid #1bcfb4;
        color: #1bcfb4;
        padding: 4.3px 19px;
    }

    .table-container {
        max-height: 200px; /* Adjust this to your desired height */
        overflow-y: auto;
        position: relative;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 10px;
        text-align: left;
    }

    .table thead {
        position: sticky; /* Keep the header fixed */
        top: 0; /* Set to the top of the container */
        z-index: 10; /* Ensure it stays above the scrolling content */
        background-color: #f8f9fa; /* Match header background */
    }

    .table tbody tr {
        border-bottom: 1px solid #ebedf2;
    }

    .table tbody tr:hover {
        background-color: #f1f1f1;
    }

    .btn-edit {
        background-color: transparent; 
        border: 1.4px solid #4fb0f1; 
        color: #4fb0f1; 
        font-weight: 500;
    }

    .btn-edit:hover {
        background-color: #4fb0f1;
        color: #fff;
    }

    .btn-delete {
        background-color: #fe7c96;
        color: #fff;
        padding: 5px 7px;
    }

    .btn-delete:hover {
        background-color: transparent;
        color: #fe7c96;
        border: 1.4px solid #fe7c96;
        padding: 3.5px 7px;
    }

    .btn-update {
        background-color: #4fb0f1; color: #fff;
        font-weight: 500;
        padding: 6px 8px;
    }

    .btn-update:hover {
        background-color: transparent;
        border: 1.4px solid #4fb0f1;
        color: #4fb0f1;
        font-weight: 500;
        padding: 5.5px 7.5px;
    }

    @media (max-width: 576px) {
        .card-title {
            font-size: 1.5rem;
        }

        .btn-add,
        .btn-edit,
        .btn-delete {
            width: 100%;
            margin-bottom: 5px;
        }
    }

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

    /* Close button style */
    .btn-close {
        padding: 0.25rem 0.5rem; /* Adjust padding */
        font-size: 1rem; /* Match alert text size */
        line-height: 1; /* Align vertically with text */
    }
</style>

@endsection
<script>
    function editMerk(id) {
        fetch(`/merk/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('update_name').value = data.name;
                document.getElementById('update_merk_id').value = data.id;
                document.getElementById('updateMerkForm').action = `/merk/${data.id}`;
                var myModal = new bootstrap.Modal(document.getElementById('updateMerkModal'), {
                    backdrop: 'static'
                });
                myModal.show();
            })
            .catch(error => console.error('Error:', error));
    }

    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this Merk?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
