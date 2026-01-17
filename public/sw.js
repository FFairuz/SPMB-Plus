const CACHE_NAME = 'spmb-plus-v1.0.0';
const STATIC_CACHE = 'spmb-static-v1.0.0';
const DYNAMIC_CACHE = 'spmb-dynamic-v1.0.0';

// Files to cache immediately
const STATIC_ASSETS = [
    '/',
    '/auth/login',
    '/css/style.css',
    '/manifest.json',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',
    'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js',
    'https://code.jquery.com/jquery-3.6.0.min.js',
    'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js'
];

// Install event - cache static assets
self.addEventListener('install', (event) => {
    console.log('[Service Worker] Installing...');
    event.waitUntil(
        caches.open(STATIC_CACHE)
            .then((cache) => {
                console.log('[Service Worker] Caching static assets');
                return cache.addAll(STATIC_ASSETS);
            })
            .catch((error) => {
                console.error('[Service Worker] Cache failed:', error);
            })
    );
    self.skipWaiting();
});

// Activate event - clean old caches
self.addEventListener('activate', (event) => {
    console.log('[Service Worker] Activating...');
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheName !== STATIC_CACHE && cacheName !== DYNAMIC_CACHE) {
                        console.log('[Service Worker] Deleting old cache:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
    return self.clients.claim();
});

// Fetch event - network first, fallback to cache
self.addEventListener('fetch', (event) => {
    const { request } = event;
    const url = new URL(request.url);

    // Skip chrome extensions and non-http(s) requests
    if (!url.protocol.startsWith('http')) {
        return;
    }

    // API requests - network only with timeout
    if (url.pathname.includes('/api/') || request.method !== 'GET') {
        event.respondWith(
            fetch(request)
                .catch(() => {
                    return new Response(
                        JSON.stringify({ 
                            error: 'Tidak ada koneksi internet',
                            offline: true 
                        }),
                        {
                            headers: { 'Content-Type': 'application/json' },
                            status: 503
                        }
                    );
                })
        );
        return;
    }

    // Static assets - cache first
    if (STATIC_ASSETS.includes(url.pathname) || url.origin.includes('cdn.jsdelivr.net') || url.origin.includes('code.jquery.com')) {
        event.respondWith(
            caches.match(request)
                .then((cachedResponse) => {
                    if (cachedResponse) {
                        return cachedResponse;
                    }
                    return fetch(request)
                        .then((networkResponse) => {
                            return caches.open(STATIC_CACHE)
                                .then((cache) => {
                                    cache.put(request, networkResponse.clone());
                                    return networkResponse;
                                });
                        });
                })
        );
        return;
    }

    // Other requests - network first, fallback to cache
    event.respondWith(
        fetch(request)
            .then((networkResponse) => {
                // Clone response for caching
                const responseClone = networkResponse.clone();
                
                caches.open(DYNAMIC_CACHE)
                    .then((cache) => {
                        cache.put(request, responseClone);
                    });
                
                return networkResponse;
            })
            .catch(() => {
                return caches.match(request)
                    .then((cachedResponse) => {
                        if (cachedResponse) {
                            return cachedResponse;
                        }
                        
                        // Return offline page for navigation requests
                        if (request.mode === 'navigate') {
                            return caches.match('/');
                        }
                        
                        return new Response('Offline', {
                            status: 503,
                            statusText: 'Service Unavailable'
                        });
                    });
            })
    );
});

// Background sync for form submissions
self.addEventListener('sync', (event) => {
    console.log('[Service Worker] Background sync:', event.tag);
    
    if (event.tag === 'sync-applicants') {
        event.waitUntil(syncApplicantData());
    }
});

// Push notifications
self.addEventListener('push', (event) => {
    console.log('[Service Worker] Push received');
    
    const data = event.data ? event.data.json() : {};
    const title = data.title || 'SPMB Plus';
    const options = {
        body: data.body || 'Ada update baru untuk Anda',
        icon: '/pwa-icons/icon-192x192.png',
        badge: '/pwa-icons/icon-72x72.png',
        vibrate: [200, 100, 200],
        data: {
            url: data.url || '/',
            timestamp: Date.now()
        },
        actions: [
            {
                action: 'open',
                title: 'Buka',
                icon: '/pwa-icons/icon-72x72.png'
            },
            {
                action: 'close',
                title: 'Tutup'
            }
        ]
    };
    
    event.waitUntil(
        self.registration.showNotification(title, options)
    );
});

// Notification click handler
self.addEventListener('notificationclick', (event) => {
    console.log('[Service Worker] Notification clicked');
    
    event.notification.close();
    
    if (event.action === 'open' || !event.action) {
        const urlToOpen = event.notification.data.url || '/';
        
        event.waitUntil(
            clients.matchAll({ type: 'window', includeUncontrolled: true })
                .then((windowClients) => {
                    // Check if there's already a window open
                    for (let client of windowClients) {
                        if (client.url === urlToOpen && 'focus' in client) {
                            return client.focus();
                        }
                    }
                    // Open new window if none exists
                    if (clients.openWindow) {
                        return clients.openWindow(urlToOpen);
                    }
                })
        );
    }
});

// Helper function for background sync
async function syncApplicantData() {
    try {
        // Get pending data from IndexedDB or localStorage
        const pendingData = await getPendingData();
        
        if (pendingData && pendingData.length > 0) {
            for (const data of pendingData) {
                await fetch('/api/applicants/sync', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
            }
            
            await clearPendingData();
            console.log('[Service Worker] Sync completed');
        }
    } catch (error) {
        console.error('[Service Worker] Sync failed:', error);
        throw error;
    }
}

async function getPendingData() {
    // Implement IndexedDB or localStorage retrieval
    return [];
}

async function clearPendingData() {
    // Implement IndexedDB or localStorage clearing
}

// Log service worker version
console.log('[Service Worker] Version:', CACHE_NAME);
