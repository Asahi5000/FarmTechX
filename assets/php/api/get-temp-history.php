<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "farmtechx_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => $conn->connect_error]);
    exit();
}

$sql = "SELECT temperature, created_at FROM sensor_data ORDER BY id DESC LIMIT 50";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode([
    "status" => "ok",
    "data" => array_reverse($data) // oldest → newest
]);

$conn->close();
