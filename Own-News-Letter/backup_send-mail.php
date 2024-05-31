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

$users_send_mail = mysqli_fetch_all($result);

// print_r($notes);

foreach ($users_send_mail as $ptr) {
    $userhandle = $ptr[0];
    $surname = $ptr[1];

    // here bellow all code


}



//---------------------------------------------------------------------------------------------------------

$userhandle = "tashin19";
$surname = "Tashin";
$to_email = "akishor991@gmail.com";

$subject = "Your Personalized Notes and Journal from KAIROS";

//---------------------------------------------------------------------------------------------------------

$intro = "
<p>Hello $surname,</p>
<p>Welcome to your KAIROS update! Here are your recent notes and journal entries, tailored to support your personal growth and help you track your progress.</p>
<p><strong>About KAIROS</strong></p>
<p>Kairos is dedicated to aiding your personal development by encouraging positive habits, providing effective life-tracking tools, and helping you overcome negative behaviors, such as procrastination.</p>
";

$signature = "
<p>We hope these entries inspire and guide you in your journey. Remember, at KAIROS, we are here to support you every step of the way.</p>
<p>Best regards,<br>
The KAIROS Team</p><br>
<p><strong>KAIROS</strong><br>
Helping you cultivate positive habits and track your life effectively.<br>
<a href='#'>Visit our website</a><br>
<a href='#'>Follow us on Social Media</a></p>
";

//---------------------------------------------------------------------------------------------------------


//------------------------------------- sql query for the notes ------------------------------------- 

$sql = "WITH last_week_note AS (
            SELECT DISTINCT userHandle, title, details, created_at 
            FROM notes 
            WHERE userHandle = 'tashin19' 
            AND created_at >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)
            ORDER BY RAND()
            LIMIT 1
        ),
        last_month_notes AS (
            SELECT DISTINCT userHandle, title, details, created_at
            FROM notes 
            WHERE userHandle = 'tashin19'
            AND created_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
            ORDER BY RAND()
            LIMIT 3
        )

        SELECT DISTINCT userHandle, title, details, DATE(created_at) 
        FROM (
            SELECT * FROM last_week_note
            UNION ALL
            SELECT * FROM last_month_notes
        ) AS combined_notes

        HAVING IF((SELECT COUNT(*) FROM last_week_note) = 0, 2, 3) > 0;";

$result = mysqli_query($conn, $sql);

$notes = mysqli_fetch_all($result);

// print_r($notes);

$notes_for_nl = Null;

if (!empty($notes)) {
    $notes_for_nl = "<hr><div class='header-wrapper'><p class='header'><strong>Form Your Notes</strong><br></p></div><hr>";

    foreach ($notes as $ptr) {
        $notes_for_nl .= "<div class='note-row'>";
        $notes_for_nl .= " <div class='note-title'><strong>$ptr[1]</strong></div> <div class='note-date'><small>[$ptr[3]]</small></div>";
        $notes_for_nl .= "</div>";
        $notes_for_nl .= "<br>";
        $notes_for_nl .= "  $ptr[2]";
        $notes_for_nl .= "<br> <br> <br>";
    }
}

// print_r($notes_for_nl);  // after adding notes
// echo "<br>";
// echo "tashin";
// echo "<br>";


//------------------------------------- sql query for the journal ------------------------------------- 

$sql = "WITH last_week_note_from_journal AS (
            SELECT DISTINCT userHandle, title, details, lastUpdate 
            FROM personal_journal 
            WHERE userHandle = 'tashin19' 
            AND lastUpdate >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)
            ORDER BY RAND()
            LIMIT 1
        ),
        last_month_notes_from_journal AS (
            SELECT DISTINCT userHandle, title, details, lastUpdate
            FROM personal_journal 
            WHERE userHandle = 'tashin19'
            AND lastUpdate >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
            ORDER BY RAND()
            LIMIT 3
        )

        SELECT DISTINCT userHandle, title, details, DATE(lastUpdate) 
        FROM (
            SELECT * FROM last_week_note_from_journal
            UNION ALL
            SELECT * FROM last_month_notes_from_journal
        ) AS combined_notes

        HAVING IF((SELECT COUNT(*) FROM last_week_note_from_journal) = 0, 2, 3) > 0;";

$result = mysqli_query($conn, $sql);

$notes = mysqli_fetch_all($result);

// print_r($notes);

if (!empty($notes)) {
    $notes_for_nl .= "<hr><div class='header-wrapper'><p class='header'><strong>Form Your Journal</strong><br></p></div><hr>";

    foreach ($notes as $ptr) {
        $notes_for_nl .= "<div class='note-row'>";
        $notes_for_nl .= " <div class='note-title'><strong>$ptr[1]</strong></div> <div class='note-date'><small>[$ptr[3]]</small></div>";
        $notes_for_nl .= "</div>";
        $notes_for_nl .= "<br>";
        $notes_for_nl .= "  $ptr[2]";
        $notes_for_nl .= "<br> <br> <br>";
    }
}

print_r($notes_for_nl);  // after adding notes




$message = $intro . $notes_for_nl . $signature;

//---------------------------------------------------------------------------------------------------------
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: <tashinparvez2002@gmail.com>" . "\r\n";

if (mail($to_email, $subject, $message, $headers)) {
    echo "Email successfully sent to $to_email...";
} else {
    echo "Email sending failed...";
}
?>


<style>
    .header {
        text-align: center;
    }

    .header-wrapper {
        text-align: center;
    }

    .note-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .note-title {
        flex-grow: 1;
        text-align: left;
    }

    .note-date {
        text-align: right;
    }
</style>