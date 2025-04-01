<?php
// Database connection configuration
$servername = "localhost";  // Database server (default: localhost)
$username = "root";         // Database username
$password = "";             // Database password
$dbname = "irc";            // Database name

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database if it doesn't exist
$sql_create_db = "CREATE DATABASE IF NOT EXISTS " . $dbname;
if ($conn->query($sql_create_db) !== TRUE) {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($dbname);

// Create the `participants` table
$sql_create_participants = "CREATE TABLE IF NOT EXISTS participants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    mobile_number VARCHAR(15) NOT NULL,
    nic_number VARCHAR(20) NOT NULL,
    userType ENUM('participant', 'admin') NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql_create_participants) !== TRUE) {
    die("Error creating participants table: " . $conn->error);
}

// Create the `sessions` table
$sql_create_sessions = "CREATE TABLE IF NOT EXISTS sessions (
    session_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    date DATE NOT NULL,
    speaker VARCHAR(255) NOT NULL,
    venue VARCHAR(255) NOT NULL
)";
if ($conn->query($sql_create_sessions) !== TRUE) {
    die("Error creating sessions table: " . $conn->error);
}

// Create the `user_sessions` table
$sql_create_user_sessions = "CREATE TABLE IF NOT EXISTS user_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    session_id INT NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES participants(id),
    FOREIGN KEY (session_id) REFERENCES sessions(session_id),
    UNIQUE KEY unique_registration (user_id, session_id)
)";
if ($conn->query($sql_create_user_sessions) !== TRUE) {
    die("Error creating user_sessions table: " . $conn->error);
}

// Insert sample data into the `sessions` table if empty
$sql_check_sessions = "SELECT COUNT(*) as count FROM sessions";
$result = $conn->query($sql_check_sessions);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sql_insert_sessions = "INSERT INTO sessions (title, description, date, speaker, venue) VALUES
        ('Artificial Intelligence', 'Discussion on the future of AI.', '2024-05-10', 'Dr. S. Senarath', 'Conference Hall 1'),
        ('Cloud Computing', 'Exploring the latest in cloud technologies.', '2024-05-11', 'Prof. L. Kumar', 'Conference Hall 2'),
        ('Biomedical Engineering', 'Advancements in medical technologies.', '2024-05-12', 'Dr. Alice Johnson', 'Conference Hall 3'),
        ('Sustainable Energy', 'Green energy solutions for the future.', '2024-05-13', 'Dr. Abesekara', 'Conference Hall 4'),
        ('Robotics', 'Innovations in robotics and AI.', '2024-05-14', 'Emily Devis', 'Conference Hall 5'),
        ('Cyber Security', 'Securing our digital world.', '2024-05-15', 'Prof. Michael Brown', 'Conference Hall 6')";
    if ($conn->query($sql_insert_sessions) !== TRUE) {
        die("Error inserting sample sessions: " . $conn->error);
    }
}

// The database connection remains open for further use
?>
