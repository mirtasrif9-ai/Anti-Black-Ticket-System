<?php require 'include/_train-details.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($trainDetails['train_name']) ?>Train Details - Chorolin Tickets</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/train-details.css">
</head>

<body>
    <?php include "include/nav.php" ?>
    <main>
        <section class="train-header">
            <div class="train-title">
                <h1><?= htmlspecialchars($trainDetails['train_name']) ?></h1>
                <span class="train-number"><?= htmlspecialchars($trainDetails['train_number']) ?></span>
            </div>
            <div class="train-info">
                <div class="info-card">
                    <strong>Category:</strong> <?= htmlspecialchars($trainDetails['category']) ?>
                </div>
                <div class="info-card">
                    <strong>Current Date:</strong> <?= date("l, d F Y") ?>
                </div>
                <div class="info-card">
                    <strong>Current Time:</strong> <?= date("h:i A") ?>
                </div>
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <form method="post" class="info-card" onsubmit="return confirm('Are you sure you want to remove this train?')">
                    <button type="submit" name="remove" class="action-btn cancel-btn">Remove Train</button>
                </form>
                <?php endif;?>
            </div>
        </section>
        <section class="form-section">
            <form method="POST">
                <input type="hidden" name="fare" id="fare">
                <div class="form-group">
                    <label for="from_station">From Station:</label>
                    <select name="from_station" id="from_station" required>
                        <?php foreach (array_slice($stations, 0, -1) as $station): ?>
                            <option value="<?= htmlspecialchars($station['station_name']) ?>"> <?= htmlspecialchars($station['station_name']) ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="to_station">To Station:</label>
                    <select name="to_station" id="to_station" required>
                        <?php foreach (array_slice($stations, 1) as $station): ?>
                            <option value="<?= htmlspecialchars($station['station_name']) ?>">
                                <?= htmlspecialchars($station['station_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="travel_date">Travel Date:</label>
                    <input type="date" name="travel_date" id="travel_date" min="<?= $currentDate ?>" required>
                </div>

                <div class="form-group">
                    <label for="passengers_count">Number of Passengers:</label>
                    <input type="number" name="passengers_count" id="passengers_count" min="1" max="4" required>
                </div>

                <div class="form-group">
                    <label for="phone_number">Phone Number:</label>
                    <input type="text" name="phone_number" id="phone_number" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required>
                </div>

                <div class="form-group">
                    <label for="class" class="form-label">Select Class:</label>
                    <select name="class" id="class" class="form-select" required>
                        <option value="" disabled selected>Select Class</option>
                        <option value="S_Chair" data-base-fare="10">S_Chair</option>
                        <option value="F_Chair" data-base-fare="14">F_Chair</option>
                        <option value="Snigda" data-base-fare="20">Snigda</option>
                    </select>
                </div>

                <div class="form-group">
                    
                    
                    <label for="payment_method" class="form-label">Select Payment Method:</label>
                    <select name="payment_method" id="payment_method" class="form-select" required>
                        <option value="" disabled selected>Select Method</option>
                        <option value="Wallet">Wallet</option> 
                        <option value="Bkash">Bkash</option>
                        <option value="Nagad">Nagad</option>
                    </select> 
                </div>

                <div class="form-group">
                    <span id="fareDisplay">Fare: ৳ 00.00</span>
                </div>

                <div class="form-group">
                    <button class="action-btn"
                        <?php echo isset($_SESSION['user_id']) ? 'type="submit"' : 'onclick="loginRedirect()"' ?>>
                        Book Ticket
                    </button>
                </div>
            </form>
        </section>

        <section class="station-timeline">
            <h2>Station Schedule</h2>
            <?php
            $prevDate = $currentDate;
            $totalStations = count($stations);
            $currentIndex = 0;
            $prevDepartureTime = null; // Store previous station's departure time

            foreach ($stations as $station):
                $currentIndex++;
                $arrivalTime = strtotime($station['arrival_time']);
                $departureTime = strtotime($station['departure_time']);
                $currentTimeStamp = strtotime($currentTime);

                // Check if train crosses midnight from the previous station
                if ($prevDepartureTime !== null && $arrivalTime < $prevDepartureTime) {
                    $prevDate = date('Y-m-d', strtotime($prevDate . ' +1 day'));
                }

                // Check if train crosses midnight within the current station
                if ($departureTime < $arrivalTime) {
                    $prevDate = date('Y-m-d', strtotime($prevDate . ' +1 day'));
                }

                // Check booking availability only if it's not the last station
                $canBook = ($currentIndex < $totalStations) && (strtotime($prevDate . ' ' . $station['departure_time']) > time());

                // Store current station's departure for the next iteration
                $prevDepartureTime = $departureTime;
            ?>
                <div class="timeline-item">
                    <div class="station-dot"></div>
                    <div class="station-info">
                        <div>
                            <h3><?= htmlspecialchars($station['station_name']) ?></h3>
                            <span class="booking-status 
            <?= $currentIndex == $totalStations ? 'status-unavailable' : ($canBook ? 'status-available' : 'status-unavailable') ?>">
                                <?= $currentIndex == $totalStations ? 'Last Station' : ($canBook ? 'Booking Available' : 'Train Departed') ?>
                            </span>
                        </div>
                        <div class="time-info">
                            <div>Arrival: <?= $arrivalTime ? date('h:i A', $arrivalTime) : 'Start Station' ?></div>
                            <div>Departure: <?= $departureTime ? date('h:i A', $departureTime) : 'Last Station' ?></div>
                            <div>
                                <?= date('d M Y', strtotime($prevDate)) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
    </main>
    <?php include "include/footer.php" ?>
    <script>
        const stationSchedule = <?php echo json_encode($stations); ?>;
        const trainRate = <?php echo $rate; ?>;
    </script>
    <script src="script/train-details.js"></script>
    <script>
document.getElementById('makePaymentBtn').onclick = function() {
  window.location.href = 'payment.php';
};
</script>
</body>

</html>