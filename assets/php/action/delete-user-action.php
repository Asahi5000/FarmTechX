<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";   
$password = "";       
$dbname = "farmtechx_db";

// Connect DB
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/* ------------------ HANDLE DELETE USER ------------------ */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);

    // Prevent deleting default Admin
    $check = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();
    if ($check && !($check['role'] === 'Admin' && strtolower($check['username']) === 'admin')) {
        $conn->query("DELETE FROM users WHERE id=$id");
    }

    header("Location: ../../../pages/admin-user-management.php");
    exit();
}
