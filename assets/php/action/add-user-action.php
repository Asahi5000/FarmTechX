<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";   // change if needed
$password = "";       // change if needed
$dbname = "farmtechx_db";

// Connect DB
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/* ------------------ HANDLE ADD USER ------------------ */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $role = trim($_POST['role']);
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); // plain text password

    // ✅ Prevent duplicate usernames (case-sensitive check for latin1)
    $check = $conn->prepare("SELECT id FROM users WHERE username COLLATE latin1_bin = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $check->close();
        echo "<script>alert('Username already exists!'); window.location='../../../pages/admin-user-management.php';</script>";
        exit();
    }
    $check->close();

    // ✅ Insert user with plain text password
    $stmt = $conn->prepare("INSERT INTO users (name, username, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $username, $password, $role);

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: ../../../pages/admin-user-management.php?success=1");
        exit();
    } else {
        echo "Error: " . $stmt->error;
        $stmt->close();
    }

} else {
    header("Location: ../../../pages/admin-user-management.php");
    exit();
}
?>
