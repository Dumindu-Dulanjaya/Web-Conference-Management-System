<?php
session_start();
require_once 'db.php';

// Check if the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['userType'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Handle form submission to add a session
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['session_title'])) {
    $title = $conn->real_escape_string($_POST['session_title']);
    $description = $conn->real_escape_string($_POST['session_description']);
    $date = $_POST['session_date'];
    $speaker = $conn->real_escape_string($_POST['session_speaker']);
    $venue = $conn->real_escape_string($_POST['session_venue']);

    // Insert session into the database
    $sql_insert_session = "INSERT INTO sessions (title, description, date, speaker, venue) 
                           VALUES ('$title', '$description', '$date', '$speaker', '$venue')";

    if ($conn->query($sql_insert_session) === TRUE) {
        $message = "Session added successfully!";
    } else {
        $message = "Error adding session: " . $conn->error;
    }
}

// Fetch all sessions
$sessions_query = "SELECT * FROM sessions";
$sessions_result = $conn->query($sessions_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ITUM Research Conference 2024</title>
    <link rel="stylesheet" href="adashboard.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
    </header>

    <nav class="nav">
        <a href="#view-participants">View Participants</a>
        <a href="#add-sessions">Add Sessions</a>
        <a href="#registered-sessions">Registered Sessions</a>
        <a href="#uploads">Uploads</a>
        <a href="web.html">Logout</a>
    </nav>

    <div class="container">
        <!-- Add Sessions Section -->
        <section id="add-sessions">
            <h2>Add New Sessions</h2>
            <?php if (isset($message)) echo "<p style='color: green;'>$message</p>"; ?>
            <form action="adashboard.php" method="POST">
                <label for="session-title">Session Title:</label>
                <input type="text" id="session-title" name="session_title" required>

                <label for="session-description">Session Description:</label>
                <textarea id="session-description" name="session_description" required></textarea>

                <label for="session-date">Session Date:</label>
                <input type="date" id="session-date" name="session_date" required>

                <label for="session-speaker">Session Speaker:</label>
                <input type="text" id="session-speaker" name="session_speaker" required>

                <label for="session-venue">Session Venue:</label>
                <input type="text" id="session-venue" name="session_venue" required>

                <button type="submit" class="btn">Add Session</button>
            </form>
        </section>

        <!-- Registered Sessions Section -->
        <section id="registered-sessions">
            <h2>Registered Sessions</h2>
            <?php if ($sessions_result->num_rows > 0): ?>
                <ul>
                    <?php while ($row = $sessions_result->fetch_assoc()): ?>
                        <?php if (!isset($row['date'])) { echo "<li>Error: Date field is missing for session '{$row['title']}'</li>"; continue; } ?>
                        <li>
                            <strong><?php echo $row['title']; ?></strong> - <?php echo $row['date']; ?>
                            <br>
                            Speaker: <?php echo $row['speaker']; ?>, Venue: <?php echo $row['venue']; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No sessions have been added yet.</p>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>
