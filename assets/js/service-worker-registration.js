/**
 * Registers the Service Worker for as-appskit-pro.
 * This script runs on the client-side to set up the PWA.
 *
 * @since 1.0.0
 */
(function() {
    'use strict';

    // Check if the browser supports service workers
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            // Get the service worker URL and offline usage status from localized data
            // asAppskitPro is global object set by wp_localize_script in PHP
            const serviceWorkerUrl = asAppskitPro.serviceWorkerUrl;
            const offlineUsageEnabled = asAppskitPro.offlineUsageEnabled;
            const offlinePageUrl = asAppskitPro.offlinePageUrl;
            const homeUrl = asAppskitPro.homeUrl;
            const cacheName = asAppskitPro.cacheName;


            navigator.serviceWorker.register(serviceWorkerUrl)
                .then(function(registration) {
                    // Service Worker registration was successful
                    console.log('as-appskit-pro ServiceWorker registration successful with scope: ', registration.scope);

                    // Optional: Listen for updates to the service worker
                    registration.onupdatefound = function() {
                        const installingWorker = registration.installing;
                        installingWorker.onstatechange = function() {
                            if (installingWorker.state === 'installed') {
                                if (navigator.serviceWorker.controller) {
                                    // New or updated service worker found
                                    console.log('as-appskit-pro: New content is available! Please refresh.');
                                    // You could trigger a UI notification here to prompt user to refresh
                                } else {
                                    // Content is cached for offline use.
                                    console.log('as-appskit-pro: Content is now available offline.');
                                }
                            }
                        };
                    };

                    // Send data to the service worker once it's active
                    if (navigator.serviceWorker.controller) {
                        navigator.serviceWorker.controller.postMessage({
                            type: 'INIT_CONFIG',
                            config: {
                                offlineUsageEnabled: offlineUsageEnabled,
                                offlinePageUrl: offlinePageUrl,
                                homeUrl: homeUrl,
                                cacheName: cacheName,
                            }
                        });
                    } else {
                        // If controller is null, it means the page is not controlled yet.
                        // Wait for the next activation and then send message.
                        navigator.serviceWorker.addEventListener('controllerchange', function() {
                            if (navigator.serviceWorker.controller) {
                                navigator.serviceWorker.controller.postMessage({
                                    type: 'INIT_CONFIG',
                                    config: {
                                        offlineUsageEnabled: offlineUsageEnabled,
                                        offlinePageUrl: offlinePageUrl,
                                        homeUrl: homeUrl,
                                        cacheName: cacheName,
                                    }
                                });
                            }
                        });
                    }

                })
                .catch(function(err) {
                    // Service Worker registration failed
                    console.error('as-appskit-pro ServiceWorker registration failed: ', err);
                });
        });
    } else {
        console.warn('as-appskit-pro: Service Workers are not supported by this browser.');
    }
})();