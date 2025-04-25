<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('model', 255);

            $table->unsignedBigInteger('car_type_id')->nullable();
            $table->string('city', 100);
            $table->decimal('price_per_day', 10, 2);

            $table->unsignedBigInteger('fuel_types_id');
            $table->enum('transmission', ['Automatic', 'Manual', 'CVT', 'Semi-Automatic'])->nullable();
            $table->tinyInteger('seats')->nullable()->default(5);
            $table->boolean('is_available')->nullable()->default(true);

            $table->unsignedBigInteger('agency_id')->nullable();
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('insurance_id');

            // Add the available_from and available_to columns
            $table->date('available_from')->nullable();
            $table->date('available_to')->nullable();

            // Foreign key constraints
            $table->foreign('car_type_id')->references('id')->on('car_types');
            $table->foreign('fuel_types_id')->references('id')->on('fuel_types');
            $table->foreign('agency_id')->references('id')->on('agencies');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('insurance_id')->references('id')->on('insurances');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
