<?php
// ====== get-schedule.php ======

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once __DIR__ . "/../../../config.php";

$response = ['success' => false, 'message' => 'Unknown error', 'data' => []];

try {
    $stmt = $conn->prepare("SELECT id, hour, minute, ampm, duration, last_executed FROM water_schedules ORDER BY hour, minute");
    $stmt->execute();
    $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['message'] = "Schedules retrieved successfully";
    $response['data'] = $schedules;

} catch (PDOException $e) {
    $response['message'] = "Database error: " . $e->getMessage();
}

echo json_encode($response);
