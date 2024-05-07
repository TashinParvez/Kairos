<?php

include 'connect_db.php'; // database connection

$username = null;

if (isset($_POST['amaze-me-more'])) {
    
}

// ------------------------------------------------------------------------------------
// type 1 = gd
// type 0 = bad

// sql
$sql = "SELECT *
        FROM ( SELECT FLOOR(RAND() * 
                            ((SELECT COUNT(*)
                              FROM good_and_bad_things
                              WHERE userHandle = 'munna' AND type = 1 ))) AS idx) AS random_idx
        LEFT JOIN
        (   SELECT ROW_NUMBER() OVER () -1 AS index_number, gbt.*
            FROM good_and_bad_things AS gbt
            WHERE userHandle = 'munna' AND type = 1) as ntb
        ON random_idx.idx = ntb.index_number;";

$result = mysqli_query($conn, $sql);

$oneGdThing = mysqli_fetch_all($result);

mysqli_free_result($result);
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title and Description Input</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</head>

<body>

    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Jar of Happiness 1</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo htmlspecialchars($oneGdThing[0][5]); ?>
                </div>
                <div class="modal-footer">
                    <form action="jar-of-happiness.php" method="post">

                        <button class="btn btn-primary" id="amazeMeMore" type="submit" name="amaze-me-more">Amaze Me More</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Open first modal</button>

    <script>
        document.getElementById('amazeMeMore').addEventListener('click', function() {
            $('#exampleModalToggle').modal('show'); // Reopen the modal
        });
    </script>

</body>

</html>