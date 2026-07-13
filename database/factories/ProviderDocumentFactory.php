<?php

namespace Database\Factories;

use App\Models\ProviderDocument;
use App\Models\ServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProviderDocumentFactory extends Factory
{
    protected $model = ProviderDocument::class;

    public function definition(): array
    {
        $type = fake()->randomElement(['commercial_register', 'license', 'id_proof', 'tax_certificate']);

        return [
            'service_provider_id' => ServiceProvider::factory(),
            'type' => $type,
            'file_path' => "provider-documents/{$type}-" . fake()->uuid() . '.pdf',
            'status' => fake()->randomElement(['pending', 'approved', 'approved', 'rejected']),
        ];
    }
}
