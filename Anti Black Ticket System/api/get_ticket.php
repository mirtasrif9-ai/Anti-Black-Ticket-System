<?php
header('Content-Type: application/json');

// Database connection
$conn = new mysqli("localhost", "root", "", "railway");
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

$ticket_id = isset($_GET['ticket_id']) ? intval($_GET['ticket_id']) : 0;
if (!$ticket_id) {
    http_response_code(400);
    echo json_encode(["error" => "Missing or invalid ticket_id"]);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM tickets WHERE ticket_id = ?");
$stmt->bind_param("i", $ticket_id);
$stmt->execute();
$result = $stmt->get_result();

if ($ticket = $result->fetch_assoc()) {
    echo json_encode($ticket);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Ticket not found"]);
}
$stmt->close();
$conn->close();
?>
