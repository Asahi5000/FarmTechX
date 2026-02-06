<?php
header("Content-Type: application/json");
include "../../../config.php";

try {
    // Get latest water pump duration (in seconds) from schedules table
    $stmt = $conn->prepare("SELECT duration FROM schedules ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $duration = isset($row['duration']) ? intval($row['duration']) : 60; // default 60s
    echo json_encode(["duration" => $duration]);

} catch(PDOException $e){
    echo json_encode(["duration" => 60, "error" => $e->getMessage()]);
}
?>
