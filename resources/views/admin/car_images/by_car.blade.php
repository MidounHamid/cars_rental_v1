@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1 class="title">All Images for Car: {{ $car->model }}</h1>
    <a href="{{ route('car_images.index') }}" class="btn-back">← Back to Images</a>

    @if ($images->isEmpty())
        <p>No images found for this car.</p>
    @else
        <div class="image-grid">
            @foreach($images as $image)
                <div class="image-card">
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Car Image">
                    <div class="label">{{ $image->is_primary ? 'Primary' : 'Secondary' }}</div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .title {
        font-size: 28px;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .btn-back {
        display: inline-block;
        margin-bottom: 20px;
        background-color: #3490dc;
        color: white;
        padding: 8px 16px;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .btn-back:hover {
        background-color: #2779bd;
    }

    .image-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
    }

    .image-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        text-align: center;
        transition: transform 0.2s;
    }

    .image-card:hover {
        transform: translateY(-5px);
    }

    .image-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .label {
        padding: 10px;
        font-weight: bold;
        color: #555;
        background-color: #f8f9fa;
    }
</style>
@endsection

