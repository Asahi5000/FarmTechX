<?php
header("Access-Control-Allow-Origin: *"); // allow all origins
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
include "../../../config.php";

$sql = "SELECT temperature, tds, ec, ph, created_at
        FROM sensors
        ORDER BY id DESC
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($data) {
    echo json_encode([
        "status" => "ok",
        "temperature" => $data["temperature"],
        "tds" => $data["tds"],
        "ec" => $data["ec"],
        "ph" => $data["ph"],
        "created_at" => $data["created_at"]
    ]);
} else {
    echo json_encode(["status" => "error"]);
}
