<?php
include '../Dashboard/connect_db.php'; // database connection

// personal_journal_mail = 0 means send
//                       = 1 means not send to that user

// admin mail send btn clicked 
//---------------------------------------------------------------------------------------------------------

$sql = "SELECT userHandle, firstName
        FROM user_info
        WHERE personal_journal_mail = 0;";

$result = mysqli_query($conn, $sql);

$notes = mysqli_fetch_all($result);

print_r($notes);
