<?php
header("Content-Type: application/json");
include "../../../config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "POST required"]);
    exit;
}

$temperature = isset($_POST['temperature']) ? floatval($_POST['temperature']) : null;
$tds         = isset($_POST['tds']) ? floatval($_POST['tds']) : null;
$ec          = isset($_POST['ec']) ? floatval($_POST['ec']) : null;
$ph          = isset($_POST['ph']) ? floatval($_POST['ph']) : null;

if ($temperature === null || $tds === null || $ec === null) {
    echo json_encode(["status" => "error", "message" => "Missing parameters"]);
    exit;
}

try {
    $stmt = $conn->prepare(
        "INSERT INTO sensors (temperature, tds, ec, ph)
         VALUES (:temperature, :tds, :ec, :ph)"
    );

    $stmt->bindParam(":temperature", $temperature);
    $stmt->bindParam(":tds", $tds);
    $stmt->bindParam(":ec", $ec);
    $stmt->bindParam(":ph", $ph);

    $stmt->execute();

    echo json_encode(["status" => "ok"]);
} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
