<?php require_once 'include/db.php'; ?>

<nav class="navbar">
    <a href="index.php" class="logo">
        <i class="fas fa-train"></i> CHOROLIN TICKETS
    </a>
    <button class="mobile-menu-btn">
        <i class="fas fa-bars"></i>
    </button>
    <div class="nav-links">
        <a href="index.php"><i class="fas fa-home"></i> Home</a>
        <a href="trains.php"><i class="fas fa-train"></i> Trains</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="dropdown">
                <a><i class="fas fa-user"></i> Actions <i class="fas fa-chevron-down"></i></a>
                <div class="dropdown-content">
                    <a href="profile.php">Update Profile</a>
                    <a href="tickets.php">View Tickets</a>
                    <a href="wallet.php">Wallet</a>
                    <?php if ($_SESSION['role'] === "admin"): ?>
                        <a href="add_train.php">Add Train</a>
                    <?php endif; ?>
                </div>
            </div>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        <?php else: ?>
            <a href="login.php"><i class="fas fa-sign-in-alt"></i> Login/Signup</a>
        <?php endif ?>
    </div>
    <?php if (isset($_SESSION['alert']) && isset($_SESSION['alert_type'])): ?>
        <div class="alert <?php echo $_SESSION['alert_type']; ?>"><?php echo $_SESSION['alert']; ?></div>
    <?php
        unset($_SESSION['alert'], $_SESSION['alert_type']);
    endif; ?>
</nav>