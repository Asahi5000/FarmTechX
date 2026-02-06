<?php
require_once __DIR__."/../../../config.php"; // DB connection + API credentials

$now = new DateTime();
$hour = (int) $now->format('g');   // 1-12
$minute = (int) $now->format('i'); // 0-59
$ampm = $now->format('A');
$today = $now->format('Y-m-d');

// Fetch schedules for current time that haven't run today
$stmt = $conn->prepare("
    SELECT * FROM pump_schedule 
    WHERE hour=? AND minute=? AND ampm=? 
      AND (last_run_date IS NULL OR last_run_date<>?)
");
$stmt->execute([$hour, $minute, $ampm, $today]);
$schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$schedules) exit; // no schedule now

foreach ($schedules as $sch) {
    // Mark schedule as run today
    $update = $conn->prepare("UPDATE pump_schedule SET last_run_date=? WHERE id=?");
    $update->execute([$today, $sch['id']]);

    // --- Water Pump ---
    $water_duration = (int)$sch['water_pump_duration'] * 60; // minutes → seconds
    if ($water_duration > 0) {
        file_get_contents("http://localhost/FarmTechX/assets/php/api/pump-control.php?state=ON&duration={$water_duration}");
    }

    // --- Dosing Pumps with Delay ---
    function runDosingPump($pump, $delayMin, $durationSec) {
        if ($durationSec <= 0) return;
        $delaySec = $delayMin * 60;
        $url = "http://localhost/FarmTechX/assets/php/api/dosing-pump.php?pump={$pump}&state=ON&duration={$durationSec}";

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            pclose(popen("start /B php -r \"sleep({$delaySec}); file_get_contents('{$url}');\"", "r"));
        } else {
            exec("nohup php -r 'sleep({$delaySec}); file_get_contents(\"{$url}\");' > /dev/null 2>&1 &");
        }
    }

    runDosingPump('A', (int)$sch['dosingA_delay'], (int)$sch['dosingA_duration']);
    runDosingPump('B', (int)$sch['dosingB_delay'], (int)$sch['dosingB_duration']);
    runDosingPump('C', (int)$sch['dosingC_delay'], (int)$sch['dosingC_duration']);
}
