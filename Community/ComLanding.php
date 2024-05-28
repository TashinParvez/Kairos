<?php

// connect database
$servername = 'localhost';
$username = 'root';
$password = '';
$databasename = 'Kairos';

// connection obj
$conn = mysqli_connect($servername, $username, $password, $databasename);

// check connection
if (!$conn) {
    exit('Sorry failed to connect: '.mysqli_connect_error());
}

session_start(); // Start the session
// $userHandle = mysqli_real_escape_string($conn, $_SESSION['userHandle']); // after linked all page. it will be uncommented
$userHandle = mysqli_real_escape_string($conn, 'bijoy123'); // after linked all page. it will be deleted

mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community</title>
    <link rel="icon" type="image/x-icon" href="/Images/Picture1.png">
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php
        include '../Includes/NavBarSecond.php'; // uncomment
include '../Includes/Sidebar.php'; // uncomment
?>
    <style>
    .card {
        width: 300px;
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 5px;
        margin: 20px;
    }

    .card-text {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        /* Number of lines to show */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        max-height: 4.5em;
        /* Assuming a line height of 1.5em */
    }
    </style>
    <main class="main shadow bg-white">
        <div class="row bg-white">
            <div class="col-sm-6 bg-white">
                <h1>Communities</h1>
            </div>
        </div>
        <div class="bg-white">
            <div class="row bg-white">
                <div class="col-sm-auto bg-white">
                    <div class="card bg-white" style="width: 18rem;">
                        <img src="/Images/Community/PersonalGrowth.jpg" class="card-img-top" alt="...">
                        <div class="card-body bg-white">
                            <h5 class="card-title bg-white">Reflective Growth Bubble</h5>
                            <p class="card-text">Forum to Discuss about Personal problems and solutions</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-auto bg-white">
                    <div class="card bg-white" style="width: 18rem;">
                        <img src="/Images/Community/Namaz.jpg" class="card-img-top" alt="...">
                        <div class="card-body bg-white">
                            <h5 class="card-title bg-white">Rituals</h5>
                            <p class="card-text">Forum where we keep track of your Rituals</p>
                            <a href="\Community Puja\Puja.php" class="btn btn-primary">Enter</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-auto bg-white">
                    <div class="card bg-white" style="width: 18rem;">
                        <img src="/Images/Community/Books.jpg" class="card-img-top" alt="...">
                        <div class="card-body bg-white">
                            <h5 class="card-title bg-white">Bookworms</h5>
                            <p class="card-text">Where book lovers gather to explore diverse literary worlds, share
                                insights, and foster a community of passionate readers.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <h4 class="bg-white">Recommended for you</h4>
            <div class="row bg-white">
                <div class="col-sm-auto bg-white">
                    <div class="card bg-white" style="width: 18rem;">
                        <img src="/Images/Community/PersonalGrowth.jpg" class="card-img-top" alt="...">
                        <div class="card-body bg-white">
                            <h5 class="card-title bg-white">Reflective Growth Bubble</h5>
                            <p class="card-text">Forum to Discuss about Personal problems and solutions</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-auto bg-white">
                    <div class="card bg-white" style="width: 18rem;">
                        <img src="/Images/Community/Namaz.jpg" class="card-img-top" alt="...">
                        <div class="card-body bg-white">
                            <h5 class="card-title bg-white">Salah</h5>
                            <p class="card-text">Forum where we keep track of your Namaz</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-auto bg-white">
                    <div class="card bg-white" style="width: 18rem;">
                        <img src="/Images/Community/Books.jpg" class="card-img-top" alt="...">
                        <div class="card-body bg-white">
                            <h5 class="card-title bg-white">Bookworms</h5>
                            <p class="card-text">Where book lovers gather to explore diverse literary worlds, share
                                insights, and foster a community of passionate readers.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
    <script>
    function truncateText(element, wordLimit) {
        const originalText = element.innerHTML;
        const words = originalText.split(' ');

        if (words.length > wordLimit) {
            const truncatedText = words.slice(0, wordLimit).join(' ') + '...';
            element.innerHTML = truncatedText;
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const messageElement = document.getElementById('message');
        truncateText(messageElement, 20); // Adjust the word limit as needed
    });
    </script>
</body>

</html>