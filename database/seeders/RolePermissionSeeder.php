<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'users.view', 'users.manage',
            'properties.view', 'properties.approve', 'properties.manage',
            'subscriptions.view', 'subscriptions.manage',
            'payments.view', 'payments.refund',
            'commissions.view', 'commissions.manage',
            'cms.view', 'cms.publish',
            'settings.view', 'settings.manage',
            'roles.manage',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions($permissions);

        Role::firstOrCreate(['name' => 'service_provider', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);

        $support = Role::firstOrCreate(['name' => 'support_agent', 'guard_name' => 'web']);
        $support->syncPermissions(['users.view', 'properties.view', 'payments.view']);

        $finance = Role::firstOrCreate(['name' => 'finance_officer', 'guard_name' => 'web']);
        $finance->syncPermissions(['payments.view', 'payments.refund', 'commissions.view', 'commissions.manage']);
    }
}
