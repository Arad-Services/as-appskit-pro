/**
 * Pull Down to Refresh functionality for as-appskit-pro.
 *
 * @since 1.0.0
 */
(function() {
    'use strict';

    // Check if the feature is enabled via localized script (from as_appskit_pro_pwa)
    // For simplicity, we assume this file only loads if the feature is enabled in PHP.
    // If you need more granular control, localize a variable here too.

    const body = document.body;
    let startY = 0;
    let currentY = 0;
    let pulling = false;
    const pullThreshold = 80; // Distance in pixels to trigger refresh
    const refreshIndicator = document.createElement('div');

    refreshIndicator.id = 'as-appskit-pro-pull-to-refresh-indicator';
    refreshIndicator.textContent = 'Pull to refresh';
    refreshIndicator.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        text-align: center;
        background: #f1f1f1;
        color: #555;
        padding: 10px 0;
        transform: translateY(-100%);
        transition: transform 0.2s ease-out;
        z-index: 9999;
        font-family: sans-serif;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        display: none; /* Hidden by default */
    `;
    body.prepend(refreshIndicator); // Add it to the top of the body

    function handleTouchStart(e) {
        // Only start if at the very top of the scroll and it's a single touch
        if (body.scrollTop === 0 && document.documentElement.scrollTop === 0 && e.touches.length === 1) {
            startY = e.touches[0].pageY;
            pulling = true;
            refreshIndicator.style.display = 'block'; // Show indicator
        }
    }

    function handleTouchMove(e) {
        if (!pulling) return;

        currentY = e.touches[0].pageY;
        const diff = currentY - startY;

        if (diff > 0) { // Only pull down
            e.preventDefault(); // Prevent scrolling down the page
            const translateY = Math.min(diff / 2, pullThreshold); // Slow down pull and limit
            refreshIndicator.style.transform = `translateY(${translateY}px)`;

            if (diff > pullThreshold) {
                refreshIndicator.textContent = 'Release to refresh';
            } else {
                refreshIndicator.textContent = 'Pull to refresh';
            }
        } else {
            pulling = false; // Stop pulling if scrolling up
            refreshIndicator.style.transform = 'translateY(-100%)';
            refreshIndicator.style.display = 'none';
        }
    }

    function handleTouchEnd() {
        if (!pulling) return;

        pulling = false;
        const diff = currentY - startY;

        if (diff > pullThreshold) {
            refreshIndicator.textContent = 'Refreshing...';
            // Trigger refresh
            window.location.reload(); // Simple page reload
        } else {
            refreshIndicator.style.transform = 'translateY(-100%)';
            refreshIndicator.style.display = 'none';
        }
    }

    // Add event listeners for touch events
    body.addEventListener('touchstart', handleTouchStart, { passive: false });
    body.addEventListener('touchmove', handleTouchMove, { passive: false });
    body.addEventListener('touchend', handleTouchEnd);

    // Also handle mouse for desktop testing if needed (optional)
    let isMouseDown = false;
    function handleMouseDown(e) {
        if (body.scrollTop === 0 && document.documentElement.scrollTop === 0) {
            startY = e.pageY;
            isMouseDown = true;
            refreshIndicator.style.display = 'block';
        }
    }

    function handleMouseMove(e) {
        if (!isMouseDown) return;
        currentY = e.pageY;
        const diff = currentY - startY;
        if (diff > 0) {
            const translateY = Math.min(diff / 2, pullThreshold);
            refreshIndicator.style.transform = `translateY(${translateY}px)`;
            if (diff > pullThreshold) {
                refreshIndicator.textContent = 'Release to refresh';
            } else {
                refreshIndicator.textContent = 'Pull to refresh';
            }
        } else {
            isMouseDown = false;
            refreshIndicator.style.transform = 'translateY(-100%)';
            refreshIndicator.style.display = 'none';
        }
    }

    function handleMouseUp() {
        if (!isMouseDown) return;
        isMouseDown = false;
        const diff = currentY - startY;
        if (diff > pullThreshold) {
            refreshIndicator.textContent = 'Refreshing...';
            window.location.reload();
        } else {
            refreshIndicator.style.transform = 'translateY(-100%)';
            refreshIndicator.style.display = 'none';
        }
    }

    body.addEventListener('mousedown', handleMouseDown);
    body.addEventListener('mousemove', handleMouseMove);
    body.addEventListener('mouseup', handleMouseUp);
    body.addEventListener('mouseleave', handleMouseUp); // In case mouse leaves window while dragging

})();