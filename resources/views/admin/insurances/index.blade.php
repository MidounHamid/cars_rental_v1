@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h1>Insurance</h1>
    <a href="{{ route('insurances.create') }}" class="add-btn">Add Insurance</a>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price per Day</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($insurances as $insurance)
                <tr>
                    <td>{{ $insurance->name }}</td>
                    <td>{{ $insurance->description }}</td>
                    <td>{{ $insurance->price_per_day }}</td>
                    <td>
                        <a href="{{ route('insurance.edit', $insurance->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('insurance.destroy', $insurance->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this insurance?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No insurance found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
