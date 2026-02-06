<?php
require_once __DIR__ . "/../../../config.php";
header("Content-Type: application/json");

// Debug: print POST data
file_put_contents("debug_post.txt", print_r($_POST, true), FILE_APPEND);

$sensor_id   = $_POST['sensor_id'] ?? null;
$moisture    = $_POST['moisture'] ?? null;
$temperature = $_POST['temperature'] ?? 0;
$ph          = $_POST['ph'] ?? null;
$ec          = $_POST['ec'] ?? null;


// Validate sensor_id
if ($sensor_id === null || !is_numeric($sensor_id)) {
    echo json_encode(["status"=>"error","message"=>"Missing sensor_id"]);
    exit;
}

// Ensure numeric values
$moisture    = is_numeric($moisture) ? floatval($moisture) : 0;
$temperature = is_numeric($temperature) ? floatval($temperature) : 0;
$ph          = is_numeric($ph) ? floatval($ph) : 0;
$ec          = is_numeric($ec) ? floatval($ec) : 0;

try {
    $stmt = $conn->prepare("
        INSERT INTO soil_data (sensor_id, moisture, temperature, ph, ec)
        VALUES (:sensor_id, :moisture, :temperature, :ph, :ec)
    ");
    $stmt->execute([
        ":sensor_id"   => $sensor_id,
        ":moisture"    => $moisture,
        ":temperature" => $temperature,
        ":ph"          => $ph,
        ":ec"          => $ec
    ]);

    echo json_encode(["status"=>"success", "id"=>$conn->lastInsertId()]);
} catch(PDOException $e){
    echo json_encode(["status"=>"error","message"=>$e->getMessage()]);
}
