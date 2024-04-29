<?php
// Assuming you have already established a connection to your database
// Replace 'your_database_host', 'your_username', 'your_password', and 'your_database_name' with your actual database credentials
$conn = new mysqli('localhost', 'root', '', 'kairos');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the count of assigned users
$sql = "SELECT COUNT(*) AS total_assigned_users FROM user_info";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<p>Total Assigned Users: " . $row["total_assigned_users"] . "</p>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Hero Page</title>
</head>
<body>
    <div>
        <h1>Welcome to the Hero Page!</h1>
    </div>
</body>
</html>
