<?php
header("Content-Type: application/json");
include "../../../config.php";

try {
    $stmt = $conn->prepare(
        "SELECT soil_moisture, raining FROM soil_status ORDER BY id DESC LIMIT 1"
    );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo json_encode([
            "soil_moisture" => intval($row['soil_moisture']),
            "raining" => intval($row['raining'])
        ]);
    } else {
        echo json_encode(["soil_moisture"=>0,"raining"=>0]);
    }
} catch(PDOException $e){
    echo json_encode(["soil_moisture"=>0,"raining"=>0,"error"=>$e->getMessage()]);
}
?>
