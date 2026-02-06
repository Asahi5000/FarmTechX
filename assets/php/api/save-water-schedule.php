<?php
header("Content-Type: application/json");
include "../../../config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status"=>"error","message"=>"POST required"]);
    exit;
}

$hour     = isset($_POST['hour']) ? intval($_POST['hour']) : null;
$minute   = isset($_POST['minute']) ? intval($_POST['minute']) : null;
$ampm     = isset($_POST['ampm']) ? $_POST['ampm'] : null;
$duration = isset($_POST['duration']) ? intval($_POST['duration']) : null;

if($hour===null || $minute===null || $ampm===null || $duration===null){
    echo json_encode(["status"=>"error","message"=>"Missing parameters"]);
    exit;
}

try{
    $stmt = $conn->prepare("INSERT INTO water_schedule (hour, minute, ampm, duration) VALUES (:hour,:minute,:ampm,:duration)");
    $stmt->bindParam(":hour",$hour);
    $stmt->bindParam(":minute",$minute);
    $stmt->bindParam(":ampm",$ampm);
    $stmt->bindParam(":duration",$duration);
    $stmt->execute();
    echo json_encode(["status"=>"ok"]);
} catch(PDOException $e){
    echo json_encode(["status"=>"error","message"=>$e->getMessage()]);
}
