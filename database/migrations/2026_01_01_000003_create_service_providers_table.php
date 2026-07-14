<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_providers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('office_name');
            $table->enum('provider_type', ['agency', 'broker', 'owner', 'developer']);
            $table->string('commercial_register_no')->nullable();
            $table->string('license_no')->nullable();
            $table->foreignId('city_id')->nullable()->constrained();
            $table->text('address')->nullable();
            $table->string('logo')->nullable();
            $table->text('bio')->nullable();
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->dateTime('verified_at')->nullable();
            $table->decimal('commission_rate', 5, 2)->default(2.00);
            $table->timestamps();
        });

        Schema::create('provider_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_provider_id')->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->string('file_path');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });

        Schema::create('provider_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_provider_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('job_title')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provider_employees');
        Schema::dropIfExists('provider_documents');
        Schema::dropIfExists('service_providers');
    }
};
