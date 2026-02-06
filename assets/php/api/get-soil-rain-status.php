<?php
header("Content-Type: application/json");
include "../../../config.php";

try {
    // Get latest soil data
    $soilStmt = $conn->prepare("SELECT moisture, temperature, ph, ec FROM soil_data ORDER BY id DESC LIMIT 1");
    $soilStmt->execute();
    $soil = $soilStmt->fetch(PDO::FETCH_ASSOC);

    // Get latest rain data
    $rainStmt = $conn->prepare("SELECT rain, rain_intensity FROM rain_data ORDER BY id DESC LIMIT 1");
    $rainStmt->execute();
    $rain = $rainStmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        "moisture" => intval($soil['moisture']),
        "temperature" => floatval($soil['temperature']),
        "ph" => floatval($soil['ph']),
        "ec" => floatval($soil['ec']),
        "rain" => boolval($rain['rain']),
        "rain_intensity" => intval($rain['rain_intensity'])
    ]);
} catch(PDOException $e){
    echo json_encode(["error"=>$e->getMessage()]);
}
?>
