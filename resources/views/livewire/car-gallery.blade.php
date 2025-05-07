<div>
<div class="car-image-section">
    <div class="car-image-box">
        @if ($activeImage)
            <img src="{{ asset('storage/' . $activeImage) }}" alt="Car Image" class="car-image main-img">
        @else
            <img src="{{ asset('images/defaultcarimage.png') }}" alt="Default Car Image" class="car-image main-img">
        @endif
        <div class="logo-badge">AZIDCAR</div>
    </div>
    <div class="thumbnail-gallery">
        @foreach ($car->carImages as $image)
            <button type="button" wire:click="selectImage('{{ $image->image_path }}')" style="border:none;background:none;padding:0;margin:0;">
                <img src="{{ asset('storage/' . $image->image_path) }}"
                     alt="{{ $car->brand->brand }} {{ $car->model }}"
                     class="thumbnail @if($activeImage === $image->image_path) active @endif"
                     style="border: 2px solid {{ $activeImage === $image->image_path ? '#080808' : 'transparent' }}; border-radius: 6px; box-sizing: border-box;">
            </button>
        @endforeach
    </div>
</div>
<style>
    .car-image-section {
        position: static;
    }
    .car-image-box {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 12px;
    }
    .main-img {
        width: 700px;
        height: 420px;
        object-fit: cover;
        border-radius: 14px;
        background: #f8f9fa;
        box-shadow: none;
        display: block;
    }
    @media (max-width: 900px) {
        .main-img {
            width: 100%;
            height: 260px;
        }
    }
    @media (min-width: 992px) {
        .car-image-section {
            position: sticky;
            top: 32px;
            z-index: 2;
        }
    }
    .thumbnail-gallery {
        display: flex;
        gap: 8px;
        margin-top: 10px;
    }
    .thumbnail {
        width: 60px;
        height: 40px;
        object-fit: cover;
        cursor: pointer;
        transition: border 0.2s;
    }
    .thumbnail.active {
        border: 2px solid #080808;
        box-shadow: 0 0 0 2px #fff;
    }
</style>
</div> 