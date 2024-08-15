@extends('layouts.app')

@section('content')
<br>
<br>
<br>
<br>
<div id="user" class="container">
    <h1 class="mt-4 text-center">List User</h1>
    <p class="animate__animated animate__fadeInUp text-center">In the dynamic world of inventory management, reliability
        and exceptional service are paramount. At Management Inventory, we pride ourselves on providing top-notch
        inventory
        management solutions that cater to all your business needs. We ensure that your inventory are handled
        efficiently, securely, and on schedule, every time.

        .</p>

    <br>
    <br>
    <br>
    <div class="mb-3">
        <a href="{{ route('user.create') }}" class="btn btn-lg btn-success"><i class="bi bi-cloud-plus-fill"></i>
            Create</a>
    </div>

    <table id="userTable" class="table table-striped table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>No.</th>
                <th>Userame</th>
                <th>Password</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            @forelse($users as $user)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->password }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <a href="{{ route('user.edit', ['id' => $user->id]) }}" class="btn btn-sm btn-primary text">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <form action="{{ route('user.delete', ['id' => $user->id]) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure you want to delete this user?')">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No data</td>
                </tr>
            @endforelse
        </tbody>

    </table>

    <br>
    <br>
    <br>
</div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#userTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/English.json"
                }
            });
        });
    </script>
@endpush