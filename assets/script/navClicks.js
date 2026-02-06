    // Handle nav item clicks
document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', function() {
        // Remove active class from all items
        document.querySelectorAll('.nav-item').forEach(nav => {
            nav.classList.remove('active');
        });

        // Add active class to clicked item
        this.classList.add('active');

        // Close sidebar on mobile after selection
        if (window.innerWidth <= 767) {
            document.getElementById('sidebar').classList.remove('open');
            document.querySelector('.hamburger').style.display = "block"; // show hamburger back
        }
    });
});