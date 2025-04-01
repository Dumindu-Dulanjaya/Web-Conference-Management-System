<?php
session_start();
require_once 'db.php'; // Ensure the database connection is available

// Clear any existing session data
if (isset($_SESSION['user_id'])) {
    session_destroy();
    session_start();
}

// Process login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userType = $_POST['userType'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check user credentials
    $stmt = $conn->prepare("SELECT * FROM participants WHERE email = ? AND userType = ?");
    if ($stmt) {
        $stmt->bind_param("ss", $email, $userType);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['userType'] = $user['userType'];

                // Redirect based on user type
                if ($userType === "participant") {
                    header("Location: pdashboard.php");
                } elseif ($userType === "admin") {
                    header("Location: adashboard.php");
                }
                exit;
            } else {
                $error_message = "Invalid password.";
            }
        } else {
            $error_message = "Invalid email or user type.";
        }

        $stmt->close();
    } else {
        $error_message = "Query preparation failed: " . $conn->error;
    }
}

// Display the error message if any
if (!empty($error_message)) {
    echo "<p style='color: red;'>$error_message</p>";
}
?>
