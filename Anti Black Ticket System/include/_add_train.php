<?php
require_once 'include/db.php';
$categoryQuery = "SELECT DISTINCT category FROM trains WHERE category IS NOT NULL";
$categoryResult = $conn->query($categoryQuery);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $train_name = $_POST['train_name'];
    $train_number = $_POST['train_number'];
    $category = $_POST['category'];

    $station_count = count($_POST['station_name']);
    $valid = true;
    $error = "";

    $_POST['arrival_time'][0] = null;
    $_POST['departure_time'][$station_count - 1] = null;


    // for ($i = 0; $i < $station_count; $i++) {
    //     // Skip first station arrival and last station departure validation
    //     if ($i > 0 && $i < $station_count - 1) {
    //         // Check if arrival is before departure for same station
    //         if (strtotime($_POST['arrival_time'][$i]) >= strtotime($_POST['departure_time'][$i])) {
    //             $valid = false;
    //             $error = "Station " . $_POST['station_name'][$i] . ": Arrival time must be before departure time";
    //             break;
    //         }
    //     }
    // }

    if ($valid) {
        $sql = "INSERT INTO trains (train_name, train_number, category) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $train_name, $train_number, $category);

        if ($stmt->execute()) {
            $train_id = $conn->insert_id;

            // Then insert all stations
            $station_count = count($_POST['station_name']);
            $stmt = $conn->prepare("INSERT INTO train_stations (train_id, station_name, arrival_time, departure_time, stop_order) VALUES (?, ?, ?, ?, ?)");

            for ($i = 0; $i < $station_count; $i++) {
                $station_name = $_POST['station_name'][$i];
                $arrival_time = $_POST['arrival_time'][$i] !== "" ? $_POST['arrival_time'][$i] : null;
                $departure_time = $_POST['departure_time'][$i] !== "" ? $_POST['departure_time'][$i] : null;
                $stop_order = $i + 1;

                $stmt->bind_param("isssi", $train_id, $station_name, $arrival_time, $departure_time, $stop_order);
                $stmt->execute();
            }
            $_SESSION['alert']='Train added successfully';
            $_SESSION['alert_type']='success';
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['alert']='Error adding train';
            $_SESSION['alert_type']='error';
            header("Location: add_train.php");
            exit();
        }
    } else {
        $_SESSION['alert']=$error;
        $_SESSION['alert_type']='error';
        header("Location: add_train.php");
        exit();
    }
}
?>