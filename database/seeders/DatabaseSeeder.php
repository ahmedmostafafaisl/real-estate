<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Reference / taxonomy data — small, fixed, curated (not randomly generated).
        $this->call([
            RolePermissionSeeder::class,
            GeoSeeder::class,
            PropertyTaxonomySeeder::class,
            SubscriptionPackageSeeder::class,
            NotificationTemplateSeeder::class,
            SystemSettingSeeder::class,
            CmsContentSeeder::class,
        ]);

        // Heavy, interrelated data — depends on the reference data above.
        $this->call([
            UserAndProviderSeeder::class,   // admins, customers, service_providers, provider_documents, provider_employees
            PropertySeeder::class,          // properties, property_feature_property
            FavoriteSeeder::class,          // favorites
            BillingSeeder::class,           // subscriptions, invoices, payments, commissions
            EngagementSeeder::class,        // inquiries, viewing_requests, reviews, property_reports
            ContactMessageSeeder::class,    // contact_messages
        ]);
    }
}
