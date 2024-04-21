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
    $userHandle = 'antarsah';
    if(isset($_POST['update'])) {
        $morningPrayer = isset($_POST['morningPrayer']) ? 1 : 0;
        $eveningPrayer = isset($_POST['eveningPrayer']) ? 1 : 0;
        
        $sql = "INSERT INTO puja_c (userHandle, categoryID, morningPrayer, eveningPrayer) 
        VALUES ('$userHandle', (SELECT id FROM category WHERE name=(SELECT religion FROM user_info WHERE userHandle='$userHandle')), $morningPrayer, $eveningPrayer)";
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
    <title>Ritual Puja</title>
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
<?php
    include('../Includes/NavBar.php');
    include('../Includes/Sidebar.php');
    ?>

    
    <div class="container-fluid">
        <div class="justify-content-center">
                <div class="container-fluid shadow bg-custom2 p-4 rounded">
                    <div class="row justify-content-left">
                        <div>
                            <h1 class="bg-custom2">Puja</h1>
                            <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: 0%">0%</div>
                            </div>
                            <form action="Puja.php" method="post">
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="morning" id="morningPrayer" name="morningPrayer">
                                    <label class="form-check-label" for="morningPrayer">
                                        Today's Morning Prayer
                                    </label>
                                </div>
                            </div>
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="evening" id="eveningPrayer" name="eveningPrayer">
                                    <label class="form-check-label" for="eveningPrayer">
                                        Today's Evening Prayer
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
            const morningCheckbox = document.getElementById('morningPrayer');
            const eveningCheckbox = document.getElementById('eveningPrayer');
            const progressBar = document.querySelector('.progress-bar');
            morningCheckbox.addEventListener('change', updateProgress);
            eveningCheckbox.addEventListener('change', updateProgress);

            function updateProgress() {
                const progress = (morningCheckbox.checked ? 50 : 0) + (eveningCheckbox.checked ? 50 : 0);

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