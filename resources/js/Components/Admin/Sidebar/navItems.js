// Sidebar navigation tree. Kept in a plain module so `activeRoute.js` can read
// every route the menu links to when resolving the active entry.
export const navItems = [
    // ── Dashboard ──────────────────────────────────────────────────────────
    {
        name: 'Dashboard',
        route: 'admin.dashboard',
        icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>`,
    },

    // ── Inquiries ───────────────────────────────────────────────────────────
    {
        name: 'Inquiries',
        route: 'admin.inquiries.index',
        module: 'inquiries',
        icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>`,
        children: [
            { name: 'List',              route: 'admin.inquiries.index' },
            // { name: 'View & Make Reply', route: null },
        ],
    },

    // ── Appointments ─────────────────────────────────────────────────────────
    {
        name: 'Appointments',
        route: 'admin.appointments.index',
        module: 'appointments',
        icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2" stroke-width="2"/><path stroke-linecap="round" stroke-width="2" d="M16 2v4M8 2v4M3 10h18"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 16 2 2 4-4"/></svg>`,
    },

    // ── Patients ────────────────────────────────────────────────────────────
    {
        name: 'Patients',
        route: 'admin.patients.index',
        module: 'patients',
        icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14c-4.42 0-8 1.79-8 4v2h16v-2c0-2.21-3.58-4-8-4z"/></svg>`,
    },

    // ── Doctor Dashboard (Doctor role) ─────────────────────────────────────
    {
        name: 'My Schedule',
        route: 'admin.doctor-dashboard.index',
        module: 'doctor-dashboard',
        icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2"/><circle cx="12" cy="12" r="9" stroke-width="2"/></svg>`,
    },

    // ── Operator (Operator role) ────────────────────────────────────────────
    {
        name: 'Operator',
        route: 'admin.operator.dashboard',
        module: 'operator-dashboard',
        icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
        children: [
            { name: 'Dashboard',        route: 'admin.operator.dashboard' },
            { name: 'Book Appointment', route: 'admin.operator.book' },
        ],
    },

    // ── Website Management ──────────────────────────────────────────────────
    {
        name: 'Website Management',
        route: null,
        module: 'website-management',
        icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>`,
        children: [
            { name: 'About Settings', route: 'admin.website-settings.about.edit' },
            { name: 'Contact Settings', route: 'admin.website-settings.contact.edit' },
            { name: 'History Settings', route: 'admin.website-settings.history.edit' },
            { name: 'Achievements Settings', route: 'admin.website-settings.achievements.edit' },
            { name: 'Management Team', route: 'admin.management-members.index' },
            { name: 'Services',       route: 'admin.services.index' },
            { name: 'Doctors',        route: 'admin.doctors.index' },
            { name: 'Doctor Specializations', route: 'admin.doctor-specializations.index' },
            { name: 'Packages',       route: 'admin.packages.index' },
            { name: 'Gallery',        route: 'admin.website-settings.gallery.index' },
            { name: "FAQ's",          route: 'admin.faqs.index' },
            { name: 'Testimonials',   route: 'admin.testimonials.index' },
            { name: 'Awards',         route: 'admin.awards.index' },
            { name: 'Blog Category',  route: 'admin.blog-categories.index' },
            { name: 'Blog Posts',     route: 'admin.blog.index' },
            { name: 'Pages',          route: 'admin.pages.index' },
        ],
    },

    // ── Global Settings ─────────────────────────────────────────────────────
    {
        name: 'Global Settings',
        route: 'admin.website-settings.sliders.index',
        module: 'global-settings',
        icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>`,
        children: [
            { name: 'Hero Slider',       route: 'admin.website-settings.sliders.index' },
            { name: 'Header Settings',   route: 'admin.website-settings.header.edit' },
            { name: 'Footer Settings',   route: 'admin.website-settings.footer.edit' },
            { name: 'About Section',     route: 'admin.website-settings.global-about.edit' },
            { name: 'Why Choose Us',     route: 'admin.website-settings.why-choose-us.edit' },
            { name: 'Languages',         route: 'admin.website-settings.languages.index' },

            { name: 'Email Notifications', route: 'admin.website-settings.email-notifications.edit' },
            // { name: 'Room Features',     route: null },
            // { name: 'Social Media',      route: null },
            // { name: 'SEO Settings',      route: null },
            // { name: 'General Settings',  route: null },
        ],
    },

    // ── Email SMTP Setting ──────────────────────────────────────────────────
    {
        name: 'Email SMTP Setting',
        route: 'admin.website-settings.mail.edit',
        module: 'email-smtp-setting',
        icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>`,
    },

    // ── User Management ─────────────────────────────────────────────────────
    {
        name: 'User Management',
        route: 'admin.users.index',
        module: 'user-management',
        icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M23 21v-2a4 4 0 00-3-3.87"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3.13a4 4 0 010 7.75"/></svg>`,
        children: [
            { name: 'Users',    route: 'admin.users.index' },
            { name: 'Add User', route: 'admin.users.create' },
            { name: 'Roles',    route: 'admin.roles.index' },
            { name: 'Add Role', route: 'admin.roles.create' },
        ],
    },

    // ── Backup ──────────────────────────────────────────────────────────────
    {
        name: 'Backup',
        route: 'admin.backups.index',
        module: 'backups',
        icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17l4 4 4-4m-4-5v9"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.88 18.09A5 5 0 0018 9h-1.26A8 8 0 103 16.29"/></svg>`,
    },
];

export default navItems;
