import agentNavItems from './agentNavItems';

const linkedRoutes = new Set();
for (const item of agentNavItems) {
    if (item.route) linkedRoutes.add(item.route);
    for (const child of item.children ?? []) {
        if (child.route) linkedRoutes.add(child.route);
    }
}

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

export function isAgentNavRouteActive(routeName) {
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

export default isAgentNavRouteActive;
