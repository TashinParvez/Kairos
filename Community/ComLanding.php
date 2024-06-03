<?php

// connect database
$servername = 'localhost';
$username = 'root';
$password = '';
$databasename = 'Kairos';

$conn = mysqli_connect($servername, $username, $password, $databasename);

if (!$conn) {
    exit('Sorry failed to connect: ' . mysqli_connect_error());
}


session_start(); // Start the session
// $userHandle = mysqli_real_escape_string($conn, $_SESSION['userHandle']); // after linked all page. it will be uncommented
$userHandle = mysqli_real_escape_string($conn, 'bijoy123'); // after linked all page. it will be deleted

$userHandle = 'tashin19';

// ---------------------------- Fetch all communities for segment 1
// sql query
$sql = "SELECT name, Details, cntUser, displayPicture
        FROM category
        WHERE 1;";

$result = mysqli_query($conn, $sql);
$communities = mysqli_fetch_all($result);


// ---------------------------- for Recomendation  __project
$sql = "SELECT ntc.name, ntc.Details, ntc.cntUser, ntc.displayPicture 
        FROM (SELECT name, Details, cntUser, displayPicture
              FROM category
              WHERE 1) as ntc

        INNER JOIN 

            (SELECT * 
            FROM user_interest as ui
            INNER JOIN
            interest as i
            ON ui.interestNO = i.NO
            WHERE userHandle = '$userHandle') as i_table
        ON ntc.name = i_table.Name";

$result = mysqli_query($conn, $sql);
$Recommended_comm = mysqli_fetch_all($result);

// ---------------------------- for Joined Community
$sql = "SELECT distinct ntc.name, ntc.Details, ntc.cntUser, ntc.displayPicture 
        FROM (SELECT id, name, Details, cntUser, displayPicture
                FROM category
            ) as ntc
        INNER JOIN 
            user_joined_category as uj
            ON ntc.id = uj.cat_id
        WHERE uj.userHandle = 'tashin19';";

$result = mysqli_query($conn, $sql);
$joinedCommunity = mysqli_fetch_all($result);

// ------------------------------------- inner Page search -----------------------------
$search_text = '';

