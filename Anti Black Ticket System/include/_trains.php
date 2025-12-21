<?php
require_once 'include/db.php';

// Get distinct categories
$categoryQuery = "SELECT DISTINCT category FROM trains WHERE category IS NOT NULL";
$categoryResult = $conn->query($categoryQuery);

// Get distinct stations
$stationsQuery = "SELECT DISTINCT station_name FROM train_stations ORDER BY station_name";
$stationsResult = $conn->query($stationsQuery);

// Process search filters
$where = [];
$params = [];
$types = "";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = "%{$_GET['search']}%";
    $where[] = "(t.train_name LIKE ? OR t.train_number LIKE ?)";
    $params[] = $search;
    $params[] = $search;
    $types .= "ss";
}

if (isset($_GET['from']) && !empty($_GET['from']) && isset($_GET['to']) && !empty($_GET['to'])) {
    $where[] = "EXISTS (
    SELECT * FROM train_stations ts1 
    JOIN train_stations ts2 
    ON ts1.train_id = ts2.train_id 
    WHERE ts1.train_id = t.id 
    AND ts1.station_name = ? 
    AND ts2.station_name = ? 
    AND ts1.stop_order < ts2.stop_order
)";
    $params[] = $_GET['from'];
    $params[] = $_GET['to'];
    $types .= "ss";
}

// Build and execute the main query
$sql = "SELECT DISTINCT t.* FROM trains t";
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY t.train_number";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>