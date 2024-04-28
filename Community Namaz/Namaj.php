<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "kairos";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // $userHandle = $_SESSION['userHandle'];
    $userHandle = 'aarifeen';
    if(isset($_POST['update'])) {
        $fajarPrayer = isset($_POST['fajarPrayer']) ? 1 : 0;
        $dhuhrPrayer = isset($_POST['dhuhrPrayer']) ? 1 : 0;
        $asrPrayer = isset($_POST['asrPrayer']) ? 1 : 0;
        $magribPrayer = isset($_POST['magribPrayer']) ? 1 : 0;
        $ishaPrayer = isset($_POST['ishaPrayer']) ? 1 : 0;
        
        $sql = "INSERT INTO namaz_c (userHandle, categoryID, fajar, asr, dhuhr, magrib, isha) 
        VALUES ('$userHandle', (SELECT id FROM category WHERE name=(SELECT religion FROM user_info WHERE userHandle='$userHandle')), $fajarPrayer, $asrPrayer, $dhuhrPrayer, $magribPrayer, $ishaPrayer)";
        if ($conn->query($sql) === TRUE) {
        } else {
            echo json_encode(array("status" => "error", "message" => $conn->error));
        }
    }
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ritual Namaz</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>   
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Reddit+Mono:wght@200..900&display=swap');
        html,
        body {
            overflow-y: hidden;
            height: 100%;
        }
        .container-fluid {
            height: 100%;
            overflow-y: auto;
        }
        *{
            margin: 0;
            padding: 0;
            font-family: "Reddit Mono", sans-serif;
        }
        .card {
            width: 100%;
        }
        .navbar-wrapper {
            margin: 0 15px;
        }
        .card-body {
            height: 150px;
            position: relative;
        }
        .container-wrapper {
            margin: 0 15px;
        }
        .mt-auto {
            margin-top: auto;
        }
        @media (min-width: 576px) {
            .card {
                width: calc(100% - 20px);
            }
        }
        .bg-custom {
            background-color: #f6fff8 !important; 
        }
        .bg-custom2 {
            background-color: #cce3de !important;
        }
        .sidebar {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: flex-start;
            height: 100%;
        }
        .sidebar button {
            width: 100%;
        }

    </style>
</head>
<body class="bg-custom p-2 text-dark">
    <nav class="navbar navbar-expand-lg bg-custom2 m-3 shadow rounded">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="image/logo.png"Bootstrap" height="55" style="padding-left: 19px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll mx-auto" style="--bs-scroll-height: 100px;">
                    <li class="nav-item tashin">
                        <a class="nav-link active fw-bold" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item tashin ps-4">
                        <a class="nav-link active fw-bold" aria-current="page" href="#">Community</a>
                    </li>
                    <li class="nav-item tashin ps-4">
                        <a class="nav-link active fw-bold" aria-current="page" href="#">Goals</a>
                    </li>
                    <li class="nav-item tashin ps-4">
                        <a class="nav-link active fw-bold" aria-current="page" href="#">Loops</a>
                    </li>
                    <li class="nav-item tashin ps-4">
                        <a class="nav-link active fw-bold" aria-current="page" href="#">Blogs</a>
                    </li>
                    <li class="nav-item dropdown ps-4">
                        <a class="nav-link dropdown-toggle fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">More</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Exercise</a></li>
                            <hr class="dropdown-divider">
                            <li><a class="dropdown-item" href="#">Diet</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-sm-2">
                <div class="container-fluid shadow bg-custom2 p-2 rounded ">
                    <div class="sidebar">
                            <button class="btn btn-outline-primary mb-2">Button 1</button>

                            <button class="btn btn-outline-primary mb-2">Button 1</button>
       
                            <button class="btn btn-outline-primary mb-2 ">Button 1</button>
               
                            <button class="btn btn-outline-primary mb-2 ">Button 1</button>
        
                            <button class="btn btn-outline-primary mb-2 ">Button 1</button>
                        
                    </div>
                </div>
            </div>
            <div class="col-sm-10">
                <div class="container-fluid shadow bg-custom2 p-4 rounded">
                    <div class="row justify-content-left">
                        <div>
                            <h1 class="bg-custom2">Namaz</h1>
                            <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: 0%">0%</div>
                            </div>
                            <form action="Namaj.php" method="post">
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Fajar" id="fajarPrayer" name="fajarPrayer">
                                    <label class="form-check-label" for="Fajar">
                                        Fajar
                                    </label>
                                </div>
                            </div>
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Dhuhr" id="dhuhrPrayer" name="dhuhrPrayer">
                                    <label class="form-check-label" for="dhuhrPrayer">
                                        Dhuhr
                                    </label>
                                </div>
                            </div>
                            </div>
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="asr" id="asrPrayer" name="asrPrayer">
                                    <label class="form-check-label" for="asrPrayer">
                                        Asr
                                    </label>
                                </div>
                            </div>
                            </div>
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="magrib" id="magribPrayer" name="magribPrayer">
                                    <label class="form-check-label" for="magribPrayer">
                                        Magrib
                                    </label>
                                </div>
                            </div>
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="isha" id="ishaPrayer" name="ishaPrayer">
                                    <label class="form-check-label" for="ishaPrayer">
                                        Isha
                                    </label>
                                </div>
                            </div>
                            <button class="btn btn-outline-primary mb-2" type="submit" name="update">Update</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fajarCheckbox = document.getElementById('fajarPrayer');
            const dhuhrCheckbox = document.getElementById('dhuhrPrayer');
            const asrCheckbox = document.getElementById('asrPrayer');
            const magribCheckbox = document.getElementById('magribPrayer');
            const ishaCheckbox = document.getElementById('ishaPrayer');
            const progressBar = document.querySelector('.progress-bar');
            fajarCheckbox.addEventListener('change', updateProgress);
            dhuhrCheckbox.addEventListener('change', updateProgress);
            asrCheckbox.addEventListener('change', updateProgress);
            magribCheckbox.addEventListener('change', updateProgress);
            ishaCheckbox.addEventListener('change', updateProgress);

            function updateProgress() {
                const progress = (fajarCheckbox.checked ? 20 : 0) + (dhuhrCheckbox.checked ? 20 : 0) + (asrCheckbox.checked ? 20 : 0) + (magribCheckbox.checked ? 20 : 0) + (ishaCheckbox.checked ? 20 : 0);

                progressBar.style.width = progress + '%';
                progressBar.innerText = progress + '%';

                fetch('save_progress.php', {
                    method: 'POST',
                    body: JSON.stringify({ progress: progress }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data);
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
            }
        });
    </script>
</body>