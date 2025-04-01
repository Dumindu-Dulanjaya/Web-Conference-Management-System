<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$database = "irc";

// Establish a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $name = trim($conn->real_escape_string($_POST["name"]));
    $userType = trim($conn->real_escape_string($_POST["userType"]));
    $nic = trim($conn->real_escape_string($_POST["nic"]));
    $email = trim($conn->real_escape_string($_POST["email"]));
    $mobile = trim($conn->real_escape_string($_POST["mobile"]));
    $password_raw = $_POST["password"];

    // Validate required fields
    if (empty($name) || empty($userType) || empty($nic) || empty($email) || empty($mobile) || empty($password_raw)) {
        echo "All fields are required.";
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    // Hash the password
    $password = password_hash($password_raw, PASSWORD_BCRYPT);

    // Check if the email is already registered
    $check_email = "SELECT id FROM participants WHERE email = ?";
    $stmt = $conn->prepare($check_email);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "This email is already registered.";
        $stmt->close();
    } else {
        // Insert the new participant
        $stmt->close();
        $sql = "INSERT INTO participants (name, userType, nic, email, mobile, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("ssssss", $name, $userType, $nic, $email, $mobile, $password);

        if ($stmt->execute()) {
            // Redirect to login page
            header("Location: login.html");
            exit();
        } else {
            echo "Error executing query: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Close the connection
$conn->close();
?>
