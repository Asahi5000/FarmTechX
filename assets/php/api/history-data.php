<?php
require_once __DIR__ . "/../../../config.php";
header("Content-Type: application/json");

// GET PARAMETERS
$filter = $_GET['filter'] ?? 'latest';
$start_date = $_GET['start_date'] ?? null;
$end_date = $_GET['end_date'] ?? null;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? max(50, (int)$_GET['limit']) : 50; // dynamic limit, min 50
$offset = ($page - 1) * $limit;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // BASE SQL
    $sql = "SELECT id, temperature, ec, ph, created_at FROM sensors WHERE 1=1";

    // FILTERS
    if ($filter === "day") $sql .= " AND DATE(created_at) = CURDATE()";
    elseif ($filter === "week") $sql .= " AND YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)";
    elseif ($filter === "month") $sql .= " AND YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = MONTH(CURDATE())";
    elseif ($filter === "range" && $start_date && $end_date) $sql .= " AND DATE(created_at) BETWEEN :start AND :end";

    // COUNT TOTAL
    $countSql = "SELECT COUNT(*) FROM ($sql) AS total_query";
    $stmtCount = $pdo->prepare($countSql);
    if ($filter === "range" && $start_date && $end_date) {
        $stmtCount->bindValue(":start", $start_date);
        $stmtCount->bindValue(":end", $end_date);
    }
    $stmtCount->execute();
    $totalRecords = $stmtCount->fetchColumn();
    $totalPages = ceil($totalRecords / $limit);

    // FINAL QUERY
    $sql .= " ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql);
    if ($filter === "range" && $start_date && $end_date) {
        $stmt->bindValue(":start", $start_date);
        $stmt->bindValue(":end", $end_date);
    }
    $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
    $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // PAGINATION ARROWS
    $maxVisiblePages = 10;
    $currentGroup = ceil($page / $maxVisiblePages);
    $startPage = ($currentGroup - 1) * $maxVisiblePages + 1;
    $endPage = min($startPage + $maxVisiblePages - 1, $totalPages);
    $hasPrev = $startPage > 1;
    $hasNext = $endPage < $totalPages;

    echo json_encode([
        "data" => $data,
        "pagination" => [
            "currentPage" => $page,
            "totalPages" => $totalPages,
            "limit" => $limit,
            "startPage" => $startPage,
            "endPage" => $endPage,
            "hasPrev" => $hasPrev,
            "hasNext" => $hasNext,
            "prevPage" => $hasPrev ? $startPage - 1 : null,
            "nextPage" => $hasNext ? $endPage + 1 : null
        ]
    ]);

} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
