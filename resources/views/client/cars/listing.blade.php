<x-app-layout>


    <!-- Car Listing Section -->
    <section class="car-listing-section">
        <div class="container">
            <h2 class="listing-title">Available Cars</h2>
            <div class="car-grid">
                @if ($cars->isEmpty())
                    <p>No cars available at the moment.</p>
                @else
                    @foreach ($cars as $car)
                        <div class="car-card">
                            @php
                                $primaryImage = $car->carImages->firstWhere('is_primary', true);
                            @endphp

                            @if ($primaryImage)
                                <img src="{{ asset('storage/' . $primaryImage->image_path) }}" alt="{{ $car->model }}" class="car-image">
                            @else
                                <img src="{{ asset('storage/defaultcarimage.png') }}" alt="Default Image" class="car-image">
                            @endif

                            <h3 class="car-model">{{ $car->brand->brand }} -- {{ $car->model }}</h3>
                            <ul class="features-list">
                                <li>{{ $car->seats }} Seats</li>
                                <li>{{ $car->fuelType->type }} Fuel</li>
                                <li>{{ $car->carType->type }} Type</li>
                            </ul>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Pagination Links -->
            <div class="pagination">
                {{ $cars->links() }}  <!-- Laravel pagination links -->
            </div>
        </div>
    </section>
</x-app-layout>
