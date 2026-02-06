// preventCache.js
// This script prevents the browser from caching the page when navigating back to it.
window.addEventListener("pageshow", function(event) {
    // If the page is loaded from cache (like Back button)
    if (event.persisted) {
        window.location.reload();
    }
});

