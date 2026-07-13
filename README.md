# Keystone dashboards — Blade + Alpine.js

Server-rendered Provider and Admin dashboards, matching Sections 9 and 10 of the spec,
wired to your real Eloquent models (no mock data). Styled with Tailwind + Alpine via CDN,
so there's no npm build step required to see it working.

## 1. Copy files in

Everything here maps 1:1 onto your existing project structure — copy over, no renaming:

```
app/Support/DashboardNav.php                    → new
app/Http/Controllers/Web/**                      → new (Provider/*, Admin/*, Auth/LoginController)
app/Models/ServiceProvider.php                   → replaces yours (adds notification_preferences)
database/migrations/2026_07_13_160000_*.php      → new
resources/views/**                               → new (components/, provider/, admin/, auth/)
routes/web.php                                   → replaces yours
```

## 2. Migrate

```bash
php artisan migrate
```

This just adds one column (`service_providers.notification_preferences`) — everything else
reuses tables from the backend scaffold you already have.

## 3. Make sure you have a logged-in-able admin and provider

If you don't already have test accounts:

```bash
php artisan tinker
>>> $admin = App\Models\User::create(['name'=>'Admin','email'=>'admin@keystone.io','password'=>bcrypt('password'),'user_type'=>'admin']);
>>> $admin->assignRole('admin');

>>> $u = App\Models\User::create(['name'=>'Ahmed Faisal','email'=>'ahmed@alnakhil.sa','password'=>bcrypt('password'),'user_type'=>'service_provider']);
>>> $u->assignRole('service_provider');
>>> $provider = App\Models\ServiceProvider::create(['user_id'=>$u->id,'office_name'=>'Alnakhil Realty','provider_type'=>'agency','city_id'=>1,'verification_status'=>'verified','commission_rate'=>2.0]);
```

## 4. Visit it

```
/login              → session-based login (redirects by role)
/provider/dashboard  → Provider console
/admin/dashboard     → Admin console
```

## What's real vs. what's a stand-in

- **All data is live** — every table, stat, and list queries your actual models. Creating
  a listing, approving it as admin, marking it sold, and seeing the commission appear are
  all real writes, not mocked.
- **Messages** (`provider/messages`) surfaces inquiries as conversation threads. There's no
  dedicated messages table yet — sending a reply doesn't persist. Worth a `messages` table
  + broadcasting if in-app chat becomes a real requirement rather than "inquiries with replies."
- **Activity logs** and **Backups** read from `spatie/laravel-activitylog` and
  `spatie/laravel-backup` respectively. Neither package is in your `composer.json` yet — the
  pages render an honest empty state with the install command until you add them.
- **Notification preferences** (provider side) are stored as a JSON override on
  `service_providers`, layered on top of the admin's global `NotificationTemplate` defaults.

## Design system

Same tokens as the React mockups from earlier in this build (ink sidebar, brass accent,
teal secondary, Fraunces headers, IBM Plex Mono for numbers) so the Blade version and the
React mockups read as the same product. The arch/lifecycle indicator on property rows is
the same signature element — 5 segments filling by status, "crumbling" for Expired.

## Moving off the CDN later

Tailwind and Alpine are loaded via `<script src>` in `components/dashboard-layout.blade.php`
for zero-build-step convenience. Your project already has `tailwind.config.js` and Vite
configured — when you're ready, move the theme extension from the `<script>tailwind.config`
block into `tailwind.config.js`, swap the CDN tags for `@vite(...)`, and run `npm run build`.
No Blade or controller code needs to change.
