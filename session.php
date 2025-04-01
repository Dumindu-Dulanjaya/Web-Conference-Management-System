<?php
// Database configuration
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'irc');

// Establish connection to MySQL
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database if it does not exist
$sql_create_db = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
if ($conn->query($sql_create_db) !== TRUE) {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db(DB_NAME);

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
} else {
    echo "Participants table created successfully or already exists.<br>";
}



if ($conn->query($sql_create_sessions) !== TRUE) {
    die("Error creating sessions table: " . $conn->error);
} else {
    echo "Sessions table created successfully or already exists.<br>";
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
} else {
    echo "User_sessions table created successfully or already exists.<br>";
}

// Check if the `sessions` table is empty
$sql_check_sessions = "SELECT COUNT(*) as count FROM sessions";
$result = $conn->query($sql_check_sessions);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    // Insert sample data into the `sessions` table
    $sql_insert_sessions = "INSERT INTO sessions (title, speaker, time, venue) VALUES
        ('Artificial Intelligence', 'Dr. S.Senarath', '10:00:00', 'Conference Hall 1'),
        ('Cloud Computing', 'Prof. L. Kumar', '11:30:00', 'Conference Hall 2'),
        ('Biomedical Engineering', 'Dr. Alice Johnson', '13:00:00', 'Conference Hall 3'),
        ('Sustainable Energy', 'Dr. Abesekara', '14:30:00', 'Conference Hall 4'),
        ('Robotics', 'Emily Devis', '16:00:00', 'Conference Hall 5'),
        ('Cyber Security', 'Prof. Michel Brown', '17:30:00', 'Conference Hall 6')";

    if ($conn->query($sql_insert_sessions) === TRUE) {
        echo "Sample sessions inserted successfully.<br>";
    } else {
        die("Error inserting sample sessions: " . $conn->error);
    }
} else {
    echo "Sessions table already has data.<br>";
}

// Close the database connection
$conn->close();
?>
