<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

// ===== Database Connection =====
$host = "localhost";
$user = "root";        // change if needed
$pass = "";            // change if needed
$db   = "farmtechx_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Database connection failed"
    ]);
    exit;
}

// ===== Validate POST Data =====
if (
    !isset($_POST['sensor_id']) ||
    !isset($_POST['rain']) ||
    !isset($_POST['rain_intensity'])
) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Missing required parameters"
    ]);
    exit;
}

$sensor_id      = intval($_POST['sensor_id']);
$is_raining     = intval($_POST['rain']);           // 0 or 1
$rain_intensity = intval($_POST['rain_intensity']); // 0–1023

// ===== Insert Data =====
$stmt = $conn->prepare(
    "INSERT INTO rain_data (sensor_id, is_raining, intensity)
     VALUES (?, ?, ?)"
);

$stmt->bind_param("iii", $sensor_id, $is_raining, $rain_intensity);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Rain data saved successfully"
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Failed to insert rain data"
    ]);
}

$stmt->close();
$conn->close();
?>
