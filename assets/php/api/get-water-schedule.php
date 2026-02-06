<?php
header("Content-Type: application/json");
include "../../../config.php"; // adjust path to your DB config

try {
    $stmt = $conn->prepare("SELECT id, hour, minute, ampm, duration, last_executed FROM water_schedules ORDER BY hour, minute");
    $stmt->execute();
    $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($schedules);
} catch(PDOException $e){
    echo json_encode(["status"=>"error", "message"=>$e->getMessage()]);
}
?>
