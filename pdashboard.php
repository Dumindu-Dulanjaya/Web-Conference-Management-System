<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "irc";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch session data from the database
$sql = "SELECT * FROM sessions";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $sessions = [];
    while ($row = $result->fetch_assoc()) {
        $sessions[] = $row;
    }
} else {
    $sessions = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participant Dashboard</title>
    <link rel="stylesheet" href="pdashboard.css">
</head>
<body>
    <header>
        <h1>Participant Dashboard</h1>
    </header>
    <nav class="nav">
        <a href="#all-sessions">All Sessions</a>
        <a href="#my-sessions">My Sessions</a>
        <a href="#downloads">Downloads</a>
        <a href="web.html">Logout</a>
    </nav>
    <div class="container">
        <!-- My Sessions Section -->
        <section id="my-sessions">
            <h2>My Sessions</h2>
            <div class="card">
                <h3>Session Title 1</h3>
                <p>Details about the session...</p>
                <button class="btn">View Details</button>
            </div>
            <div class="card">
                <h3>Session Title 2</h3>
                <p>Details about the session...</p>
                <button class="btn">View Details</button>
            </div>
        </section>

        <!-- All Sessions Section -->
        <section id="all-sessions">
            <h2>All Sessions</h2>
            <?php if (!empty($sessions)): ?>
                <?php foreach ($sessions as $session): ?>
                    <div class="card">
                        <h3><?php echo htmlspecialchars($session['title']); ?></h3>
                        <p><strong>Speaker:</strong> <?php echo htmlspecialchars($session['speaker']); ?></p>
                        <p><strong>Time:</strong> <?php echo htmlspecialchars($session['time']); ?></p>
                        <p><strong>Venue:</strong> <?php echo htmlspecialchars($session['venue']); ?></p>
                        <button class="btn">Register</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No sessions available at the moment.</p>
            <?php endif; ?>
        </section>

        <!-- Downloads Section -->
        <section id="downloads">
            <h2>Downloads</h2>
            <ul>
                <li><a href="#">Download Schedule</a></li>
                <li><a href="#">Download Conference Papers</a></li>
            </ul>
        </section>

    </div>
</body>
</html>
