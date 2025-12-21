<?php
require_once "include/db.php";
if(isset($_GET['log_alert'])){
    $alert = "Please login to book tickets";
    $alert_type = "error";
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        $email = $conn->real_escape_string($_POST['email']);
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role'] = $user['role']?'admin':'user';
                $_SESSION['alert'] = "Login successful!";
                $_SESSION['alert_type'] = "success";
                header("Location: index.php");
                exit();
            } else {
                $alert = "Invalid email or password";
                $alert_type = "error";
            }
        } else {
            $alert = "Invalid email or password";
            $alert_type = "error";
        }
    }

    if (isset($_POST['register'])) {
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $phone = $conn->real_escape_string($_POST['phone']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $nid_number = isset($_POST['nid_number']) ? preg_replace('/[^0-9]/', '', $_POST['nid_number']) : '';
        $nid_image = $_FILES['nid_image'];

        if ($password !== $confirm_password) {
            $alert = "Passwords do not match";
            $alert_type = "error";
        } elseif (strlen($nid_number) !== 10) {
            $alert = "A valid 10-digit NID number is required.";
            $alert_type = "error";
        } elseif ($nid_image['error'] !== UPLOAD_ERR_OK) {
            $alert = "NID image upload failed.";
            $alert_type = "error";
        } else {
            // Check if email or NID already exists
            $check_sql = "SELECT * FROM users WHERE email = ? OR nid_number = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param("ss", $email, $nid_number);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows > 0) {
                $alert = "Email or NID already exists. Please use a different email and NID.";
                $alert_type = "error";
            } else {
                // Save NID image
                $ext = pathinfo($nid_image['name'], PATHINFO_EXTENSION);
                $nid_img_name = 'nid_' . time() . '_' . rand(1000,9999) . '.' . $ext;
                $upload_dir = __DIR__ . '/../uploads/nid/';
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                $target_path = $upload_dir . $nid_img_name;
                if (move_uploaded_file($nid_image['tmp_name'], $target_path)) {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO users (name, email, phone_number, password, nid_number, nid_image) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssssss", $name, $email, $phone, $hashed_password, $nid_number, $nid_img_name);

                    if ($stmt->execute()) {
                        $_SESSION['user_id'] = $conn->insert_id;
                        $_SESSION['role'] = "user";
                        $_SESSION['alert'] = "Registration successful!";
                        $_SESSION['alert_type'] = "success";
                        header("Location: index.php");
                        exit();
                    } else {
                        $alert = "Error registering user. Please try again.";
                        $alert_type = "error";
                    }
                    $stmt->close();
                } else {
                    $alert = "Failed to save NID image.";
                    $alert_type = "error";
                }
            }
            $check_stmt->close();
        }
    }

    $conn->close();
}
?>