<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";   // adjust if needed
$password = "";       // adjust if needed
$dbname = "farmtechx_db";

// Connect DB
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/* ------------------ HANDLE EDIT USER ------------------ */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user'])) {
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);       // ✅ new: name
    $username = trim($_POST['username']);

    // Prevent changing default Admin's username
    $check = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();
    if ($check && $check['role'] === 'Admin' && strtolower($check['username']) === 'admin') {
        $username = 'Admin'; // lock Admin username
    }

    if (!empty($_POST['password'])) {
        $password = trim($_POST['password']); // plain text (per your request)
        $stmt = $conn->prepare("UPDATE users SET name=?, username=?, password=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $username, $password, $id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET name=?, username=? WHERE id=?");
        $stmt->bind_param("ssi", $name, $username, $id);
    }

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: ../../../pages/admin-user-management.php?updated=1");
        exit();
    } else {
        die("Update failed: " . $stmt->error);
    }
} else {
    die("Form not submitted correctly.");
}
?>
