<?php require 'include/_profile.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Chorolin Tickets</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/global.css">
</head>
<body>
    <?php include 'include/nav.php'; ?>
    
    <main>
        <h1><i class="fas fa-user"></i> Profile</h1>
        <div class="form-section">
            <h2><i class="fas fa-user-edit"></i> Update Profile Details</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone_number']); ?>" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="update_details" class="action-btn">Update Details</button>
                </div>
            </form>
        </div>

        <div class="form-section">
            <h2><i class="fas fa-lock"></i> Change Password</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="update_password" class="action-btn">Update Password</button>
                </div>
            </form>
        </div>
    </main>

    <?php include 'include/footer.php'; ?>
</body>
</html>