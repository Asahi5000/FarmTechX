<?php
require_once __DIR__ . "/../../../config.php";
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$sensor_id = 2; // fixed for this example, or you can make it dynamic via GET

try {
    $stmt = $conn->prepare("
        SELECT moisture, temperature, ph, ec, updated_at
        FROM soil_data
        WHERE sensor_id = :sensor_id
        ORDER BY updated_at DESC
        LIMIT 1
    ");
    $stmt->execute([':sensor_id' => $sensor_id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    // Debug: uncomment if you want to see raw DB result
    // var_dump($data); exit;

    $response = [
        "moisture"    => isset($data['moisture']) ? floatval($data['moisture']) : 0,
        "temperature" => isset($data['temperature']) ? floatval($data['temperature']) : 0,
        "ph"          => isset($data['ph']) ? floatval($data['ph']) : 0,
        "ec"          => isset($data['ec']) ? floatval($data['ec']) : 0,
        "updated_at"  => $data['updated_at'] ?? "--"
    ];

    echo json_encode($response);

} catch(PDOException $e) {
    echo json_encode([
        "moisture" => 0,
        "temperature" => 0,
        "ph" => 0,
        "ec" => 0,
        "updated_at" => "--",
        "error" => $e->getMessage()
    ]);
}
