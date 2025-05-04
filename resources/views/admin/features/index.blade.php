@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h1> Features</h1>
    <a href="{{ route('features.create') }}" class="add-btn">Add New Feature</a>
    <table>
        <thead>
            <tr>
                <th>Feature</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($features as $feature)
                <tr>
                    <td>{{ $feature->feature ?? 'Unknown Feature' }}</td>
                    <td>
                        <a href="{{ route('features.edit', $feature->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('features.destroy', $feature->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this feature?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No car features found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
