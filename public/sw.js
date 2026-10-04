self.addEventListener('install', (e) => {
    self.skipWaiting();
});

self.addEventListener('fetch', (e) => {
    // Basic network-first pass-through. This satisfies the PWA installability
    // requirements (Chrome requires fetch handler to use respondWith)
    e.respondWith(
        fetch(e.request).catch(() => {
            return new Response('You are offline. Please connect to the internet to use this app.', {
                status: 503,
                statusText: 'Service Unavailable',
                headers: new Headers({
                    'Content-Type': 'text/plain'
                })
            });
        })
    );
});
