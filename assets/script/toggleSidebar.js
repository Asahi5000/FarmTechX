function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const hamburger = document.querySelector('.hamburger');

    if (window.innerWidth <= 767) {
        sidebar.classList.add('open');      // show sidebar
        hamburger.style.display = "none";   // hide hamburger
    }
}
