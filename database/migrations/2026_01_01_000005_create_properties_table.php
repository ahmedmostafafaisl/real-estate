<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_provider_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_category_id')->constrained();
            $table->foreignId('property_type_id')->constrained();
            $table->foreignId('city_id')->constrained();
            $table->foreignId('district_id')->nullable()->constrained();

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->enum('listing_type', ['sale', 'rent']);
            $table->decimal('price', 14, 2);
            $table->decimal('area_sqm', 10, 2)->nullable();
            $table->unsignedTinyInteger('bedrooms')->nullable();
            $table->unsignedTinyInteger('bathrooms')->nullable();
            $table->json('dynamic_attributes')->nullable(); // type-specific values
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->enum('status', ['draft', 'pending', 'published', 'sold', 'rented', 'expired', 'rejected'])
                ->default('draft');
            $table->text('rejection_reason')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->dateTime('published_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->unsignedInteger('views_count')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'listing_type']);
            $table->index(['city_id', 'property_type_id']);
        });

        Schema::create('property_feature_property', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_feature_id')->constrained()->cascadeOnDelete();
        });

        Schema::create('property_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->enum('type', ['image', 'video', 'floor_plan', 'virtual_tour'])->default('image');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });

        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'property_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorites');
        Schema::dropIfExists('property_images');
        Schema::dropIfExists('property_feature_property');
        Schema::dropIfExists('properties');
    }
};
