<?php
include('../Dashboard/connect_db.php'); // database connection


$users_send_mail = '';
if (isset($_POST['retrieveData'])) {

    $sql = "SELECT userHandle, firstName, mail
FROM user_info
WHERE personal_journal_mail = 0;";

    $result = mysqli_query($conn, $sql);

    $users_send_mail = mysqli_fetch_all($result);
}

if (isset($_POST['sendMail'])) {
    // tashin
    
foreach ($users_send_mail as $ptr) {
    $userhandle = $ptr[0];
    $surname = $ptr[1];
    $to_email = $ptr[2];


    //---------------------------------------------------------------------------------------------------------

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
}
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Mail</title>
    <link rel="icon" type="image/x-icon" href="\Admin-Panel\Kairos-removebg-preview.png">
    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="/Admin-Panel/">
</head>

<body>
    <style>
        #scroll {
            height: 500px;
        }
    </style>
    <?php include('sidebar.php'); ?>
    <main class="main-content m-0 p-0 h-100 w-100 m-0">
        <div class="row m-0">
            <div class="col-8 p-0 m-0">
                <div class="container shadow rounded h-100 w-100 p-0 m-0" id="scroll">
                    Emails..........
                    </br>
                    <?php
                    if (isset($_POST['retrieveData'])) {
                        foreach ($users_send_mail as $mail) {
                            echo $mail[2]; ?> </br>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col-4">
                <form action="SendMail.php" method="post">
                    <button type="submit" class="btn btn-primary" name="retrieveData">Retrieve Data</button>
                </form>
            </div>
        </div>
        <br>
        <form action="SendMail.php" method="post">
            <button type="submit" class="btn btn-primary" name="sendMail">Send Mail</button>
        </form>
    </main>
</body>

</html>