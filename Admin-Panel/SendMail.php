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
}

?>
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