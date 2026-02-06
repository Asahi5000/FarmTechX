<?php
ob_start(); // start output buffering, avoids "headers already sent"
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../authenticator.php';

$servername = "localhost";
$username = "root";   // change if needed
$password = "";       // change if needed
$dbname = "farmtechx_db";

// Connect DB
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Restrict by role
$role = $_SESSION['role'] ?? '';

// Staff can only view (read-only)
if ($role !== 'Admin' && $role !== 'Staff') {
    // block unknown roles
    header("Location: dashboard.php?error=unauthorized");
    exit();
}
/* ------------------ FETCH ALL USERS ------------------ */
$result = $conn->query("SELECT * FROM users");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>FarmTechX Admin - User Management</title>
    <link rel="stylesheet" href="../assets/css/styles.css" />
    <link rel="stylesheet" href="../assets/css/user-style.css" />
    <link rel="stylesheet" href="../assets/css/lowerR-bg.css" />
    <link rel="icon" href="../assets/images/FarmTechX.jpg" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="main-container">
        <?php include '../assets/php/hamburder-menu.php'; ?>        
        <?php include '../assets/php/sidebar-user-management.php'; ?>
        
        <main class="main-content">
            <div class="content-wrapper">
                <?php include '../assets/php/welcome-card-user-management.php'; ?>
                
                <div class="card">
                    <div class="header">                      
                        <span class="user-count"><i class='bx bxs-user' ></i> <?php echo $result->num_rows; ?></span>
                        
                    </div>
                    <div class="table-container">
                    <table>
                    <tr>
                        <td data-label="Role"><strong>Role</strong></td>
                        <td data-label="Name"><strong>Name</strong></td>
                        <td data-label="Username"><strong>Username</strong></td>
                        <td data-label="Password"><strong>Password</strong></td>
                        <td data-label="Action"><strong>Action</strong></td>
                    </tr>

                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['role']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td>****</td>
                            <td>
                                <!-- EDIT BUTTON -->
                                <?php include '../assets/php/edit-user-button.php'; ?>
                                <!-- DELETE BUTTON -->
                                <?php include '../assets/php/modal/delete-user-modal.php'; ?>
                                <?php include '../assets/php/delete-user-button.php'; ?>

                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </table>
                    </div>
                    <br>
                    <!-- ADD USER BUTTON (only visible for Admins) -->
                    <?php if ($_SESSION['role'] === 'Admin'): ?>
                        <button class="addBtn" onclick="openAddForm()">Add User</button>
                    <?php endif; ?>
                </div>

                <!-- Add User Modal -->
                <?php include '../assets/php/modal/add-user-modal.php'; ?>

                <!-- Edit User Modal -->
                <?php include '../assets/php/modal/edit-user-modal.php'; ?>

            </div>
        </main>
    </div>
<img src="../assets/images/lowerR-bg.png" alt="lowerR-bg" class="lowerR-bg">



<script src="../assets/script/openDeleteForm.js"></script>
<script src="../assets/script/openEditForm.js"></script>
<script src="../assets/script/openAddForm.js"></script>
<script src="../assets/script/activeLink.js"></script>
<script src="../assets/script/navClicks.js"></script>
<script src="../assets/script/closeSidebar.js"></script>
<script src="../assets/script/toggleSidebar.js"></script>
<script src="../assets/script/preventCache.js"></script>

</body>
</html>
<?php ob_end_flush(); ?>
