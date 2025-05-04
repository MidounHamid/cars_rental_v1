@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Car Features</h1> <!-- Changed from "Car Specifications" to "Car Features" -->
    <a href="{{ route('car_features.create') }}" class="add-btn">Add New Car Feature</a> <!-- Changed route to 'car_features.create' -->

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Car</th>
                <th>Feature</th> <!-- Changed from "Specification" to "Feature" -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($carFeatures as $item) <!-- Changed from $carSpecifications to $carFeatures -->
                <tr>
                    <td>{{ $item->car->model ?? 'Unknown Car' }}</td>
                    <td>{{ $item->feature->feature ?? 'Unknown Feature' }}</td> <!-- Changed from 'specification' to 'feature' -->
                    <td>
                        <a href="{{ route('car_features.edit', $item->id) }}" class="btn btn-primary btn-sm">Edit</a> <!-- Changed route to 'car_features.edit' -->
                        <form action="{{ route('car_features.destroy', $item->id) }}" method="POST" style="display:inline;"> <!-- Changed route to 'car_features.destroy' -->
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No car features found.</td> <!-- Changed text from "car specifications" to "car features" -->
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
