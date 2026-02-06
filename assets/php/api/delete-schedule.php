<?php
// ====== delete-schedule.php ======

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once __DIR__ . "/../../../config.php";

$response = ['success' => false, 'message' => 'Unknown error'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;

    if ($id === null) {
        $response['message'] = "Missing schedule ID";
        echo json_encode($response);
        exit;
    }

    try {
        $stmt = $conn->prepare("DELETE FROM water_schedules WHERE id = :id");
        $success = $stmt->execute([':id' => $id]);

        if ($success) {
            $response['success'] = true;
            $response['message'] = "Schedule deleted successfully";
        } else {
            $response['message'] = "Failed to delete schedule";
        }

    } catch (PDOException $e) {
        $response['message'] = "Database error: " . $e->getMessage();
    }

} else {
    $response['message'] = "Invalid request method";
}

echo json_encode($response);
