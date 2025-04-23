@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h1>Brands</h1>
    <a href="{{ route('brands.create') }}" class="add-btn">Add Brand</a>
    <table>
        <thead>
            <tr>
                <th>Brand Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($brands as $brand)
                <tr>
                    <td>{{ $brand->brand }}</td>
                    <td>
                        <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this brand?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No brands found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
