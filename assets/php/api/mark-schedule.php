<?php
header('Content-Type: application/json');

// ===== Include database connection safely =====
$dbPath = __DIR__ . "/../../../config.php"; // adjust if needed
if (!file_exists($dbPath)) {
    echo json_encode([
        'success' => false,
        'message' => 'Database file not found!'
    ]);
    exit;
}
require $dbPath; // This should define $conn as PDO

// ===== Check if 'id' parameter is provided =====
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing schedule ID'
    ]);
    exit;
}

$scheduleID = intval($_GET['id']); // sanitize input

// ===== Update the water_schedules table =====
try {
    $stmt = $conn->prepare("UPDATE water_schedules SET last_executed = NOW() WHERE id = :id");
    $stmt->bindParam(':id', $scheduleID, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => "Schedule $scheduleID marked executed."
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => "Failed to update schedule."
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => "Error: " . $e->getMessage()
    ]);
}
?>
