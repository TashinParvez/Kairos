<?php

include('../Dashboard/connect_db.php'); // database connection


$errors = array('bookName' => '', 'authorName' => '', 'descreption' => '', 'image' => '');

if (isset($_POST['submit'])) {

    if ($_FILES['image']['error'] === 0) {

        $tempname = $_FILES['image']['tmp_name'];

        // target = path to store the image
        $file_name = $_FILES['image']['name'];
        $folder = '../../Images/Books/' . $file_name;

        $new_file_name = uniqid('', true) . '_' . $file_name;
        $folder = '../../Images/Books/' . $new_file_name;

        //................ Retrieve all data  from input field ...............

        // $firstName = $_POST['firstName'];
        // $lastName = $_POST['lastName'];



        //................... escape sql chars .....................

        $bookName = mysqli_real_escape_string($conn, $_POST['bookName']);
        $authorName = mysqli_real_escape_string($conn, $_POST['authorName']);
        $details = mysqli_real_escape_string($conn, $_POST['descreption']);


        //.............. All input field validation checking ...................

        if (empty($bookName)) {
            $errors['bookName'] = 'This field cannot be empty!';
        }
        if (empty($authorName)) {
            $errors['authorName'] = 'This field cannot be empty!';
        }

        if (empty($details)) {
            $errors['details'] = 'This field cannot be empty!';
        }


        if (!array_filter($errors)) {
            $sql = "INSERT INTO life_library(bookName,authorName,details,clicked,fileName) 
                    VALUES ('$bookName','$authorName','$details' ,0,'$new_file_name')";


            $result = mysqli_query($conn, $sql); // store file name to the database

            if (move_uploaded_file($tempname, $folder)) {
                echo "File Uploaded Successfully!";
            } else {
                echo "Failed to upload file.";
            }
        }
    } else {
        // echo "Error uploading file: " . $_FILES['image']['error'];
        $errors['image'] = 'This field cannot be empty!';
    }
}



//----------------- Notes approve sql  ---------------  (Approve Button) 

$username = 'aarifeen'; // have to change
$tile = 'The Great Gatsby'; // have to change
$created = 'created_at'; // have to change

$sql1 = "UPDATE notes as n 
         SET admin_approved = 1
         WHERE n.userHandle = '$username' && title = '$tile' && created_at = '$created'";




//----------------- New Notes  --------------- ( SORT )

$noteCountsCTE = "WITH NoteCounts AS (
                        SELECT COUNT(*) AS cnt
                        FROM notes AS n
                        LEFT JOIN life_library AS l ON n.title = l.bookName
                        WHERE n.public = 1 AND n.admin_approved = 0 AND l.bookName IS NOT NULL
                    )";

// default = order by CREATED_AT DESC  -> newest first
$sql1 = $noteCountsCTE . "
        SELECT n.userHandle, n.title, n.created_at, n.details, CONCAT(LEFT(n.details, 112), '...') AS shortDesc, nc.cnt
        FROM notes AS n
        JOIN NoteCounts AS nc 
        LEFT JOIN life_library AS l ON n.title = l.bookName
        WHERE n.public = 1 AND n.admin_approved = 0 AND l.bookName IS NOT NULL
        ORDER BY n.created_at DESC;";

// Order by books popularity --> most popular book
$sql2 = $noteCountsCTE . "
        SELECT n.userHandle, n.title, n.created_at, n.details, CONCAT(LEFT(n.details, 112), '...') AS shortDesc, nc.cnt
        FROM notes AS n
        JOIN NoteCounts AS nc 
        LEFT JOIN life_library AS l ON n.title = l.bookName
        WHERE n.public = 1 AND n.admin_approved = 0 AND l.bookName IS NOT NULL
        ORDER BY l.clicked DESC;";

// order by alphabetically DESC  --> alphabetically
$sql3 = $noteCountsCTE . "
        SELECT n.userHandle, n.title, n.created_at, n.details, CONCAT(LEFT(n.details, 112), '...') AS shortDesc, nc.cnt
        FROM notes AS n
        JOIN NoteCounts AS nc 
        LEFT JOIN life_library AS l ON n.title = l.bookName
        WHERE n.public = 1 AND n.admin_approved = 0 AND l.bookName IS NOT NULL
        ORDER BY n.title;";


$result =  mysqli_query($conn, $sql3);

$newNotes = mysqli_fetch_all($result);


// foreach ($newNotes as $note) {
//     print_r($note);
// }

$bookName = '';
$authorName = '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>notes-approve</title>


    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="/Admin-Panel/">
    <link rel="stylesheet" href="path/to/your/style.css">
    <script defer src="life-library.js"></script>


</head>


<body>


    <?php
    include('admin-navbar.php');
    ?>



    <div class="container-fluid">
        <div class="row me-0 justify-content-between">
            <!------------------------------------- Sidebar ------------------------------------->
            <div class="col-2 p-0">
                <div class="block">
                    <?php include('sidebar.php'); ?>
                </div>
            </div>
            <!----------------------------------- Main Block ----------------------------------->

            <div class="col-9 p-0 me-5 ">
                <!--------- Search and filter --------->

                <div class="row">

                    <nav class="navbar bg-light col-10">
                        <div class="container-fluid">
                            <form class="d-flex" role="search">
                                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" style="width: 127vh;">
                                <button class="btn btn-outline-success" type="submit" style="position: absolute;">Search</button>
                            </form>
                        </div>
                    </nav>

                    <div class="dropdown col-2">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Filter
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="#"> newest first</a></li>
                            <li><a class="dropdown-item" href="#"> most popular book</a></li>
                            <li><a class="dropdown-item" href="#"> alphabetically</a></li>
                        </ul>
                    </div>
                </div>


                <!------------------ Books need to add ------------------>

                <div class="flex-grow-1 pt-2" style="overflow-y: auto;">
                    <div class="container-fluid" style="overflow-x: auto; white-space: nowrap;">
                        <div class="row row-cols-1 row-cols-md-5 g-4">

                            <?php foreach ($newNotes as $index => $note) { ?>
                                <!-- Card and INFO -->
                                <div class="col-lg-4">
                                    <div class="card h-100">
                                        <div class="card-body" style="max-height: 200px; overflow-y: auto;">
                                            <h5 class="card-title">
                                                <?php echo htmlspecialchars($note[1]); ?>
                                            </h5>
                                            <h6>
                                                Written by
                                                <?php echo htmlspecialchars($note[0]); ?>
                                            </h6>
                                            <div class="card-text">
                                                <?php echo htmlspecialchars($note[4]); ?>
                                            </div>

                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $index; ?>">
                                                Expand
                                            </button>
                                            <!---------------------- Modal ---------------------->
                                            <div class="modal fade" id="exampleModal<?php echo $index; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel"><?php echo htmlspecialchars($note[1]); ?></h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <?php echo htmlspecialchars($note[3]); ?>

                                                            <h6>
                                                                Written by
                                                                <?php echo htmlspecialchars($note[0]); ?>
                                                            </h6>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Approve</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>




            </div>
        </div>
    </div>



</body>

</html>