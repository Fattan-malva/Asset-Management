@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4 fw-bold display-5">Asset History</h1>
    <br>
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <!-- Form to clear history -->
            <form action="{{ route('asset-history.clear') }}" method="POST" class="mb-4" id="clearHistoryForm">
                @csrf
                <button type="submit" class="btn btn-danger" onclick="return confirmClear()">Clear All History</button>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Asset Tagging</th>
                            <th scope="col">Merk</th>
                            <th scope="col">Jenis Aset</th>
                            <th scope="col">Old Holder</th>
                            <th scope="col">New Holder</th>
                            <th scope="col">Changed At</th>
                            <th scope="col">Action</th>
                            <th scope="col">Description</th>
                            <th scope="col">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($history as $assetTagging => $items)
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->asset_tagging }}</td>
                                    <td>{{ $item->merk }}</td>
                                    <td>{{ $item->jenis_aset_old }}</td>
                                    <td>{{ $item->nama_old }}</td>
                                    <td>{{ $item->nama_new }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->changed_at)->format('d-m-Y H:i:s') }}</td>
                                    <td>
                                        @if ($item->action === 'CREATE')
                                            <span class="badge badge-custom bg-success"
                                                style="font-size: 0.8rem; padding: 0.2em 1em; color: black; border-radius: 0.5em;">Handover</span>
                                        @elseif ($item->action === 'UPDATE')
                                            <span class="badge badge-custom bg-warning"
                                                style="font-size: 0.8rem; padding: 0.2em 1em; color: black; border-radius: 0.5em;">Mutasi</span>
                                        @elseif ($item->action === 'DELETE')
                                            <span class="badge badge-custom bg-danger"
                                                style="font-size: 0.8rem; padding: 0.2em 1em; color: black; border-radius: 0.5em;">Return</span>
                                        @else
                                            <span class="badge badge-custom bg-secondary"
                                                style="font-size: 0.8rem; padding: 0.2em 1em; color: black; border-radius: 0.5em;">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->action === 'CREATE')
                                            New asset added. Holder: <span
                                                class="badge badge-custom bg-primary" style="font-size: 0.8rem; padding: 0.2em 1em; color: white; border-radius: 0.5em;">{{ $item->nama_old }}</span>
                                        @elseif ($item->action === 'UPDATE')
                                            Mutation from <span class="badge badge-custom bg-secondary" style="font-size: 0.8rem; padding: 0.2em 1em; color: white; border-radius: 0.5em;">{{ $item->nama_old }}</span>
                                            to <span class="badge badge-custom bg-primary" style="font-size: 0.8rem; padding: 0.2em 1em; color: white; border-radius: 0.5em;">{{ $item->nama_new }}</span>
                                        @elseif ($item->action === 'DELETE')
                                            Asset returned by: <span
                                                class="badge badge-custom bg-secondary" style="font-size: 0.8rem; padding: 0.2em 1em; color: white; border-radius: 0.5em;">{{ $item->nama_old }}</span>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Detail Button -->
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal" 
                                                data-asset="{{ $item->asset_tagging }}" 
                                                data-merk="{{ $item->merk }}"
                                                data-jenis="{{ $item->jenis_aset_old }}"
                                                data-oldholder="{{ $item->nama_old }}"
                                                data-newholder="{{ $item->nama_new }}"
                                                data-changedat="{{ \Carbon\Carbon::parse($item->changed_at)->format('d-m-Y H:i:s') }}"
                                                data-action="{{ $item->action }}">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="9" class="text-center" style="padding: 50px; font-size: 1.2em;">No history found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Asset Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Asset Tagging:</strong> <span id="modalAssetTagging"></span></p>
                <p><strong>Merk:</strong> <span id="modalMerk"></span></p>
                <p><strong>Jenis Aset:</strong> <span id="modalJenisAset"></span></p>
                <p><strong>Old Holder:</strong> <span id="modalOldHolder"></span></p>
                <p><strong>New Holder:</strong> <span id="modalNewHolder"></span></p>
                <p><strong>Changed At:</strong> <span id="modalChangedAt"></span></p>
                <p><strong>Action:</strong> <span id="modalAction"></span></p>
            </div>
            <div class="modal-footer">
                <!-- Print Button -->
                <button type="button" class="btn btn-primary" onclick="printDetail()">Print</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function confirmClear() {
    return confirm("Are you sure you want to delete all asset history records?");
}

document.addEventListener('DOMContentLoaded', function () {
    var detailModal = document.getElementById('detailModal');
    detailModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var assetTagging = button.getAttribute('data-asset');
        var merk = button.getAttribute('data-merk');
        var jenisAset = button.getAttribute('data-jenis');
        var oldHolder = button.getAttribute('data-oldholder');
        var newHolder = button.getAttribute('data-newholder');
        var changedAt = button.getAttribute('data-changedat');
        var action = button.getAttribute('data-action');

        var modalAssetTagging = document.getElementById('modalAssetTagging');
        var modalMerk = document.getElementById('modalMerk');
        var modalJenisAset = document.getElementById('modalJenisAset');
        var modalOldHolder = document.getElementById('modalOldHolder');
        var modalNewHolder = document.getElementById('modalNewHolder');
        var modalChangedAt = document.getElementById('modalChangedAt');
        var modalAction = document.getElementById('modalAction');

        modalAssetTagging.textContent = assetTagging;
        modalMerk.textContent = merk;
        modalJenisAset.textContent = jenisAset;
        modalOldHolder.textContent = oldHolder;
        modalNewHolder.textContent = newHolder;
        modalChangedAt.textContent = changedAt;
        modalAction.textContent = action;
    });
});


function printDetail() {
    // Get the action type from the modal
    var action = document.getElementById('modalAction').textContent.trim();

    // Define the route based on the action
    var route = '';
    if (action === 'CREATE') {
        route = '{{ route('prints.handover') }}';
    } else if (action === 'UPDATE') {
        route = '{{ route('prints.mutation') }}';
    } else if (action === 'DELETE') {
        route = '{{ route('prints.return') }}';
    }

    // Redirect to the appropriate route in a new tab
    if (route) {
        var assetTagging = encodeURIComponent(document.getElementById('modalAssetTagging').textContent);
        var printUrl = route + '?asset_tagging=' + assetTagging;

        // Open the print route in a new tab
        var printWindow = window.open(printUrl, '_blank');

        // Wait for the new window to load, then trigger print
        printWindow.onload = function() {
            printWindow.print();
        };
    } else {
        alert('No matching print template found for this action.');
    }
}


</script>
@endsection
