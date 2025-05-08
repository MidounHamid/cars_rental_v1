@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="grid-container">
        <!-- Car Details Section -->
        <div class="card">
            <div class="card-header">
                <span class="icon icon-car"></span>
                Vehicle Details
                <!-- <span class="status-badge">{{ strtoupper($notification->booking->car->is_available ? 'Available' : 'Unavailable') }}</span> -->
            </div>
            <div class="card-body">
                <div class="car-image">
                    @if($notification->booking->car->primaryImage)
                        <img src="{{ asset('storage/' . $notification->booking->car->primaryImage->image_path) }}" 
                             alt="{{ $notification->booking->car->brand->brand }} {{ $notification->booking->car->model }}">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" alt="No image available">
                    @endif
                </div>
                
                <h3>{{ $notification->booking->car->brand->brand }} {{ $notification->booking->car->model }}</h3>
                
                <div class="info-row">
                    <span class="icon icon-car"></span>
                    <span class="label">Type:</span>
                    <span class="value">{{ $notification->booking->car->carType->name ?? 'N/A' }}</span>
                </div>
                
                <div class="info-row">
                    <span class="icon icon-car"></span>
                    <span class="label">Transmission:</span>
                    <span class="value">{{ $notification->booking->car->transmission ?? 'N/A' }}</span>
                </div>
                
                <div class="info-row">
                    <span class="icon icon-car"></span>
                    <span class="label">Fuel Type:</span>
                    <span class="value">{{ $notification->booking->car->fuelType->fuel_type ?? 'N/A' }}</span>
                </div>
                
                <div class="info-row">
                    <span class="icon icon-user"></span>
                    <span class="label">Seats:</span>
                    <span class="value">{{ $notification->booking->car->seats }} Seats</span>
                </div>
                
                <div class="info-row">
                    <span class="icon icon-location"></span>
                    <span class="label">Location:</span>
                    <span class="value">{{ $notification->booking->car->city }}</span>
                </div>
                
                <div class="info-row">
                    <span class="icon icon-price"></span>
                    <span class="label">Price per Day:</span>
                    <span class="value">${{ number_format($notification->booking->car->price_per_day, 2) }}</span>
                </div>
            </div>
        </div>
        
        <!-- Client Details Section -->
        <div class="card">
            <div class="card-header">
                <span class="icon icon-user"></span>
                Customer Information
            </div>
            <div class="card-body">
                <div class="info-row">
                    <span class="icon icon-user"></span>
                    <span class="label">Full Name:</span>
                    <span class="value">{{ $notification->booking->user->name }}</span>
                </div>
                
                <div class="info-row">
                    <span class="icon icon-phone"></span>
                    <span class="label">Phone:</span>
                    <span class="value">{{ $notification->booking->user->phone ?? 'N/A' }}</span>
                </div>
                
                <div class="info-row">
                    <span class="icon icon-email"></span>
                    <span class="label">Email:</span>
                    <span class="value">{{ $notification->booking->user->email }}</span>
                </div>
                
                <div class="info-row">
                    <span class="icon icon-location"></span>
                    <span class="label">Address:</span>
                    <span class="value">{{ $notification->booking->user->address ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
        
        <!-- Booking Details Section -->
        <div class="card">
            <div class="card-header">
                <span class="icon icon-calendar"></span>
                Booking Details
            </div>
            <div class="card-body">
                <div class="info-row">
                    <span class="icon icon-calendar"></span>
                    <span class="label">Pick-up Date:</span>
                    <span class="value">{{ $notification->booking->start_date->format('d M Y') }} at {{ $notification->booking->start_time }}</span>
                </div>
                
                <div class="info-row">
                    <span class="icon icon-calendar"></span>
                    <span class="label">Return Date:</span>
                    <span class="value">{{ $notification->booking->end_date->format('d M Y') }} at {{ $notification->booking->end_time }}</span>
                </div>
                
                <div class="info-row">
                    <span class="icon icon-status"></span>
                    <span class="label">Status:</span>
                    <span class="value">{{ ucfirst($notification->booking->status) }}</span>
                </div>
                
                <div class="info-row">
                    <span class="icon icon-duration"></span>
                    <span class="label">Duration:</span>
                    <span class="value">{{ $notification->booking->start_date->diffInDays($notification->booking->end_date) }} Days</span>
                </div>
                
                <div class="info-row">
                    <span class="icon icon-price"></span>
                    <span class="label">Total Price:</span>
                    <span class="value">${{ number_format($notification->booking->total_price ?? 0, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .container {
        padding: 2rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .card-header {
        background: #f8f9fa;
        padding: 1.5rem;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 600;
        color: #2d3748;
    }

    .card-body {
        padding: 1.5rem;
    }

    .car-image {
        width: 100%;
        height: 200px;
        overflow: hidden;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }

    .car-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .info-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
        color: #4a5568;
    }

    .icon {
        width: 1.5rem;
        height: 1.5rem;
        background-color: #e2e8f0;
        mask-size: contain;
        mask-repeat: no-repeat;
        mask-position: center;
    }

    .label {
        font-weight: 500;
        min-width: 120px;
    }

    .value {
        color: #2d3748;
    }

    .status-badge {
        margin-left: auto;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 500;
        background-color: #e2e8f0;
        color: #4a5568;
    }

    .status-badge.available {
        background-color: #c6f6d5;
        color: #2f855a;
    }

    .status-badge.unavailable {
        background-color: #fed7d7;
        color: #c53030;
    }

    .icon-car {
        -webkit-mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M8 7h8m-8 5h8m-4 5v-5m-4 0v5m-4-11h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2z' /%3E%3C/svg%3E");
        mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M8 7h8m-8 5h8m-4 5v-5m-4 0v5m-4-11h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2z' /%3E%3C/svg%3E");
    }
    
    .icon-user {
        -webkit-mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z' /%3E%3C/svg%3E");
        mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z' /%3E%3C/svg%3E");
    }
    
    .icon-calendar {
        -webkit-mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z' /%3E%3C/svg%3E");
        mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z' /%3E%3C/svg%3E");
    }
    
    .icon-location {
        -webkit-mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z' /%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 11a3 3 0 11-6 0 3 3 0 016 0z' /%3E%3C/svg%3E");
        mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z' /%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 11a3 3 0 11-6 0 3 3 0 016 0z' /%3E%3C/svg%3E");
    }
    
    .icon-phone {
        -webkit-mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z' /%3E%3C/svg%3E");
        mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z' /%3E%3C/svg%3E");
    }
    
    .icon-email {
        -webkit-mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z' /%3E%3C/svg%3E");
        mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z' /%3E%3C/svg%3E");
    }
    
    .icon-price {
        -webkit-mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z' /%3E%3C/svg%3E");
        mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z' /%3E%3C/svg%3E");
    }
    
    .icon-status {
        -webkit-mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' /%3E%3C/svg%3E");
        mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' /%3E%3C/svg%3E");
    }
    
    .icon-duration {
        -webkit-mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' /%3E%3C/svg%3E");
        mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' /%3E%3C/svg%3E");
    }
    
    @media (max-width: 768px) {
        .grid-container {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection 