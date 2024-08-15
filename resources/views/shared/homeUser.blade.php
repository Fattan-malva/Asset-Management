@extends('layouts.app')

@section('content')
<section id="hero">
    <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>
        <div class="carousel-inner" role="listbox">

            <!-- Slide 1 -->
            <div class="carousel-item active"
                style="background-image: url('{{ asset('assets/img/slide/slide1.jpg') }}')">
                <div class="carousel-container">
                    <div class="container">
                        <h2 class="animate__animated animate__fadeInDown">Hello
                            {{ ucfirst(strtolower(session('user_name'))) }}!
                        </h2>
                        <p class="animate__animated animate__fadeInUp">Welcome to Global Service Indonesia. We are here
                            to provide the best solutions and services tailored for you.</p>
                        <a href="#user-assets" class="btn-get-started animate__animated animate__fadeInUp scrollto">Read
                            More</a>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item" style="background-image: url('{{ asset('assets/img/slide/slide-2.jpg') }}')">
                <div class="carousel-container">
                    <div class="container">
                        <h2 class="animate__animated animate__fadeInDown">Hello
                            {{ ucfirst(strtolower(session('user_name'))) }}!
                        </h2>
                        <p class="animate__animated animate__fadeInUp">Explore our diverse range of services and
                            solutions to meet your needs.</p>
                        <a href="#user-assets" class="btn-get-started animate__animated animate__fadeInUp scrollto">Read
                            More</a>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item" style="background-image: url('{{ asset('assets/img/slide/slide-3.jpg') }}')">
                <div class="carousel-container">
                    <div class="container">
                        <h2 class="animate__animated animate__fadeInDown">Hello
                            {{ ucfirst(strtolower(session('user_name'))) }}!
                        </h2>
                        <p class="animate__animated animate__fadeInUp">We are dedicated to delivering exceptional value
                            through our services and expertise.</p>
                        <a href="#user-assets" class="btn-get-started animate__animated animate__fadeInUp scrollto">Read
                            More</a>
                    </div>
                </div>
            </div>
        </div>

        <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
        </a>

        <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
        </a>
    </div>
</section>

<main id="main">
    <!-- ======= User Assets Section ======= -->
    <section id="user-assets" class="user-assets">
        <br>
        <br>
        <h1 class="text-center animate__animated animate__fadeInDown">
            Hello {{ ucfirst(strtolower(session('user_name'))) }},
            This is your asset
        </h1>
        <br>
        <br>
        <div class="container">
            <div class="row">
                <!-- User Profile Card -->
                <div class="col-md-4 mb-4">
                    <div class="card border-info mb-4">
                        <div class="card-header bg-info text-white">
                            <h2>User Information</h2>
                        </div>
                        <div class="card-body">
                            <p><strong>Name:</strong> {{ ucfirst(strtolower(session('user_name'))) }}</p>
                            <p><strong>Email:</strong> {{ session('user_username') }}</p>
                            <p><strong>Role:</strong> {{ session('user_role') }}</p>
                            <p><strong>User ID:</strong> {{ session('user_id') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Assets Section -->
                <div class="col-md-8">
                    <!-- Section for Pending Assets -->
                    <div class="card border-primary mb-4 ">
                        <div class="card-header bg-primary text-white">
                            <h2>Waiting for Approval</h2>
                        </div>
                        <div class="card-body">
                            @if ($pendingAssets->isEmpty())
                                <p class="text-center">No assets waiting for approval.</p>
                            @else
                                <div class="row">
                                    @foreach ($pendingAssets as $asset)
                                        <div class="col-md-6 mb-3">
                                            <div class="card border-primary">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $asset->customer_name }}</h5>
                                                    <p class="card-text">
                                                        <strong>Action:</strong> {{ $asset->aksi }}<br>
                                                        <strong>Asset Tag:</strong> {{ $asset->tagging }}<br>
                                                        <strong>Jenis Aset:</strong> {{ $asset->jenis_aset }}<br>
                                                        <strong>Merk:</strong> {{ $asset->merk_name }}
                                                    </p>
                                                    <a href="{{ route('assets.serahterima', ['id' => $asset->id]) }}"
                                                        class="btn btn-primary">Approve</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Section for Approved Assets -->
                    <div class="card border-success">
                        <div class="card-header bg-success text-white">
                            <h2>Approved Assets</h2>
                        </div>
                        <div class="card-body">
                            @if ($assets->isEmpty())
                                <p class="text-center">No approved assets found.</p>
                            @else
                                <div class="row">
                                    @foreach ($assets as $index => $asset)
                                        <div class="col-md-4 mb-3">
                                            <div class="card border-success h-100">
                                                <div class="card-body">
                                                    <h3 class="card-title">{{ ucfirst(strtolower(session('user_name'))) }}</h3>
                                                    <p class="card-text">
                                                        <strong>Asset Tag:</strong> {{ $asset->tagging }}<br>
                                                        <strong>Jenis Aset:</strong> {{ $asset->jenis_aset }}<br>
                                                        <strong>Merk:</strong> {{ $asset->merk_name }}<br>
                                                        <strong>Location:</strong> {{ $asset->lokasi }}<br>
                                                        <strong>Status:</strong> {{ $asset->approval_status }}
                                                    </p>
                                                    <div class="action-buttons">
                                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                            data-bs-target="#detailModal{{ $asset->id }}" title="View Details">
                                                            <i class="bi bi-file-earmark-text"></i> Detail Asset
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- Modal -->
                                                <div class="modal fade" id="detailModal{{ $asset->id }}" tabindex="-1"
                                                    aria-labelledby="detailModalLabel{{ $asset->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="detailModalLabel{{ $asset->id }}">
                                                                    Asset Details</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <strong>Asset Tagging:</strong>
                                                                        {{ $asset->tagging }}<br>
                                                                        <strong>Jenis Aset:</strong>
                                                                        {{ $asset->jenis_aset }}<br>
                                                                        <strong>Merk:</strong> {{ $asset->merk_name }}<br>
                                                                        <strong>Location:</strong> {{ $asset->lokasi }}<br>
                                                                        <strong>Approval Status:</strong>
                                                                        {{ $asset->approval_status }}<br>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <strong>Serial Number:</strong>
                                                                        {{ $asset->serial_number }}<br>
                                                                        <strong>O365:</strong> {{ $asset->o365 }}<br>
                                                                        <strong>Status:</strong> {{ $asset->status }}<br>
                                                                        <strong>Kondisi:</strong> {{ $asset->kondisi }}<br>
                                                                        <strong>Documentation:</strong>
                                                                        @if($asset->documentation)
                                                                            <a href="{{ asset('storage/' . $asset->documentation) }}"
                                                                                target="_blank">View Documentation</a>
                                                                        @else
                                                                            No documentation available.
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</main>

@section('scripts')
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
@endsection