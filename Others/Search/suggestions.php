<?php
include('\../Kairos/Dashboard/connect_db.php'); // database connection

$userHandle = mysqli_real_escape_string($conn, 'bijoy123');

// Fetch titles
$sql = "SELECT title
        FROM user_info AS uinfo
        INNER JOIN
        notes as n
        ON uinfo.userHandle = n.userHandle
        WHERE uinfo.userHandle = '$userHandle'; ";

$result = mysqli_query($conn, $sql);
$titles = [];
while ($row = mysqli_fetch_assoc($result)) {
    $titles[] = $row['title'];
}

// Fetch details
$sql = "SELECT details
        FROM user_info AS uinfo
        INNER JOIN
        notes as n
        ON uinfo.userHandle = n.userHandle
        WHERE uinfo.userHandle = '$userHandle'; ";
$result = mysqli_query($conn, $sql);
$details = [];

while ($row = mysqli_fetch_assoc($result)) {
    $details[] = $row['details'];
}

// Merge titles and details arrays
$keywords = array_merge($titles, $details);

// Output as JSON
echo json_encode($keywords);
?>
