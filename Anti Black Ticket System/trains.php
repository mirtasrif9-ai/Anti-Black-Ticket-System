<?php require 'include/_trains.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trains Search - Chorolin Tickets</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/trains.css">
</head>

<body>
    <?php include 'include/nav.php' ?>
    <main>
        <h1><i class="fas fa-magnifying-glass"></i> Search Trains</h1>
        <section class="form-section">
            <form id="search-form" method="GET">
                <div class="form-group">
                    <label for="search">Search Train</label>
                    <input type="text" id="search" name="search"
                        placeholder="Train number or name"
                        value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="from">From Station</label>
                    <input type="text" id="from" name="from"
                        list="stations-list"
                        placeholder="Enter station name"
                        value="<?= htmlspecialchars($_GET['from'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="to">To Station</label>
                    <input type="text" id="to" name="to"
                        list="stations-list"
                        placeholder="Enter station name"
                        value="<?= htmlspecialchars($_GET['to'] ?? '') ?>">
                </div>

                <datalist id="stations-list">
                    <?php
                    $stationsResult->data_seek(0);
                    while ($station = $stationsResult->fetch_assoc()):
                    ?>
                        <option value="<?= htmlspecialchars($station['station_name']) ?>">
                        <?php endwhile; ?>
                </datalist>

                <div class="form-group">
                    <button type="submit" class="action-btn">
                        <i class="fas fa-search"></i> Search Trains
                    </button>
                </div>
            </form>
        </section>

        <div class="category-filters">
            <div class="category-chip" data-category="all">All Categories</div>
            <?php while ($cat = $categoryResult->fetch_assoc()): ?>
                <div class="category-chip"
                    data-category="<?= htmlspecialchars($cat['category']) ?>">
                    <?= htmlspecialchars($cat['category']) ?>
                </div>
            <?php endwhile; ?>
        </div>

        <section class="results-section">
            <?php if ($result->num_rows > 0): ?>
                <table class="results-table">
                    <thead>
                        <tr>
                            <th>Train Number</th>
                            <th>Train Name</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($train = $result->fetch_assoc()): ?>
                            <tr data-category="<?= htmlspecialchars($train['category']) ?>">
                                <td><?= htmlspecialchars($train['train_number']) ?></td>
                                <td><?= htmlspecialchars($train['train_name']) ?></td>
                                <td><?= htmlspecialchars($train['category']) ?></td>
                                <td>
                                    <a href="train-details.php?id=<?= $train['id'] ?>"
                                        style="color: var(--primary-color); text-decoration: none;">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-results">
                    <i class="fas fa-train" style="font-size: 3rem; color: var(--text-light);"></i>
                    <p style="margin-top: 1rem;">No trains found matching your criteria.</p>
                </div>
            <?php endif; ?>
        </section>
    </main>
    <?php include 'include/footer.php' ?>
    <script src="script/trains.js"></script>
</body>

</html>