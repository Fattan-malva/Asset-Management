@extends('layouts.app')
@section('title', 'Users')

@section('content')

<br>
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
            Users&nbsp;&nbsp;
            <span class="icon-wrapper">
                <i class="fa-solid fa-2xs fa-list house-icon"></i>
            </span>
        </h3>
    </div>
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif 
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('customer.create') }}" class="btn btn-lg btn-custom">
                    <i class="bi bi-cloud-plus-fill"></i> Create
                </a>
            </div>
            <div class="table-responsive">
                <table id="customerTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">NRP</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Position</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $index => $customer)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $customer->nrp }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->username }}</td>
                                <td>{{ $customer->mapping }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-sm btn-edit" title="Edit">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="{{ route('customer.destroy', $customer->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-delete" title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this customer?')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center"
                                    style="padding: 50px; padding-bottom: 100px; padding-top: 100px; font-size: 1.2em;">No
                                    customer found.</td>
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
        transition: background 0.3s ease; /* Transition untuk efek hover */
    }

    .btn-edit{
        background-color: transparent; border: 1.4px solid #4fb0f1; color: #4fb0f1; font-weight: 500;
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

    .back-icon:hover {
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.1) -13%, #B100FF); /* Warna gradien saat hover dengan putih sedikit di kiri */
    }

    .back-wrapper {
        display: flex;
        align-items: center; /* Center vertically */
        margin-right: auto; /* Push the dashboard title to the right */
    }

    .back-text {
        display: flex;
        flex-direction: column; /* Stack text vertically */
        margin-left: 10px; /* Space between icon and text */
    }

    .back-text .title {
        font-weight: 600;
        font-size: 17px;
    }

    .back-text .small-text {
        font-size: 0.8rem; /* Smaller font size for the second line */
        color: #aaa; /* Optional: a lighter color for the smaller text */
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

    .btn-custom {
        background-color: #1bcfb4;
        color: white;
        border: none;
        padding: 0.4rem 0.5rem;
        border-radius: 0.5rem;
        transition: background-color 0.3s ease;
        margin-bottom: -70px;
        font-weight: 600;
        font-size: 16px;
        margin-left: 10px;
    }

    .btn-custom:hover {
        background-color: #3EEAD0; /* Darker shade for hover effect */
        color: #fff;
    }

    @media (max-width: 576px) {
        .btn-custom {
            width: 100%; /* Make the button full-width on small screens */
            margin-bottom: 1rem; /* Add some spacing below the button */
            margin-right: 8px;
        }
        
        .d-flex {
            flex-direction: column; /* Stack elements vertically */
            align-items: stretch; /* Stretch elements to full width */
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

    .legend-colon {
        margin: 0 5px; /* Space around the colon */
    }

    /* Hide colon on mobile devices */
    @media (max-width: 576px) {
        .legend-colon {
            display: none; /* Hide colon */
        }
    }

</style>
@endsection