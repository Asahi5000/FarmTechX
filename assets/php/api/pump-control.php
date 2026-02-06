<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit; }

date_default_timezone_set('Asia/Manila');
require_once __DIR__ . "/../../../config.php";

try {
    $state = $_GET['state'] ?? null;
    $duration = intval($_GET['duration'] ?? 0);

    $pump = $conn->query("SELECT * FROM pump_control WHERE id=1")->fetch(PDO::FETCH_ASSOC);
    if (!$pump) {
        $conn->exec("INSERT INTO pump_control (id,state) VALUES (1,'OFF')");
        $pump = ['state'=>'OFF','end_time'=>null,'duration_seconds'=>0,'duration_minutes'=>0];
    }

    if ($state === "ON") {
        $end_time = $duration > 0 ? date("Y-m-d H:i:s", time() + $duration) : null;
        $stmt = $conn->prepare("UPDATE pump_control SET state='ON', start_time=NOW(), duration_seconds=?, end_time=? WHERE id=1");
        $stmt->execute([$duration, $end_time]);
        echo json_encode(['state'=>'ON','end_time'=>$end_time,'duration_seconds'=>$duration,'duration_minutes'=>floor($duration/60)]);
        exit;
    }

    if ($state === "OFF") {
        $stmt = $conn->prepare("UPDATE pump_control SET state='OFF', start_time=NULL, duration_seconds=0, end_time=NULL WHERE id=1");
        $stmt->execute();
        echo json_encode(['state'=>'OFF','end_time'=>null,'duration_seconds'=>0,'duration_minutes'=>0]);
        exit;
    }

    $pump = $conn->query("SELECT * FROM pump_control WHERE id=1")->fetch(PDO::FETCH_ASSOC);
    if ($pump['state']==='ON' && $pump['end_time'] && strtotime($pump['end_time'])<=time()){
        $stmt = $conn->prepare("UPDATE pump_control SET state='OFF', start_time=NULL, duration_seconds=0, end_time=NULL WHERE id=1");
        $stmt->execute();
        $pump['state']='OFF';
        $pump['end_time']=null;
        $pump['duration_seconds']=0;
        $pump['duration_minutes']=0;
    }

    echo json_encode([
        'state'=>$pump['state'],
        'end_time'=>$pump['end_time'],
        'duration_seconds'=>intval($pump['duration_seconds']),
        'duration_minutes'=>intval($pump['duration_minutes'])
    ]);

} catch(Exception $e){
    http_response_code(500);
    echo json_encode(['error'=>$e->getMessage()]);
}
