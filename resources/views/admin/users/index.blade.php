@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Users List</h2>

    <a href="{{ route('users.create') }}" class="add-btn">Add New User</a>

    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif

    <table class="admin-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Admin</th>
                <th>Address</th>
                <th>Driver License</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? '-' }}</td>
                    <td>{{ $user->is_admin ? 'Yes' : 'No' }}</td>
                    <td>{{ $user->address ?? '-' }}</td>
                    <td>{{ $user->driver_license ?? '-' }}</td>

                    <td>
                        @if($user->image)
                            <img src="{{ asset('storage/' . $user->image) }}" alt="User Image" width="50" height="50" style="border-radius: 50%;">
                        @else
                            <span>No image</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
                             Edit
                        </a>

                        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No users found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-links">
        {{ $users->links() }}
    </div>
</div>
@endsection
