<?php
$host = getenv("asahi5000-mysql.wasmer.app");
$db   = getenv("farmdb");
$user = getenv("farmuser");
$pass = getenv("Arca2020?");
$port = getenv("3306") ?: 3306;

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}
?>
