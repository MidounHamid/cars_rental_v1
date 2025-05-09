@extends('admin.layouts.app')

@section('content')
    <div class="table-container">
        <h2>Create New Review</h2>
        <form action="{{ route('reviews.store') }}" method="POST" class="review-form" enctype="multipart/form-data">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="user_id">User</label>
                    <select name="user_id" id="user_id" class="form-input" required>
                        <option value="">Select User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="car_id">Car</label>
                    <select name="car_id" id="car_id" class="form-input" required>
                        <option value="">Select Car</option>
                        @foreach ($cars as $car)
                            <option value="{{ $car->id }}">{{ $car->model }}</option>
                        @endforeach
                    </select>
                    @error('car_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="rating">Rating</label>
                    <input type="number" name="rating" id="rating" class="form-input" min="1" max="5"
                        value="{{ old('rating') }}">
                    @error('rating')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="comment">Comment</label>
                    <textarea name="comment" id="comment" class="form-input">{{ old('comment') }}</textarea>
                    @error('comment')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="file">File Upload (optional)</label>
                    <input type="file" name="file" id="file" class="form-input">
                    @error('file')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-footer">
                <button type="submit" class="add-btn">Create Review</button>
                <a href="{{ route('reviews.index') }}" class="cancel-btn">Cancel</a>
            </div>
        </form>
    </div>
@endsection
