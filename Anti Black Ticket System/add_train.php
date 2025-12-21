<?php require 'include/_add_train.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Train - Chorolin Tickets</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/add_train.css">
</head>

<body>
    <?php include 'include/nav.php'; ?>

    <main>
        <h1><i class="fas fa-train"></i> Add New Train</h1>

        <div class="form-section">
            <h2><i class="fa fa-subway"></i> Train Details</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="train_name">Train Name</label>
                    <input type="text" id="train_name" name="train_name" required>
                </div>

                <div class="form-group">
                    <label for="train_number">Train Number</label>
                    <input type="text" id="train_number" name="train_number" required>
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category" required>
                        <option value="">Select Category</option>
                        <?php while ($category = $categoryResult->fetch_assoc()): ?>
                            <option value="<?php echo htmlspecialchars($category['category']); ?>">
                                <?php echo htmlspecialchars($category['category']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div id="stations_container">
                    <h2><i class="fa-solid fa-landmark"></i> Stations Details</h2>
                    <!-- First Station -->
                    <div class="station-entry">
                        <div class="form-group">
                            <label>Station Name</label>
                            <input type="text" name="station_name[]" required>
                        </div>
                        <div class="form-group">
                            <label>Arrival Time</label>
                            <input type="time" name="arrival_time[]" disabled>
                        </div>
                        <div class="form-group">
                            <label>Departure Time</label>
                            <input type="time" name="departure_time[]" required>
                        </div>
                    </div>
                    <!-- Middle Station(s) -->
                    <div class="station-entry">
                        <div class="form-group">
                            <label>Station Name</label>
                            <input type="text" name="station_name[]" required>
                        </div>
                        <div class="form-group">
                            <label>Arrival Time</label>
                            <input type="time" name="arrival_time[]" required>
                        </div>
                        <div class="form-group">
                            <label>Departure Time</label>
                            <input type="time" name="departure_time[]" required>
                        </div>
                    </div>
                    <!-- Last Station -->
                    <div class="station-entry">
                        <div class="form-group">
                            <label>Station Name</label>
                            <input type="text" name="station_name[]" required>
                        </div>
                        <div class="form-group">
                            <label>Arrival Time</label>
                            <input type="time" name="arrival_time[]" required>
                        </div>
                        <div class="form-group">
                            <label>Departure Time</label>
                            <input type="time" name="departure_time[]" disabled>
                        </div>
                    </div>
                </div>

                <button type="button" onclick="addStation()" class="action-btn">Add More Station</button>
                <button type="submit" class="action-btn">Add Train</button>
            </form>
        </div>
    </main>

    <?php include 'include/footer.php'; ?>
    <script src="script/add_train.js"></script>
</body>

</html>
</html>