<?php
require_once 'include/db.php';
date_default_timezone_set('Asia/Dhaka');
$trainId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$currentDate = date("Y-m-d");
$currentTime = date("H:i:s");

$trainCategories = [
    "Commuter" => 1.5,
    "Mail" => 2.0,
    "International" => 10.0,
    "Intercity" => 4.0
];


if (isset($_POST['remove'])) {
    // First delete associated stations
    $deleteStationsQuery = "DELETE FROM train_stations WHERE train_id = ?";
    $stmtStations = $conn->prepare($deleteStationsQuery);
    $stmtStations->bind_param("i", $trainId);
    $stmtStations->execute();

    // Then delete the train
    $deleteTrainQuery = "DELETE FROM trains WHERE id = ?";
    $stmtTrain = $conn->prepare($deleteTrainQuery);
    $stmtTrain->bind_param("i", $trainId);
    $stmtTrain->execute();

    $_SESSION['alert'] = "Train removed successfully";
    $_SESSION['alert_type'] = "success";
    header("Location: trains.php");
    exit();
}

function getStationDate($station, $baseDate)
{
    $arrivalTime = strtotime($station['arrival_time']);
    $departureTime = strtotime($station['departure_time']);

    // If departure is before arrival, it means train crosses midnight
    if ($departureTime < $arrivalTime && $departureTime != NULL) {
        return date('Y-m-d', strtotime($baseDate . ' +0 day'));
    }
    return $baseDate;
}


// Fetch train details
$trainQuery = "SELECT * FROM trains WHERE id = ?";
$trainStmt = $conn->prepare($trainQuery);
$trainStmt->bind_param("i", $trainId);
$trainStmt->execute();
$trainResult = $trainStmt->get_result();
$trainDetails = $trainResult->fetch_assoc();

if (!$trainDetails) {
    $_SESSION['alert'] = "Train not found";
    $_SESSION['alert_type'] = "error";
    header("Location: index.php");
    exit();
}
$rate = $trainCategories[$trainDetails['category']];
// Fetch station details
$stationQuery = "SELECT * FROM train_stations WHERE train_id = ? ORDER BY stop_order";
$stationStmt = $conn->prepare($stationQuery);
$stationStmt->bind_param("i", $trainId);
$stationStmt->execute();
$stationsResult = $stationStmt->get_result();
$stations = [];
while ($row = $stationsResult->fetch_assoc()) {
    $stations[] = $row;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $fromStation = $_POST['from_station'];
    $toStation = $_POST['to_station'];
    $travelDate = $_POST['travel_date'];
    $passengersCount = (int)$_POST['passengers_count'];
    $passengerNames = json_encode($_POST['passenger_names']);
    $phoneNumber = $_POST['phone_number'];
    $email = $_POST['email'];
    $paymentMethod = $_POST['payment_method'];
    $selectedClass = $_POST['class'];
    $totalFare = $_POST['fare'];

    // Wallet payment logic
    if ($paymentMethod === 'Wallet') {
        $userId = $_SESSION['user_id'];
        $stmt = $conn->prepare('SELECT balance FROM users WHERE user_id = ?');
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $stmt->bind_result($balance);
        $stmt->fetch();
        $stmt->close();
        if ($balance < $totalFare) {
            $_SESSION['alert'] = 'Insufficient wallet balance! Please add funds to your wallet.';
            $_SESSION['alert_type'] = 'error';
            header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . $trainId);
            exit();
        } else {
            // Deduct fare from wallet
            $stmt = $conn->prepare('UPDATE users SET balance = balance - ? WHERE user_id = ?');
            $stmt->bind_param('di', $totalFare, $userId);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Find from and to station details
    $fromStationDetails = null;
    $toStationDetails = null;
    foreach ($stations as $station) {
        if ($station['station_name'] === $fromStation) {
            $fromStationDetails = $station;
        }
        if ($station['station_name'] === $toStation) {
            $toStationDetails = $station;
        }
    }

    // Check if train has already departed for today
    $fromStationTime = strtotime($travelDate . ' ' . $fromStationDetails['departure_time']);
    if ($fromStationTime < time()) {
        if (date('Y-m-d') === $travelDate) {
            $_SESSION['alert'] = "Train has already departed for today's date choose another date";
            $_SESSION['alert_type'] = "error";
            header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $trainId);
            exit();
        }
    }

    // Calculate correct travel date based on midnight crossing
    $fromStationDate = getStationDate($fromStationDetails, $travelDate);
    $toStationDate = getStationDate($toStationDetails, $travelDate);

    // If destination is after midnight, ensure proper date is selected
    if ($toStationDate > $fromStationDate && $travelDate === date('Y-m-d')) {
        $_SESSION['alert'] = "Selected destination requires next day's date. Please select tomorrow's date.";
        $_SESSION['alert_type'] = "error";
        header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $trainId);
        exit();
    }

    // Validate date
    if (strtotime($travelDate) < strtotime($currentDate)) {
        $_SESSION['alert'] = "Invalid travel date";
        $_SESSION['alert_type'] = "error";
        header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $trainId);
        exit();
    }

    // Insert into tickets table
    $insertQuery = "INSERT INTO tickets (user_id, from_station, to_station, travel_date, passengers_count, passenger_names, phone_number, email, payment_method, class, total_fare) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $userId = $_SESSION['user_id'];
    $insertStmt->bind_param("isssisssssi", $userId, $fromStation, $toStation, $travelDate, $passengersCount, $passengerNames, $phoneNumber, $email, $paymentMethod, $selectedClass, $totalFare);
    $insertStmt->execute();

    $_SESSION['alert'] = "Booking Successful!";
    $_SESSION['alert_type'] = "success";
    header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $trainId);
    exit();
}
