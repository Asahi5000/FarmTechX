<?php
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : "Guest"; 
?>

<div class="welcome-card">
    <img src="../assets/images/card-image.png" alt="Welcome Image" class="welcome-image" />
    <h1 class="dashboard-title">User Management</h1>
    <p class="welcome-text">Welcome, <?php echo htmlspecialchars($role); ?>!</p>
</div>