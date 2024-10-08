@extends('layouts.app')
@section('title', 'Add Asset')

@section('content')
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
                    Add Asset&nbsp;&nbsp;
                    <span class="icon-wrapper">
                        <i class="fa-solid fa-2xs fa-calendar-check previous-icon"></i>
                    </span>
                </h3>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body" style="padding: 30px;">
            <form action="{{ route('inventorys.store') }}" method="POST" enctype="multipart/form-data" id="addAsset">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="tagging" class="form-label">Asset Code</label>
                        <input type="text" class="form-control @error('tagging') is-invalid @enderror" id="tagging"
                            name="tagging" value="{{ old('tagging') }}" placeholder="Enter asset tag">
                        @error('tagging')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="asets" class="form-label">Asset Type</label>
                        <input type="text" class="form-control @error('asets') is-invalid @enderror" id="asets"
                            name="asets" value="{{ old('asets') }}" placeholder="Enter asset type">
                        @error('asets')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
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

                    <div class="col-md-6 form-group">
                        <label for="seri" class="form-label">Serial Number</label>
                        <input type="text" class="form-control @error('seri') is-invalid @enderror" id="seri"
                            name="seri" value="{{ old('seri') }}" placeholder="Enter serial number">
                        @error('seri')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="type" class="form-label">Specification</label>
                        <input type="text" class="form-control @error('type') is-invalid @enderror" id="type"
                            name="type" value="{{ old('type') }}" placeholder="Enter asset type">
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="kondisi" class="form-label">Condition</label>
                        <select class="form-select @error('kondisi') is-invalid @enderror" id="kondisi" name="kondisi"
                            required>
                            <option value="New" {{ old('kondisi') == 'New' ? 'selected' : '' }}>New</option>
                            <option value="Good" {{ old('kondisi') == 'Good' ? 'selected' : '' }}>Good</option>
                            <option value="Exception" {{ old('kondisi') == 'Exception' ? 'selected' : '' }}>Exception
                            </option>
                            <option value="Bad" {{ old('kondisi') == 'Bad' ? 'selected' : '' }}>Bad</option>
                        </select>
                        @error('kondisi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="tanggalmasuk" class="form-label">Entry Date</label>
                        <input type="date" class="form-control @error('tanggalmasuk') is-invalid @enderror"
                            id="tanggalmasuk" name="tanggalmasuk" value="{{ old('tanggalmasuk') }}"
                            placeholder="Enter the entry date">
                        @error('tanggalmasuk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="documentation" class="form-label">Documentation</label>
                        <input type="file" class="form-control @error('documentation') is-invalid @enderror"
                            id="documentation" name="documentation" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <small class="form-text text-muted">*Please upload the documentation file.</small>
                        @error('documentation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn" style="background-color:#1bcfb4;">Submit</button>
                    <a href="{{ route('inventorys.index') }}" class="btn ml-3"
                        style="background-color:#FE7C96;">Cancel</a>
                </div>
            </form>
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
        margin-top: 54px;
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

    .btn {
        margin: 0 0.5rem;
        font-size: 16px;
        font-weight: bold;
        color: white;
    }
</style>
<script>
    document.getElementById('addAsset').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form submission

        // Show loading alert
        Swal.fire({
            title: 'Loading...',
            text: 'Please wait while we create the asset.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Simulate form submission
        setTimeout(() => {
            this.submit(); // Submit the form after the loading alert
        }, 1500);
    });
</script>
@endsection