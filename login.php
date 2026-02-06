<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    try {
        // ✅ Remove collation mismatch (will work if your table is utf8mb4 or latin1)
        $sql = "SELECT id, name, username, password, role
                FROM users 
                WHERE username = :username 
                LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // ✅ Compare plain passwords (later replace with password_verify)
            if ($password === $user['password']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name']    = $user['name'];
                $_SESSION['username']= $user['username'];
                $_SESSION['role']    = $user['role'];

                header("Location: pages/admin-dashboard.php");
                exit();
            } else {
                echo "<script>alert('Invalid password'); window.location='index.php';</script>";
            }
        } else {
            echo "<script>alert('User not found'); window.location='index.php';</script>";
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>
