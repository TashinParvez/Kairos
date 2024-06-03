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

// print_r($notes);

// for journal

$sql = "SELECT title, details, created_at, YEAR(CURDATE())-YEAR(created_at) AS years_ago
        FROM personal_journal
        WHERE userHandle = 'tashin19'
        AND MONTH(created_at) = MONTH(CURDATE())
        AND DAY(created_at) = DAY(CURDATE())
        AND YEAR(created_at) < YEAR(CURDATE());";

$result = mysqli_query($conn, $sql);

$journals = mysqli_fetch_all($result);

//----------------------- turn off/On personal Journal btn clicked --------------------------
$sql = "SELECT personal_journal_mail 
FROM user_info
WHERE userHandle = '$userHandle'";
$result = mysqli_query($conn, $sql);
$flag = mysqli_fetch_all($result);
$flag = $flag[0][0];

if (isset($_POST['flexSwitchCheckDefault'])) {


    print($flag);
    echo 'executed';

    if ($flag == 1) {
        $sql = "UPDATE user_info
            SET personal_journal_mail = 0
            WHERE userHandle = '$userHandle';";
        $result = mysqli_query($conn, $sql);
    } else {
        $sql = "UPDATE user_info
            SET personal_journal_mail = 1
            WHERE userHandle = '$userHandle';";
        $result = mysqli_query($conn, $sql);
    }
}



// --------------------------------------


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kairos</title>
    <link rel="icon" type="image/x-icon" href="/Images/Picture1.png">
    </link>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Includes/style.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    <style>
        .bg-custom {
            background-color: #f1f4fb;
        }
    </style>
</head>

<body class="bg-custom p-0">
    <?php
    include '../Includes/NavBarSecond.php'; // uncomment
    include '../Includes/Sidebar.php'; // uncomment
    include '../Includes/HappyJar.php'; // uncomment
    ?>
    <main class=" main bg-white shadow z-0 pr-0">
        <div class="row bg-white">
            <div class="col-auto bg-white rounded">
                <img src="else.svg" alt="" class="rounded">
            </div>
            <div class="col-auto bg-transparent mb-3" style="align-items:center;">
                <h1 class="bg-transparent">How was this day back then</h1>
                <br>
                <blockquote class="blockquote mb-0">
                    <p class="bg-white">Memories are the key not to the past, but to the future.</p>
                    <footer class="blockquote-footer bg-white">Corrie Ten Boom
                    </footer>
                </blockquote>
                <br>
                <div class="form-check form-switch bg-white m-0 p-0">
                    <form action="Memories.php" method="POST" class="bg-white m-0 p-0">
                        <!-- <button type="submit">
                            <input class="form-check-input bg-transparent" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="flexSwitchCheckDefault" <?php if ($flag == 1) echo 'checked'; ?> >
                            <label class="form-check-label bg-transparent" for="flexSwitchCheckDefault">Switch of notifiation
                                about
                                Memories</label>
                        </button> -->

                        <button class="btn btn-primary" type="submit" name="flexSwitchCheckDefault">
                            <?php if ($flag == 0) {
                                echo 'I Dont Want Mail';
                            } else {
                                echo 'I Want Mail';
                            }
                            ?>
                        </button>

                    </form>

                </div>
            </div>
            <!-- -------------------------------Notes--------------------------------------- -->

            <?php
            if ($notes != null && !empty($notes)) { ?>

                <h4 class="bg-white">Notes</h4>
                <hr>
                <?php foreach ($notes as $ptr) { ?>
                    <div class="row bg-transparent pt-3 pr-4">
                        <div class="card m-2 mr-4 p-2 bg-transparent shadow">
                            <!--  title, details, created_at, YEAR(CURDATE())-YEAR(created_at) AS years_ago -->
                            <!-- <h5 class="card-title bg-transparent"> <?php echo htmlspecialchars($ptr[0]); ?></h5> -->
                            <h5 class="card-header bg-transparent">Date without time:
                                <?php echo htmlspecialchars($ptr[2]); ?>
                            </h5>
                            <div class="card-body bg-transparent">
                                <h5 class="card-title bg-transparent"> <?php echo htmlspecialchars($ptr[0]); ?></h5>
                                <p class="card-text bg-transparent">
                                    <?php echo htmlspecialchars($ptr[1]); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <br>
                <?php } ?>
            <?php } ?>

            <!-- -------------------------------Journal-------------------------------------- -->

            <?php
            if ($journals != null && !empty($journals)) { ?>
                <h4 class="bg-white">Journals</h4>
                <hr>
                <?php foreach ($journals as $ptr) { ?>
                    <div class="row bg-transparent pt-3 pr-4">
                        <div class="card m-2 mr-4 p-2 bg-transparent shadow">
                            <!--  title, details, created_at, YEAR(CURDATE())-YEAR(created_at) AS years_ago -->
                            <h5 class="card-header bg-transparent">Date without time:
                                <?php echo htmlspecialchars($ptr[2]); ?>
                            </h5>
                            <div class="card-body bg-transparent">
                                <h5 class="card-title bg-transparent"> <?php echo htmlspecialchars($ptr[0]); ?></h5>
                                <p class="card-text bg-transparent">
                                    <?php echo htmlspecialchars($ptr[1]); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <br>
                <?php } ?>
            <?php } ?>
            <!-- --------------------------------- -->

        </div>
    </main>
</body>

</html>