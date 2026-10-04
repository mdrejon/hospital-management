self.addEventListener('install', (e) => {
    self.skipWaiting();
});

self.addEventListener('fetch', (e) => {
    // Basic pass-through to satisfy PWA installability requirements
    // without caching aggressively (so it doesn't break dynamic content)
});
