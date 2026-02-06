<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// ===== Database Config =====
$host = "localhost";
$user = "root";     // change if needed
$pass = "";         // change if needed
$db   = "farmtechx_db";

// ===== Connect =====
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        "error" => "Database connection failed"
    ]);
    exit;
}

// ===== Get Latest Rain Data =====
$sql = "
    SELECT 
        is_raining,
        intensity,
        created_at
    FROM rain_data
    ORDER BY created_at DESC
    LIMIT 1
";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    echo json_encode([
        "is_raining" => (int)$row["is_raining"],
        "intensity"  => (int)$row["intensity"],
        "created_at" => $row["created_at"]
    ]);
} else {
    // No data yet
    echo json_encode([
        "is_raining" => null,
        "intensity"  => null,
        "created_at" => null
    ]);
}

$conn->close();
?>