if (isset($_POST['search'])) {
    $search_text = $_POST['search_field'];

    $sql = "SELECT DISTINCT name, Details, cntUser, displayPicture
            FROM category
            WHERE name LIKE '%" . $search_text . "%' || details LIKE '%" . $search_text . "%' ;";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $communities = mysqli_fetch_all($result);
    } else {
        $communities = 'Empty result!';
    }
}

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
        :root {
        --rad: .7rem;
        --dur: .3s;
        --color-dark: #2f2f2f;
        --color-light: #fff;
        --color-brand: #57bd84;
        --font-fam: 'Lato', sans-serif;
        --height: 5rem;
        --btn-width: 6rem;
        --bez: cubic-bezier(0, 0, 0.43, 1.49);
    }

    #srchForm {
        position: relative;
        max-width: 30rem;
        background: var(--color-brand);
        border-radius: var(--rad);
    }

    #srchBar,
    #btnSrch {
        height: var(--height);
        font-family: var(--font-fam);
        border: 0;
        color: var(--color-dark);
        font-size: 1.8rem;
    }

    #srchBar[type="search"] {
        outline: 0;
        width: 100%;
        background: var(--color-light);
        padding: 0 1.6rem;
        border-radius: var(--rad);
        appearance: none;
        transition: all var(--dur) var(--bez);
        transition-property: width, border-radius;
        z-index: 1;
        position: relative;
    }

    #btnSrch {
        display: none;
        position: absolute;
        top: 0;
        right: 0;
        width: var(--btn-width);
        font-weight: bold;
        background: var(--color-brand);
        border-radius: 0 var(--rad) var(--rad) 0;
    }

    #srchBar:not(:placeholder-shown) {
        border-radius: var(--rad) 0 0 var(--rad);
        width: calc(100% - var(--btn-width));

        +button {
            display: block;
        }
    }

    label {
        position: absolute;
        clip: rect(1px, 1px, 1px, 1px);
        padding: 0;
        border: 0;
        height: 1px;
        width: 1px;
        overflow: hidden;
    }

    #srchBar[type="search"] {
        width: 100%;
        /* Ensure it takes full width within form */
    }

    #srchBar:not(:placeholder-shown) {
        width: calc(100% - var(--btn-width));
        /* Adjusted width calculation */
        border-radius: var(--rad) 0 0 var(--rad);

        +button {
            display: block;
        }

    }

    #srchForm {
        position: relative;
        max-width: 30rem;
        background: var(--color-brand);
        border-radius: var(--rad);
    }

    #srchBar,
    #btnSrch {
        height: 47px;
        /* Adjust the height to 48px */
        font-family: var(--font-fam);
        border: 0;
        color: var(--color-dark);
        font-size: 1rem;
    }

    #srchBar[type="search"] {
        width: 100%;
    }

    #srchBar:not(:placeholder-shown) {
        width: calc(100% - var(--btn-width));
        border-radius: var(--rad) 0 0 var(--rad);

        +button {
            display: block;
        }
    }
    </style>
    <main class="main shadow bg-white">
        <div class="row bg-white">
            <div class="col-9 bg-white">
                <h1>Communities</h1>
            </div>

            <div class="col-3 bg-white rounded">
            <div class="rounded bg-white" style="position: sticky; z-index: 1000;">
                        <form id="srchForm" class="border shadow" onsubmit="event.preventDefault();" role="search">
                            <label for="search" style=" color:white;">Search for stuff</label>
                            <input id="srchBar" type="search" placeholder="Search..." autofocus required />
                            <button id="btnSrch" type="submit">Go</button>
                        </form>
                    </div>
            </div>

        </div>
        <div class="bg-white">

            <!----------------------- Segment 1 (All communities) ----------------------->

            <div class="row bg-white">

                <?php foreach ($communities as $ptr) { ?>
                    <div class="col-sm-auto bg-white">
                        <div class="card bg-white" style="width: 18rem;">
                            <img src="<?php echo htmlspecialchars($ptr[3]); ?>" class="card-img-top h-200 w-200 rounded" alt="...">
                            <div class="card-body bg-white">
                                <h5 class="card-title bg-white"><?php echo htmlspecialchars($ptr[0]); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($ptr[1]); ?></p>
                                <a href="\Community Namaz\Namaj_main.php" class="btn btn-primary">Visit</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
            <hr>

            <!--------------------------------- Joined community --------------------------------->

            <h4 class="bg-white">Joined Community</h4>
            <div class="row bg-white">

                <?php foreach ($joinedCommunity as $ptr) { ?>
                    <div class="col-sm-auto bg-white">
                        <div class="card bg-white" style="width: 18rem;">
                            <img src="<?php echo htmlspecialchars($ptr[3]); ?>" class="card-img-top" alt="...">
                            <div class="card-body bg-white">
                                <h5 class="card-title bg-white"><?php echo htmlspecialchars($ptr[0]); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($ptr[1]); ?></p>
                                <a href="#" class="btn btn-primary">Enter</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>

            <!--------------------------------- Recommended for you --------------------------------->

            <h4 class="bg-white">Recommended for you</h4>
            <div class="row bg-white">

                <?php foreach ($Recommended_comm as $ptr) { ?>
                    <div class="col-sm-auto bg-white">
                        <div class="card bg-white" style="width: 18rem;">
                            <img src="<?php echo htmlspecialchars($ptr[3]); ?>" class="card-img-top h-200 w-200 rounded" alt="...">
                            <div class="card-body bg-white">
                                <h5 class="card-title bg-white"><?php echo htmlspecialchars($ptr[0]); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($ptr[1]); ?></p>
                                <a href="#" class="btn btn-primary">Be the guest</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
            <!-- ----------- -->


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
            truncateText(messageElement, 10); // Adjust the word limit as needed
        });
    </script>
    
</body>

</html>