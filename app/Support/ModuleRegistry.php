<?php

namespace App\Support;

class ModuleRegistry
{
    /**
     * Admin modules that can be granted per-role, one row per top-level
     * sidebar menu item (see AdminSidebar.vue) so the Add/Edit Role
     * permissions matrix reads exactly like the sidebar instead of exposing
     * internal route/table names. Keep this in sync when the sidebar's
     * top-level items change.
     */
    public static function all(): array
    {
        return [
            ['key' => 'dashboard',           'name' => 'Dashboard',           'actions' => ['view']],
            ['key' => 'inquiries',           'name' => 'Inquiries',           'actions' => ['view', 'edit', 'delete']],
            ['key' => 'website-management',  'name' => 'Website Management',  'actions' => ['view', 'create', 'edit', 'delete']],
            ['key' => 'global-settings',     'name' => 'Global Settings',     'actions' => ['view', 'create', 'edit', 'delete']],
            ['key' => 'email-smtp-setting',  'name' => 'Email SMTP Setting',  'actions' => ['view', 'edit']],
            ['key' => 'user-management',     'name' => 'User Management',     'actions' => ['view', 'create', 'edit', 'delete']],
            ['key' => 'backups',             'name' => 'Backup',              'actions' => ['view', 'create', 'delete']],
        ];
    }

    /** Resolve a route name to its module key. More specific prefixes are listed before broader ones they'd otherwise be swallowed by. */
    public static function resolveModule(string $routeName): ?string
    {
        $map = [
            'admin.dashboard'         => 'dashboard',

            'admin.inquiries'         => 'inquiries',

            // Website Management menu (About, Services, Gallery, FAQs, Testimonials, Blog)
            'admin.website-settings.about'    => 'website-management',
            'admin.website-settings.gallery'  => 'website-management',
            'admin.services'                  => 'website-management',
            'admin.faqs'                       => 'website-management',
            'admin.testimonials'              => 'website-management',
            'admin.blog-categories'           => 'website-management',
            'admin.blog-comments'             => 'website-management',
            'admin.blog'                      => 'website-management',

            // Global Settings menu (everything else under website-settings, plus Facilities)
            'admin.website-settings.mail'     => 'email-smtp-setting',
            'admin.website-settings'          => 'global-settings',
            'admin.facilities'                => 'global-settings',

            // User Management menu (Users + Roles)
            'admin.users'             => 'user-management',
            'admin.roles'             => 'user-management',

            'admin.backups'           => 'backups',

            // Not linked from the sidebar (no nav item exists for these) — kept
            // mapped to their own keys so they stay super-admin-only rather than
            // falling through to "unrestricted" for every logged-in admin.
            'admin.packages'          => 'packages',
            'admin.package-bookings'  => 'package-bookings',
        ];

        foreach ($map as $prefix => $module) {
            if (str_starts_with($routeName, $prefix)) {
                return $module;
            }
        }

        return null;
    }

    /** Determine the required permission action from HTTP method + route name */
    public static function resolveAction(string $method, string $routeName): string
    {
        if (strtoupper($method) === 'GET') return 'view';
        if (strtoupper($method) === 'DELETE') return 'delete';

        // PATCH/PUT are always edit-level
        if (in_array(strtoupper($method), ['PUT', 'PATCH'])) return 'edit';

        // POST: distinguish store vs settings/reorder/update
        $editPostPatterns = ['.settings', '.reorder', '.update-status', '.update'];
        foreach ($editPostPatterns as $pattern) {
            if (str_contains($routeName, $pattern)) return 'edit';
        }

        return 'create';
    }
}
