<?php

include '../Dashboard/connect_db.php'; // Daatabase connection

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- CSS -->
    <style>
        .floating-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 30px;
            /* Decreased width */
            height: 30px;
            /* Decreased height */
            background-color: #007bff;
            color: #ffffff;
            /* Changed to white */
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            /* Adjusted line-height */
            font-size: 16px;
            /* Adjusted icon size */
            cursor: pointer;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
            /* Changed shadow color to gray */
            transition: transform 0.3s ease;
        }

        .floating-button:hover {
            transform: scale(1.1);
        }

        .floating-button i {
            color: rgba(255, 255, 255, 0.8);
        }
    </style>

    <!-- JD -->
    <script>
        window.addEventListener('scroll', function() {
            console.log('Scrolling...');
            var goalButton = document.getElementById('goalButton');
            console.log('Scroll Y:', window.scrollY);
            if (window.scrollY > 100) {
                goalButton.style.display = 'none';
            } else {
                goalButton.style.display = 'block';
            }
        });
    </script>

    <!-- <link rel="stylesheet" href="../Includes/style.css"> -->
    <!-- uncomment -->

</head>

<body>
    <?php
    include '../Includes/NavBar.php'; // uncomment
include '../Includes/Sidebar.php'; // uncomment
?>


    <!-- ------------------------ Main Segment ------------------------------- -->

    <main class="main shadow">

        <div class="container text-center">
            <div class="row align-items-stretch">
                <div class="col-9">
                    1 of 2
                    1 of 2
                    1 of 2
                    1 of 2
                    1 of 2
                    1 of 2
                    1 of 2
                    1 of 2
                </div>
                <div class="col" style="height: 15vh; overflow-y: auto;">
                    2 of 2
                    2 of 2
                    2 of 2
                </div>
            </div>

            <div class="container text-center">
                <div class="row align-items-end">
                    <!-- time exceded goals -->
                    <?php
                // loop starts here
                foreach ($goals as $goal) {
                    ?>
                        <div class="card mb-1" style="background: snow;">
                            <div class="card-body">
                                <!-- each goal -->

                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div class="row align-items-end">
                    <div class="row align-items-end">
                        <!-- create -->
                    </div>

                    <div class="row align-items-end">
                        <!-- show goals -->
                        <?php
                        // loop starts here
                        foreach ($goals as $goal) {
                            ?>
                            <div class="card mb-1" style="background: snow;">
                                <div class="card-body">
                                    <!-- each goal -->

                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Plus icon for creating a goal -->
    <div id="goalButton" class="floating-button">
        <i class="fas fa-plus"></i>
    </div>

</body>

</html>