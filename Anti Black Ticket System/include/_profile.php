<?php
require_once "include/db.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch current user details
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT name, email, phone_number FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle details update
// Handle details update
if (isset($_POST['update_details'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    
    // Check if email already exists for other users
    $check_email = "SELECT user_id FROM users WHERE email = ? AND user_id != ?";
    $check_stmt = $conn->prepare($check_email);
    $check_stmt->bind_param("si", $email, $user_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        $_SESSION['alert'] = "Email already exists. Please use a different email.";
        $_SESSION['alert_type'] = "error";
    } else {
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, phone_number = ? WHERE user_id = ?");
        $stmt->bind_param("sssi", $name, $email, $phone, $user_id);
        
        if ($stmt->execute()) {
            $_SESSION['alert'] = "Profile details updated successfully!";
            $_SESSION['alert_type'] = "success";
            header("Location: profile.php");
            exit();
        } else {
            $_SESSION['alert'] = "Error updating profile.";
            $_SESSION['alert_type'] = "error";
        }
        $stmt->close();
    }
    $check_stmt->close();
}

// Handle password update
if (isset($_POST['update_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Verify current password
    $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
    
    if (password_verify($current_password, $user_data['password'])) {
        if ($new_password === $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
            $stmt->bind_param("si", $hashed_password, $user_id);
            
            if ($stmt->execute()) {
                $_SESSION['alert'] = "Password updated successfully!";
                $_SESSION['alert_type'] = "success";
                header("Location: profile.php");
                exit();
            } else {
                $_SESSION['alert'] = "Error updating password.";
                $_SESSION['alert_type'] = "error";
            }
        } else {
            $_SESSION['alert'] = "New passwords do not match.";
            $_SESSION['alert_type'] = "error";
        }
    } else {
        $_SESSION['alert'] = "Current password is incorrect.";
        $_SESSION['alert_type'] = "error";
    }
}
?>