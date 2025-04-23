@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h1>Agencies</h1>
    <a href="{{ route('agencies.create') }}" class="add-btn">Add Agency</a>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>City</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Logo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($agencies as $agencie)
                <tr>
                    <td>{{ $agencie->name }}</td>
                    <td>{{ $agencie->city }}</td>
                    <td>{{ $agencie->address }}</td>
                    <td>{{ $agencie->phone }}</td>
                    <td>
                        @if ($agencie->logo)
                            <img src="{{ asset('storage/' . $agencie->logo) }}" alt="{{ $agencie->name }}" style="width: 50px; height: 50px; border-radius: 50%;">
                        @else
                            <span>No Logo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('agencies.edit', $agencie->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('agencies.destroy', $agencie->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this agency?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No agencies found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
