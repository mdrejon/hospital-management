export const agentNavItems = [
    // ── Dashboard ──────────────────────────────────────────────────────────
    {
        name: 'Dashboard',
        route: 'agent.dashboard',
        icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>`,
    },

    // ── Doctor Appointments ────────────────────────────────────────────────
    {
        name: 'Doctor Appointments',
        route: null,
        icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2" stroke-width="2"/><path stroke-linecap="round" stroke-width="2" d="M16 2v4M8 2v4M3 10h18"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 16 2 2 4-4"/></svg>`,
        children: [
            { name: 'Book Doctor',          route: 'agent.doctor.create' },
            { name: 'My Bookings History',  route: 'agent.bookings.index' },
        ],
    },

    // ── Medical Tests ──────────────────────────────────────────────────────
    {
        name: 'Medical Tests',
        route: null,
        icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>`,
        children: [
            { name: 'Book Medical Test',   route: 'agent.test.create' },
            { name: 'Test Bookings List',  route: 'agent.bookings.index' },
        ],
    },

    // ── Wallet & Cash Out ──────────────────────────────────────────────────
    {
        name: 'Wallet & Cash Out',
        route: 'agent.wallet.index',
        icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>`,
    },

    // ── Profile & Payout Settings ──────────────────────────────────────────
    {
        name: 'My Profile & Payout',
        route: 'agent.profile.show',
        icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14c-4.42 0-8 1.79-8 4v2h16v-2c0-2.21-3.58-4-8-4z"/></svg>`,
    },
];

export default agentNavItems;
