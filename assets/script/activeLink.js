    // Highlight active link based on current page URL
document.querySelectorAll('.nav-item').forEach(link => {
    if (link.href === window.location.href) {
        link.classList.add('active');
    }
});