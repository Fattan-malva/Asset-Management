@extends('layouts.app')

@section('content')
<br>
<br>
<h1 class="mt-4 text-center">Manage Merk</h1>
<br>
<div class="container">
    <div class="row">
        <!-- Create Form -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2>Add New Merk</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('merk.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Merk Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Index Table -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2>Merk List</h2>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($merkes as $merk)
                                <tr>
                                    <td>{{ $merk->name }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm"
                                            onclick="editMerk({{ $merk->id }})">Edit</button>
                                        <form action="{{ route('merk.destroy', $merk->id) }}" method="POST"
                                            style="display:inline;" id="delete-form-{{ $merk->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="confirmDelete({{ $merk->id }})">Delete</button>
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

<!-- Update Modal -->
<div class="modal fade" id="updateMerkModal" tabindex="-1" aria-labelledby="updateMerkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateMerkModalLabel">Update Merk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateMerkForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="update_name" class="form-label">Merk Name</label>
                        <input type="text" class="form-control" id="update_name" name="name" required>
                    </div>

                    <input type="hidden" id="update_merk_id" name="id">

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>


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