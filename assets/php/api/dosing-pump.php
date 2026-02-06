<?php
// ====================
// DEBUG
// ====================
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ====================
// CORS & JSON
// ====================
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// ====================
// TIMEZONE
// ====================
date_default_timezone_set('Asia/Manila'); // <-- adjust to your local timezone

// ====================
// DATABASE
// ====================
require_once __DIR__ . "/../../../config.php";

try {
    $pump = $_GET['pump'] ?? null;
    $state = $_GET['state'] ?? null;
    $duration = intval($_GET['duration'] ?? 0);

    // ====================
    // AUTO-TURN OFF EXPIRED PUMPS
    // ====================
    $conn->query("
        UPDATE dosing_pumps
        SET state='OFF', start_time=NULL, duration_seconds=0, end_time=NULL
        WHERE end_time IS NOT NULL AND UNIX_TIMESTAMP(end_time) <= UNIX_TIMESTAMP(NOW())
    ");

    // ====================
    // TURN PUMP ON
    // ====================
    if ($pump && $state === "ON") {
        $stmt = $conn->prepare("
            UPDATE dosing_pumps
            SET state='ON', start_time=NOW(), duration_seconds=:d,
                end_time=DATE_ADD(NOW(), INTERVAL :d SECOND)
            WHERE pump=:p
        ");
        $stmt->execute([':d'=>$duration, ':p'=>$pump]);
    }

    // ====================
    // TURN PUMP OFF
    // ====================
    if ($pump && $state === "OFF") {
        $stmt = $conn->prepare("
            UPDATE dosing_pumps
            SET state='OFF', start_time=NULL, duration_seconds=0, end_time=NULL
            WHERE pump=:p
        ");
        $stmt->execute([':p'=>$pump]);
    }

    // ====================
    // RETURN DATA
    // ====================
    if ($pump) {
        $stmt = $conn->prepare("SELECT pump,state,duration_seconds,duration_minutes,end_time FROM dosing_pumps WHERE pump=:p");
        $stmt->execute([':p'=>$pump]);
        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        exit;
    }

    // Return all pumps
    $stmt = $conn->query("SELECT pump,state,duration_seconds,duration_minutes,end_time FROM dosing_pumps");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

} catch(PDOException $e){
    http_response_code(500);
    echo json_encode(["error"=>"Database error: ".$e->getMessage()]);
} catch(Exception $e){
    http_response_code(500);
    echo json_encode(["error"=>"Server error: ".$e->getMessage()]);
}
