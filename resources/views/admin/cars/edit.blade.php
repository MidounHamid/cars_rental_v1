@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Modifier la voiture</h2>
    <form action="{{ route('cars.update', $car->id) }}" method="POST" class="agency-form">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="model">Modèle</label>
                <input type="text" name="model" class="form-input" value="{{ old('model', $car->model) }}">
                @error('model')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="city">Ville</label>
                <input type="text" name="city" class="form-input" value="{{ old('city', $car->city) }}">
                @error('city')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="price_per_day">Prix / jour</label>
                <input type="number" step="0.01" name="price_per_day" class="form-input" value="{{ old('price_per_day', $car->price_per_day) }}">
                @error('price_per_day')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="seats">Places</label>
                <input type="number" name="seats" class="form-input" value="{{ old('seats', $car->seats) }}">
                @error('seats')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="transmission">Transmission</label>
                <select name="transmission" class="form-input">
                    <option value="">Choisir...</option>
                    @foreach(['Automatic', 'Manual', 'CVT', 'Semi-Automatic'] as $option)
                        <option value="{{ $option }}" {{ old('transmission', $car->transmission) === $option ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
                @error('transmission')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="is_available">Disponible</label>
                <select name="is_available" class="form-input">
                    <option value="1" {{ old('is_available', $car->is_available) == true ? 'selected' : '' }}>Oui</option>
                    <option value="0" {{ old('is_available', $car->is_available) == false ? 'selected' : '' }}>Non</option>
                </select>
            </div>
        </div>

        {{-- Sélections des clés étrangères --}}
        @foreach (['car_type_id' => 'Type', 'fuel_types_id' => 'Carburant', 'agency_id' => 'Agence', 'brand_id' => 'Marque', 'insurance_id' => 'Assurance'] as $name => $label)
            <div class="form-group">
                <label for="{{ $name }}">{{ $label }}</label>
                <select name="{{ $name }}" class="form-input">
                    <option value="">Choisir...</option>
                    @foreach($$name as $item)
                        <option value="{{ $item->id }}" {{ old($name, $car->$name) == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                    @endforeach
                </select>
                @error($name)
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        @endforeach

        <div class="form-footer">
            <button type="submit" class="add-btn">Mettre à jour</button>
            <a href="{{ route('cars.index') }}" class="cancel-btn">Annuler</a>
        </div>
    </form>
</div>
@endsection
