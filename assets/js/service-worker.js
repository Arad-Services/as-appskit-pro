/**
 * as-appskit-pro Service Worker
 * This script handles aggressive caching and offline capabilities for the PWA.
 *
 * @since 1.0.0
 */

// Define variables that will be configured from the main thread
let CACHE_NAME = 'as-appskit-pro-default-cache'; // Default, will be updated
let urlsToCache = []; // Base URLs to cache on install
let offlineUsageEnabled = true; // Default, will be updated
let offlinePageUrl = '/offline-fallback/'; // Default, will be updated
let homeUrl = '/'; // Default, will be updated

// Listen for messages from the main thread (service-worker-registration.js)
self.addEventListener('message', (event) => {
    if (event.data && event.data.type === 'INIT_CONFIG' && event.data.config) {
        const config = event.data.config;
        offlineUsageEnabled = config.offlineUsageEnabled;
        offlinePageUrl = config.offlinePageUrl;
        homeUrl = config.homeUrl;
        CACHE_NAME = config.cacheName; // Update cache name based on config

        console.log('as-appskit-pro Service Worker: Configuration received:', config);

        // Update urlsToCache after receiving config, including homeUrl
        urlsToCache = [
            homeUrl,
            offlinePageUrl,
            // You might add more essential assets here if needed by default
            // E.g., plugin's default icons if not dynamic
        ];

        // If not already installing, you could trigger a new install if config changes significantly
        // For simplicity, we assume this config is primarily for fetch behavior.
    }
});


// Install event: Caches specified assets
self.addEventListener('install', (event) => {
    console.log('as-appskit-pro Service Worker: Install event triggered.');
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                console.log('as-appskit-pro Service Worker: Caching essential assets.');
                // Only add initial URLs if offline usage is enabled
                if (offlineUsageEnabled) {
                    return cache.addAll(urlsToCache);
                }
                return Promise.resolve(); // Do nothing if offline usage is disabled
            })
            .then(() => self.skipWaiting()) // Force the installing service worker to activate
            .catch((error) => {
                console.error('as-appskit-pro Service Worker: Cache addAll failed during install:', error);
            })
    );
});

// Activate event: Cleans up old caches
self.addEventListener('activate', (event) => {
    console.log('as-appskit-pro Service Worker: Activate event triggered.');
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheName.startsWith('as-appskit-pro-cache-') && cacheName !== CACHE_NAME) {
                        console.log('as-appskit-pro Service Worker: Deleting old cache:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => self.clients.claim()) // Take control of all clients immediately
    );
});

// Fetch event: Intercepts network requests
self.addEventListener('fetch', (event) => {
    // Only handle GET requests and ignore chrome-extension://, etc.
    if (event.request.method !== 'GET' || !event.request.url.startsWith('http')) {
        return;
    }

    // If offline usage is disabled, simply let the browser handle the request normally.
    if (!offlineUsageEnabled) {
        return; // This skips the service worker's caching logic
    }

    // Cache-first strategy with network fallback
    event.respondWith(
        caches.match(event.request)
            .then((cachedResponse) => {
                // Return cached response if found
                if (cachedResponse) {
                    // console.log('as-appskit-pro Service Worker: Serving from cache:', event.request.url);
                    return cachedResponse;
                }

                // If not in cache, go to network
                return fetch(event.request)
                    .then((networkResponse) => {
                        // Check if we received a valid response
                        if (!networkResponse || networkResponse.status !== 200 || networkResponse.type !== 'basic') {
                            return networkResponse;
                        }

                        // Cache the new response if it's for a page or essential asset
                        // Avoid caching large media files or specific API responses unless needed
                        const responseToCache = networkResponse.clone();
                        caches.open(CACHE_NAME)
                            .then((cache) => {
                                // Only cache relevant URLs (e.g., HTML pages, CSS, JS, images, not external APIs)
                                // Implement more granular caching rules here based on your plugin's needs
                                if (event.request.url.startsWith(self.location.origin) &&
                                    !event.request.url.includes('/wp-admin/') &&
                                    !event.request.url.includes('/wp-json/') &&
                                    !event.request.url.includes('/wp-cron.php') &&
                                    !event.request.url.includes('/?sw_no_cache=1')) // Example: ignore if a specific query param is present
                                {
                                    cache.put(event.request, responseToCache);
                                    // console.log('as-appskit-pro Service Worker: Caching new response:', event.request.url);
                                }
                            })
                            .catch((error) => {
                                console.warn('as-appskit-pro Service Worker: Failed to put response in cache:', event.request.url, error);
                            });
                        return networkResponse;
                    })
                    .catch(() => {
                        // Network request failed, try to serve offline page for navigation requests
                        if (event.request.mode === 'navigate') {
                            console.log('as-appskit-pro Service Worker: Network failed, navigating to offline page.');
                            return caches.match(offlinePageUrl); // Try to fetch the cached offline page
                        }
                        // For other types of requests (e.g., images), return a generic offline message
                        console.error('as-appskit-pro Service Worker: Fetch failed for:', event.request.url);
                        return new Response('<h1>You are offline!</h1><p>This content is not available offline.</p>', {
                            headers: { 'Content-Type': 'text/html' }
                        });
                    });
            })
    );
});