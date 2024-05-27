<?php
include '../Dashboard/connect_db.php'; // database connection
$userHandle = 'tashin19';


// for notes 

$sql = "SELECT title, details, created_at, YEAR(CURDATE())-YEAR(created_at) AS years_ago
        FROM notes
        WHERE userHandle = '$userHandle'
        AND MONTH(created_at) = MONTH(CURDATE())
        AND DAY(created_at) = DAY(CURDATE())
        AND YEAR(created_at) < YEAR(CURDATE());";

$result = mysqli_query($conn, $sql);

$notes = mysqli_fetch_all($result);

print_r($notes);


// for journal

$sql = "SELECT title, details, created_at, YEAR(CURDATE())-YEAR(created_at) AS years_ago
        FROM personal_journal
        WHERE userHandle = 'tashin19'
        AND MONTH(created_at) = MONTH(CURDATE())
        AND DAY(created_at) = DAY(CURDATE())
        AND YEAR(created_at) < YEAR(CURDATE());";

$result = mysqli_query($conn, $sql);

$notes = mysqli_fetch_all($result);

print_r($notes);


