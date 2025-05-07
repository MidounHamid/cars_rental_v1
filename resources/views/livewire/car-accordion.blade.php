<div>
<div class="accordion">
    <div class="accordion-item">
        <button type="button" class="accordion-header" wire:click="toggleSection('description')">
            <span class="accordion-title">DESCRIPTION</span>
            <span class="accordion-icon">
                @if($openSection === 'description')
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="transform:rotate(180deg);transition:transform 0.2s;"><polyline points="6 9 12 15 18 9"></polyline></svg>
                @else
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="transition:transform 0.2s;"><polyline points="6 9 12 15 18 9"></polyline></svg>
                @endif
            </span>
        </button>
        @if($openSection === 'description')
            <div class="accordion-content">
                <p>{{ $car->description ?? 'No description available.' }}</p>
            </div>
        @endif
    </div>
    <div class="accordion-item">
        <button type="button" class="accordion-header" wire:click="toggleSection('features')">
            <span class="accordion-title">FEATURES</span>
            <span class="accordion-icon">
                @if($openSection === 'features')
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="transform:rotate(180deg);transition:transform 0.2s;"><polyline points="6 9 12 15 18 9"></polyline></svg>
                @else
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="transition:transform 0.2s;"><polyline points="6 9 12 15 18 9"></polyline></svg>
                @endif
            </span>
        </button>
        @if($openSection === 'features')
            <div class="accordion-content">
                <ul class="features-list">
                    @foreach ($car->features as $feature)
                        <li> {{ $feature->feature }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
<style>
    .accordion {
        margin-top: 18px;
    }
    .accordion-item {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        margin-bottom: 12px;
        box-shadow: none;
        overflow: hidden;
    }
    .accordion-header {
        width: 100%;
        background: none;
        border: none;
        outline: none;
        text-align: left;
        padding: 12px 16px;
        font-size: 15px;
        font-weight: normal;
        color: #444;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        transition: color 0.2s;
    }
    .accordion-header:hover {
        color: #080808;
        background: none;
    }
    .accordion-title {
        letter-spacing: 0.5px;
    }
    .accordion-icon {
        font-size: 22px;
        margin-left: 8px;
        display: flex;
        align-items: center;
        transition: transform 0.2s;
    }
    .accordion-content {
        padding: 16px 18px 18px 18px;
        font-size: 15px;
        color: #333;
        background: #fff;
        border-top: 1px solid #e2e8f0;
    }
    .features-list {
        padding-left: 18px;
        margin: 0;
    }
</style>
</div> 