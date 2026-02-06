<?php
// ====== add-schedule.php ======

// Allow CORS (adjust * to your frontend if needed)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once __DIR__ . "/../../../config.php";

$response = ['success' => false, 'message' => 'Unknown error'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST values safely
    $hour = isset($_POST['hour']) ? intval($_POST['hour']) : null;
    $minute = isset($_POST['minute']) ? intval($_POST['minute']) : null;
    $duration = isset($_POST['duration']) ? intval($_POST['duration']) : null;

    // Validate basic fields
    if ($hour === null || $minute === null || $duration === null) {
        $response['message'] = "Missing required fields";
        echo json_encode($response);
        exit;
    }

    if ($hour < 0 || $hour > 23 || $minute < 0 || $minute > 59 || $duration < 1 || $duration > 120) {
        $response['message'] = "Invalid values";
        echo json_encode($response);
        exit;
    }

    // Convert 24-hour to 12-hour and determine AM/PM
    if ($hour == 0) {
        $hour12 = 12;
        $ampm = "AM";
    } elseif ($hour == 12) {
        $hour12 = 12;
        $ampm = "PM";
    } elseif ($hour > 12) {
        $hour12 = $hour - 12;
        $ampm = "PM";
    } else {
        $hour12 = $hour;
        $ampm = "AM";
    }

    try {
        // Use PDO
        $stmt = $conn->prepare("
            INSERT INTO water_schedules (hour, minute, ampm, duration, last_executed)
            VALUES (:hour, :minute, :ampm, :duration, NULL)
        ");
        $success = $stmt->execute([
            ':hour' => $hour12,
            ':minute' => $minute,
            ':ampm' => $ampm,
            ':duration' => $duration
        ]);

        if ($success) {
            $response['success'] = true;
            $response['message'] = "Schedule added successfully";
        } else {
            $response['message'] = "Database insert failed";
        }

    } catch (PDOException $e) {
        $response['message'] = "Database error: " . $e->getMessage();
    }

} else {
    $response['message'] = "Invalid request method";
}

echo json_encode($response);
