<?php

namespace App\Support;

class DashboardNav
{
    protected static function icon(string $name): string
    {
        $paths = [
            'grid' => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>',
            'building' => '<rect x="4" y="2" width="16" height="20" rx="1"/><line x1="9" y1="7" x2="9" y2="7.01"/><line x1="15" y1="7" x2="15" y2="7.01"/><line x1="9" y1="12" x2="9" y2="12.01"/><line x1="15" y1="12" x2="15" y2="12.01"/>',
            'message' => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
            'calendar' => '<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>',
            'mail' => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 6-10 7L2 6"/>',
            'card' => '<rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/>',
            'receipt' => '<path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"/>',
            'percent' => '<line x1="19" y1="5" x2="5" y2="19"/><circle cx="6.5" cy="6.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/>',
            'chart' => '<line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>',
            'users' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
            'bell' => '<path d="M6 8a6 6 0 1 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>',
            'settings' => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.6 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.6a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09A1.65 1.65 0 0 0 15 4.6a1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1Z"/>',
            'shield' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/>',
            'layers' => '<polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/>',
            'globe' => '<circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10Z"/>',
            'star' => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>',
            'file' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><polyline points="14 2 14 8 20 8"/>',
            'activity' => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>',
            'database' => '<ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>',
            'key' => '<path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/>',
        ];

        return '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">'.($paths[$name] ?? $paths['grid']).'</svg>';
    }

    public static function provider(): array
    {
        return [
            __('dashboard.overview') => [
                ['label' => __('dashboard.nav_provider_dashboard'), 'route' => 'provider.dashboard', 'url' => route('provider.dashboard'), 'icon' => self::icon('grid')],
            ],
            __('dashboard.nav_business') => [
                ['label' => __('dashboard.nav_my_properties'), 'route' => 'provider.properties.*', 'url' => route('provider.properties.index'), 'icon' => self::icon('building')],
                ['label' => __('dashboard.nav_customer_requests'), 'route' => 'provider.inquiries.*', 'url' => route('provider.inquiries.index'), 'icon' => self::icon('message')],
                ['label' => __('dashboard.nav_viewing_appointments'), 'route' => 'provider.viewings.*', 'url' => route('provider.viewings.index'), 'icon' => self::icon('calendar')],
                ['label' => __('dashboard.nav_messages'), 'route' => 'provider.messages', 'url' => route('provider.messages'), 'icon' => self::icon('mail')],
            ],
            __('dashboard.nav_billing') => [
                ['label' => __('dashboard.nav_subscription'), 'route' => 'provider.subscription', 'url' => route('provider.subscription'), 'icon' => self::icon('card')],
                ['label' => __('dashboard.nav_payments_invoices'), 'route' => 'provider.invoices.*', 'url' => route('provider.invoices.index'), 'icon' => self::icon('receipt')],
                ['label' => __('dashboard.nav_commissions'), 'route' => 'provider.commissions', 'url' => route('provider.commissions'), 'icon' => self::icon('percent')],
            ],
            __('dashboard.nav_insights') => [
                ['label' => __('dashboard.nav_statistics'), 'route' => 'provider.statistics', 'url' => route('provider.statistics'), 'icon' => self::icon('chart')],
            ],
            __('dashboard.nav_office') => [
                ['label' => __('dashboard.nav_office_profile'), 'route' => 'provider.profile', 'url' => route('provider.profile'), 'icon' => self::icon('building')],
                ['label' => __('dashboard.nav_employees'), 'route' => 'provider.employees.*', 'url' => route('provider.employees.index'), 'icon' => self::icon('users')],
                ['label' => __('dashboard.nav_notifications'), 'route' => 'provider.notifications', 'url' => route('provider.notifications'), 'icon' => self::icon('bell')],
                ['label' => __('dashboard.nav_account_settings'), 'route' => 'provider.settings', 'url' => route('provider.settings'), 'icon' => self::icon('settings')],
            ],
        ];
    }

    public static function admin(): array
    {
        return [
            __('dashboard.overview') => [
                ['label' => __('dashboard.nav_admin_dashboard'), 'route' => 'admin.dashboard', 'url' => route('admin.dashboard'), 'icon' => self::icon('grid')],
            ],
            __('dashboard.nav_listings') => [
                ['label' => __('dashboard.nav_properties'), 'route' => 'admin.properties.*', 'url' => route('admin.properties.index'), 'icon' => self::icon('building')],
                ['label' => __('dashboard.nav_categories_types'), 'route' => 'admin.taxonomy', 'url' => route('admin.taxonomy'), 'icon' => self::icon('layers')],
                ['label' => __('dashboard.nav_cities_districts'), 'route' => 'admin.geo', 'url' => route('admin.geo'), 'icon' => self::icon('globe')],
            ],
            __('dashboard.nav_people') => [
                ['label' => __('dashboard.nav_customers'), 'route' => 'admin.users', 'url' => route('admin.users'), 'icon' => self::icon('users')],
                ['label' => __('dashboard.nav_service_providers'), 'route' => 'admin.providers.*', 'url' => route('admin.providers.index'), 'icon' => self::icon('shield')],
                ['label' => __('dashboard.nav_roles_permissions'), 'route' => 'admin.roles', 'url' => route('admin.roles'), 'icon' => self::icon('key')],
            ],
            __('dashboard.nav_commerce') => [
                ['label' => __('dashboard.nav_subscriptions'), 'route' => 'admin.subscriptions', 'url' => route('admin.subscriptions'), 'icon' => self::icon('card')],
                ['label' => __('dashboard.nav_payments_invoices'), 'route' => 'admin.payments', 'url' => route('admin.payments'), 'icon' => self::icon('receipt')],
                ['label' => __('dashboard.nav_commissions'), 'route' => 'admin.commissions', 'url' => route('admin.commissions'), 'icon' => self::icon('percent')],
            ],
            __('dashboard.nav_engagement') => [
                ['label' => __('dashboard.nav_viewing_requests'), 'route' => 'admin.viewing-requests', 'url' => route('admin.viewing-requests'), 'icon' => self::icon('calendar')],
                ['label' => __('dashboard.nav_reviews_reports'), 'route' => 'admin.reviews', 'url' => route('admin.reviews'), 'icon' => self::icon('star')],
                ['label' => __('dashboard.nav_notifications'), 'route' => 'admin.notifications', 'url' => route('admin.notifications'), 'icon' => self::icon('bell')],
            ],
            __('dashboard.nav_content') => [
                ['label' => __('dashboard.nav_cms_pages'), 'route' => 'admin.cms', 'url' => route('admin.cms'), 'icon' => self::icon('file')],
            ],
            __('dashboard.nav_system') => [
                ['label' => __('dashboard.nav_activity_logs'), 'route' => 'admin.activity', 'url' => route('admin.activity'), 'icon' => self::icon('activity')],
                ['label' => __('dashboard.nav_backup_management'), 'route' => 'admin.backups', 'url' => route('admin.backups'), 'icon' => self::icon('database')],
                ['label' => __('dashboard.nav_system_settings'), 'route' => 'admin.settings', 'url' => route('admin.settings'), 'icon' => self::icon('settings')],
            ],
        ];
    }
}
