<?php
include '../../../config.php';

try {
    $stmt = $conn->query("SELECT temperature, ec, ph, created_at FROM sensors ORDER BY id DESC LIMIT 50");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($rows) {
        echo json_encode(["status" => "ok", "data" => array_reverse($rows)]);
    } else {
        echo json_encode(["status" => "error", "message" => "No history found"]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
