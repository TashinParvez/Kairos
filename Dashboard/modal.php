<?php

include 'connect_db.php'; // database connection

$username = null;

// ------------------------------------------------------------------------------------
// Submit or Skip

if (isset($_POST['skip'])) {
    // Skip
    $sql = "UPDATE user_info
        SET interestSet = 0
        WHERE userHandle = '$username'";

    // save to db and check
    if (mysqli_query($conn, $sql)) {
        // success
        header('Location: DashboardMain.php');
    } else {
        echo 'query error: '.mysqli_error($conn);
    }

    // close connection
    mysqli_close($conn);
}

if (isset($_POST['save'])) {
    // Save
}

// Submit --> to submit user have to choose atleat 1 interest
$sql = "UPDATE user_info
        SET interestSet = 1
        WHERE userHandle = '$username'";

// loop run here
$sql = "INSERT INTO `user_interest` (`userHandle`, `interestNO`) 
        VALUES ('$username', '7');";

// for others

$otherdata = ''; // other box data

$dataArray = explode(',', $otherdata);

$resultArray = [];

foreach ($dataArray as $value) {
    $parts = explode(' ', $value);
    $parts = array_filter($parts);
    $trimmedValue = implode(' ', array_map('trim', $parts));
    $resultArray[] = $trimmedValue;
}

// print_r($resultArray);

foreach ($resultArray as $value) {
    // check for already present or not
    $sql = "SELECT *
            FROM interest
            WHERE LOWER(Name) = LOWER('$value');";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0) { // Value is not present
        // push in the interest table
        $sql = "INSERT INTO `interest` (`NO`, `Name`, `imageUrl`) 
                VALUES (NULL, '$value', '');";
        $result = mysqli_query($conn, $sql);

        // creating user and interest table connection
        $sql = "INSERT INTO user_interest (userHandle, interestNO)
                SELECT '$username', NO
                FROM interest
                WHERE Name = '$value';";

        $result = mysqli_query($conn, $sql);
    }
}

// ------------------------------------------------------------------------------------
// sql query  for interest
$sql = 'SELECT *
        FROM interest
        LIMIT 10';

$result = mysqli_query($conn, $sql);

$interests = mysqli_fetch_all($result);

// print_r($interests);

// sql query  for other interest datalist option
$sql = 'SELECT *
        FROM interest
        LIMIT 5
        OFFSET 10;';

$result = mysqli_query($conn, $sql);

$otherinterests = mysqli_fetch_all($result);

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <!-- JavaScript to Open Modal Automatically -->
    <script>
    // Use window.onload to execute code when the page finishes loading
    window.onload = function() {
        // Select the modal element by its ID
        var modal = document.getElementById('exampleModalXl');
        // Create a new Bootstrap modal instance
        var modalInstance = new bootstrap.Modal(modal);
        // Open the modal
        modalInstance.show();
    };
    </script>
    <!-- extra Large Modal For Interest Page -->

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalXl">
        Extra large modal
    </button>

    <div class="modal fade" id="exampleModalXl" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="exampleModalXlLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" style="width: 85%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="exampleModalXlLabel">Your Interest</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="justify-content:center; align-items:center;">
                    <!-- main-Body -->
                    <!-- Checkboxes -->
                    <form action="modal.php" method="POST">

                        <?php
                        foreach ($interests as $key => $interest) { // Use $key as a unique identifier
                            ?>
                        <div class="form-check form-check-inline" style="justify-content:center; align-items:center;">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox<?php echo $key; ?>"
                                value="option1">
                            <!-- Use unique ID for each checkbox -->
                            <label class="form-check-label" for="inlineCheckbox<?php echo $key; ?>"
                                style="white-space: nowrap;">
                                <div class="card mb-3">
                                    <div class="row g-0" style="height:50px;">
                                        <div class="col-md-4" style="width: 50px; height:10px;">
                                            <img src="<?php echo htmlspecialchars($interest[2]); ?>"
                                                class="img-fluid rounded-start" alt="...">
                                        </div>
                                        <div class="col-md-8" style="width:fit-content;">
                                            <div class="card-body" style="width:fit-content;">
                                                <h5 class="card-title" style="width:fit-content;">
                                                    <?php echo htmlspecialchars($interest[1]); ?> </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <?php } ?>


                        <!-- Others interest -->
                        <br>

                        <label for="exampleDataList" class="form-label">Others</label>
                        <input class="form-control" list="datalistOptions" id="exampleDataList"
                            placeholder="Example: Riding, Cycling,...">
                        <datalist id="datalistOptions">
                            <?php
                                foreach ($otherinterests as $key => $interest) { // Use $key as a unique identifier
                                    ?>
                            <option value="<?php echo htmlspecialchars($interest[1]); ?>">
                                <?php } ?>
                        </datalist>
                        <br>
                        <div class="container d-flex justify-content-end">
                            <button type="submit" name="skip" class="btn btn-outline-secondary">Skip</button>
                            <button type="submit" name="save" class="btn btn-outline-secondary">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</body>

</html>