<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "farmtechx_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "DB connection failed"]);
    exit();
}

$sql = "SELECT temperature, created_at FROM sensor_data ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    echo json_encode([
        "status" => "ok",
        "temperature" => $row['temperature'],
        "created_at" => $row['created_at']
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "No data found"]);
}

$conn->close();
