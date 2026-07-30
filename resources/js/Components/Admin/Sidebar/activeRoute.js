import navItems from './navItems';

// Every route the sidebar links to. A page that has its own menu entry must never
// be claimed by another entry's group pattern — e.g. on `admin.users.create`
// only "Add User" lights up, not "Users".
const linkedRoutes = new Set();
for (const item of navItems) {
    if (item.route) linkedRoutes.add(item.route);
    for (const child of item.children ?? []) {
        if (child.route) linkedRoutes.add(child.route);
    }
}

// A list page owns its whole resource, so `admin.doctors.index` becomes
// `admin.doctors.*` and keeps the menu entry highlighted on create/edit/show.
// Only `.index` routes get a pattern: single pages such as `admin.dashboard`
// would otherwise expand to `admin.*` and match everything.
function groupPattern(routeName) {
    const segments = routeName.split('.');
    if (segments.length < 3) return null;
    if (segments[segments.length - 1] !== 'index') return null;

    return `${segments.slice(0, -1).join('.')}.*`;
}

function currentRouteName() {
    try {
        return route().current() ?? '';
    } catch {
        return '';
    }
}

export function isNavRouteActive(routeName) {
    if (!routeName) return false;

    const current = currentRouteName();
    if (!current) return false;
    if (current === routeName) return true;
    if (linkedRoutes.has(current)) return false;

    const pattern = groupPattern(routeName);
    if (!pattern) return false;

    try {
        return route().current(pattern);
    } catch {
        return false;
    }
}

export default isNavRouteActive;
