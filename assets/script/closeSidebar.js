    // Close sidebar when clicking outside on mobile
document.addEventListener('click', function(event) {
    const sidebar = document.getElementById('sidebar');
    const hamburger = document.querySelector('.hamburger');

    if (
        window.innerWidth <= 767 &&
        !sidebar.contains(event.target) &&
        !hamburger.contains(event.target) &&
        sidebar.classList.contains('open')
    ) {
        sidebar.classList.remove('open');   // hide sidebar
        hamburger.style.display = "block";  // show hamburger again
    }
});