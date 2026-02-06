<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-content">
        <div class="profile-section">
            <img src="../assets/images/company-logo.jpg" alt="Admin Profile" class="profile-image" />
            <div class="sidebar-admin-name">
            <?php echo strtoupper($_SESSION['name'] ?? '' );?>
            </div>
            <div class="sidebar-admin-text">
                <?php echo strtoupper($_SESSION['role'] ?? 'GUEST'); ?>
            </div>
        </div>
                
        <nav class="sidebar-menu">
            <a href="../pages/admin-dashboard.php" class="nav-item">
                <i class='bx bx-leaf'></i>
                <span>Dashboard</span>
            </a>
            <a href="../pages/admin-user-management.php" class="nav-item">
                <i class='bx bxs-user-detail' ></i>
                <span>User Management</span>
            </a>

            <a href="../pages/admin-history.php" class="nav-item">
                <i class='bx bx-receipt'></i>
                <span>History</span>
            </a>
            
            <a href="../pages/admin-about.php" class="nav-item active dashboard ">
                <i class='bx bx-info-circle' style="color: black;"></i>
                <span>About</span>
            </a>

            <a href="../logout.php" class="nav-item logout-item">
                <i class='bx bx-log-out' ></i>
                <span>Logout</span>
            </a>
        </nav>
    </div>
</aside>
