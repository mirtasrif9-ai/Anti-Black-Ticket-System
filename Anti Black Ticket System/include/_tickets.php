<?php
require_once "include/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Handle status updates for admin
if ($role == 'admin' && isset($_POST['update_status'])) {
    $ticket_id = $_POST['ticket_id'];
    $new_status = $_POST['new_status'];

    $stmt = $conn->prepare("UPDATE tickets SET ticket_status = ? WHERE ticket_id = ?");
    $stmt->bind_param("si", $new_status, $ticket_id);

    if ($stmt->execute()) {
        echo "<div class='alert success'>Ticket status updated successfully!</div>";
    } else {
        echo "<div class='alert error'>Error updating ticket status!</div>";
    }
}

// Handle ticket cancellation for users
if ($role == 'user' && isset($_POST['cancel_ticket'])) {
    $ticket_id = $_POST['ticket_id'];

    $stmt = $conn->prepare("UPDATE tickets SET ticket_status = 'canceled' WHERE ticket_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $ticket_id, $user_id);

    if ($stmt->execute()) {
        echo "<div class='alert success'>Ticket cancelled successfully!</div>";
    } else {
        echo "<div class='alert error'>Error cancelling ticket!</div>";
    }
}

// Fetch tickets based on role
if ($role == 'admin') {
    $query = "SELECT t.*, u.name, u.email, u.phone_number 
              FROM tickets t 
              JOIN users u ON t.user_id = u.user_id 
              ORDER BY t.booking_time DESC";
    $stmt = $conn->prepare($query);
} else {
    $query = "SELECT * FROM tickets WHERE user_id = ? ORDER BY booking_time DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
}

$stmt->execute();
$result = $stmt->get_result();
if (isset($_GET['download']) && isset($_GET['id'])) {
    $ticket_id = $_GET['id'];

    // Verify ticket access
    if ($role != 'admin') {
        $stmt = $conn->prepare("SELECT t.*, u.name, u.email FROM tickets t 
                               JOIN users u ON t.user_id = u.user_id 
                               WHERE t.ticket_id = ? AND t.user_id = ?");
        $stmt->bind_param("ii", $ticket_id, $user_id);
    } else {
        $stmt = $conn->prepare("SELECT t.*, u.name, u.email FROM tickets t 
                               JOIN users u ON t.user_id = u.user_id 
                               WHERE t.ticket_id = ?");
        $stmt->bind_param("i", $ticket_id);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $ticket = $result->fetch_assoc();

    if ($ticket) {
        // Set headers for file download
        header('Content-Type: text/html');
        header('Content-Disposition: attachment; filename="ticket_' . $ticket_id . '.html"');

        // Generate HTML ticket
        echo '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Chorolin Tickets #' . $ticket_id . '</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; padding: 20px; }
                .ticket { max-width: 800px; margin: 0 auto; border: 2px solid #2563eb; padding: 20px; }
                .header { text-align: center; border-bottom: 2px solid #2563eb; padding-bottom: 20px; margin-bottom: 20px; }
                .ticket-id { font-size: 24px; color: #2563eb; }
                .info-row { margin: 10px 0; }
                .label { font-weight: bold; color: #1f2937; }
                .status { display: inline-block; padding: 5px 10px; border-radius: 4px; }
                .status-confirmed { background: #dcfce7; color: #059669; }
                .status-pending { background: #fef3c7; color: #d97706; }
                .status-canceled { background: #fee2e2; color: #dc2626; }
                .status-expired { background: #f3f4f6; color: #6b7280; }
                .footer { margin-top: 30px; font-size: 12px; color: #6b7280; text-align: center; }
            </style>
        </head>
        <body>
            <div class="ticket">
                <div class="header">
                    <h1>Chorolin E-Ticket</h1>
                    <div class="ticket-id">Ticket #' . $ticket_id . '</div>
                </div>
                
                <div class="info-row">
                    <span class="label">Status:</span>
                    <span class="status status-' . $ticket['ticket_status'] . '">' . ucfirst($ticket['ticket_status']) . '</span>
                </div>
                
                <div class="info-row">
                    <span class="label">Passenger Name:</span> ' . htmlspecialchars($ticket['name']) . '
                </div>
                
                <div class="info-row">
                    <span class="label">Route:</span> ' . htmlspecialchars($ticket['from_station']) . ' → ' . htmlspecialchars($ticket['to_station']) . '
                </div>
                
                <div class="info-row">
                    <span class="label">Travel Date:</span> ' . date('d M Y', strtotime($ticket['travel_date'])) . '
                </div>
                
                <div class="info-row">
                    <span class="label">Class:</span> ' . htmlspecialchars($ticket['class']) . '
                </div>
                
                <div class="info-row">
                    <span class="label">Number of Passengers:</span> ' . $ticket['passengers_count'] . '
                </div>
                
                <div class="info-row">
                    <span class="label">Passenger Names:</span><br>';
        $names = json_decode($ticket['passenger_names'], true);
        if (is_array($names)) {
            foreach ($names as $name) {
                echo '- ' . htmlspecialchars($name) . '<br>';
            }
        } else {
            echo htmlspecialchars($ticket['passenger_names']);
        }
        echo '</div>
                
                <div class="info-row">
                    <span class="label">Total Fare:</span> ৳' . number_format($ticket['total_fare'], 2) . '
                </div>
                
                <div class="footer">
                    <p>This is an electronically generated ticket and does not require a physical signature.</p>
                    <p>Please carry a valid ID proof during the journey.</p>
                    <p>Generated on: ' . date('d M Y H:i:s') . '</p>
                </div>
            </div>
        </body>
        </html>';
        exit();
    }
}
?>