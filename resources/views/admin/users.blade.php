@extends('admin.layouts.app')

@section('title', 'User Management')

@section('content')

    <div class="container-fluid">
        <h2 class="title mt-3"><i class="fas fa-users"></i> User Management</h2>



        <div class="table-responsive">
            <table id="datatable" class="table table-bordered text-center table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Date Joined</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><span class="badge bg-info">{{ ucfirst($user->role) }}</span></td>
                        <td>{{ date('M d, Y', strtotime($user->date_created)) }}</td>
                        <td>
                            @if(auth()->user()->user_id != $user->user_id)

                                <button class="btn btn-danger btn-sm delete-user" data-id="{{ $user->id }}"><i class="fas fa-trash"></i></button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('js')
    <script>
        document.querySelectorAll('.delete-user').forEach(button => {
            button.addEventListener('click', function () {
                let userId = this.getAttribute('data-id');
                if (confirm('Are you sure you want to delete this user?')) {
                    fetch("{{ route('admin.users.delete') }}", {
                        method: "POST",
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                        body: JSON.stringify({ user_id: userId })
                    }).then(response => response.json()).then(data => {
                        if (data.success) location.reload();
                        else alert('Error deleting user.');
                    });
                }
            });
        });
    </script>
@endpush
