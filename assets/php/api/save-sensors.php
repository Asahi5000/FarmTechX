<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // allow ESP32 to POST

include("../../../config.php");

try {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // ✅ Read POST values
        $temperature = isset($_POST['temperature']) ? floatval($_POST['temperature']) : null;
        $ec = isset($_POST['ec']) ? floatval($_POST['ec']) : null;
        $ph = isset($_POST['ph']) ? floatval($_POST['ph']) : null;

        if ($temperature === null || $ec === null || $ph === null) {
            echo json_encode(["status" => "error", "message" => "Missing parameters"]);
            exit;
        }

        // ✅ Insert into DB
        $stmt = $conn->prepare("INSERT INTO sensors (temperature, ec, ph) VALUES (:temperature, :ec, :ph)");
        $stmt->bindParam(":temperature", $temperature);
        $stmt->bindParam(":ec", $ec);
        $stmt->bindParam(":ph", $ph);
        $stmt->execute();

        echo json_encode(["status" => "ok", "message" => "Data saved successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Use POST method"]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
