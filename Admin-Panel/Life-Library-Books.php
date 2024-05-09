<?php

include('../Dashboard/connect_db.php'); // database connection
$bookName = $authorName = '';

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



//----------------- New Book  ---------------
// new written book show to the admin to add in life library
$sql = "SELECT 
        CASE 
            WHEN LENGTH(n.title) > 20 THEN CONCAT(LEFT(n.title, 12), '...')
            ELSE n.title
        END AS title, n.title, n.userHandle, created_at
        FROM notes AS n
        LEFT JOIN life_library AS li ON LOWER(TRIM(n.title)) = LOWER(TRIM(li.bookName))
        WHERE n.public = 1 AND li.bookName IS NULL";


// Set default value for order if not provided
$order = isset($_POST['order']) ? $_POST['order'] : 'newest';

// Determine which item was clicked based on the value of $order
switch ($order) {
    case 'newest':

        // default = order by CREATED_AT DESC  -> newest first
        $sql = $sql . "
                ORDER BY created_at";
        break;
    case 'popular_user':

        // Order by books popularity --> most popular book
        $sql = $sql . "
                ";  // Tashin
        break;
    case 'alphabetical':

        // order by alphabetically DESC  --> alphabetically
        $sql = $sql . "
                ORDER BY n.title;";
        break;
    default:
        // Handle other cases if needed
        break;
}

$result =  mysqli_query($conn, $sql);
$newBooks = mysqli_fetch_all($result);

// for memory free
mysqli_free_result($result);
// close connection
mysqli_close($conn);

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

                        <!-- Filtered by -->
                        <script>
                            function submitForm(order) {
                                document.getElementById('orderInput').value = order;
                                document.getElementById('orderForm').submit();
                            }
                        </script>

                        <form id="orderForm" action="Life-Library-Books.php" method="post">
                            <input type="hidden" name="order" id="orderInput">
                        </form>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="#" onclick="submitForm('newest')"> newest first</a></li>
                            <li><a class="dropdown-item" href="#" onclick="submitForm('popular_user')"> most popular book</a></li>
                            <li><a class="dropdown-item" href="#" onclick="submitForm('alphabetical')"> alphabetically</a></li>
                        </ul>

                        <!-- ............... -->
                    </div>
                </div>

                <div class="flex-grow-1 pt-2" style="overflow-y: auto;">
                    <div class="container-fluid" style="overflow-x: auto; white-space: nowrap;">
                        <div class="row row-cols-1 row-cols-md-5 g-4">

                            <?php foreach ($newBooks as $index => $book) { ?>

                                <!-- Card and INFO -->
                                <div class="col-lg-4">
                                    <div class="card h-100">

                                        <!-- Link with onclick event to submit form via POST -->
                                        <!-- <button type="button" class="card-link btn btn-link" data-bs-toggle="modal" data-bs-target="#exampleModal" style="text-decoration: none; color: inherit;" onclick="populateModal()"> -->
                                        <button type="button" class="card-link btn btn-link" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $index; ?>" style="text-decoration: none; color: inherit;">
                                            <div class="card-body" style="max-height: 200px; overflow-y: auto;">
                                                <h5 class="card-title">
                                                    <?php echo htmlspecialchars($book[0]); ?>
                                                </h5>
                                                <h6>
                                                    <p class="card-text">Note published by <br>
                                                        <?php echo htmlspecialchars($book[2]); ?>
                                                    </p>
                                                </h6>
                                            </div>
                                        </button>
                                    </div>
                                </div>

                                <!---------------------- Modal ---------------------->
                                <div class="modal fade" id="exampleModal<?php echo $index; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <form method="POST" action="Life-Library-Books.php" enctype="multipart/form-data">

                                                <?php $book_title = $book[1]; ?>
                                                <div class="form-group">
                                                    <label for="fullName">Book Name</label>
                                                    <input type="text" name="bookName" class="form-control" id="bookName" placeholder="" value="<?php echo htmlspecialchars($bookName); ?>">
                                                    <div class="text-red"><?php echo $errors['bookName']; ?></div>
                                                </div>

                                                <div class="form-group">

                                                    <label for="authorName">Author Name</label>
                                                    <input type="text" name="authorName" class="form-control" id="authorName" placeholder="" value="<?php echo htmlspecialchars($authorName); ?>">

                                                    <div class="text-red"><?php echo $errors['authorName']; ?></div>
                                                </div>


                                                <div class="form-group">

                                                    <label for="floatingTextarea">Description</label>
                                                    <textarea class="form-control" name="descreption" placeholder="Book Description" id="floatingTextarea"></textarea>

                                                    <div class="text-red"><?php echo $errors['descreption']; ?></div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="formFile" class="form-label">Default file input example</label>
                                                    <input class="form-control" type="file" id="formFile" name="image">

                                                    <div class="red-text"><?php echo $errors['image']; ?></div>
                                                </div>


                                                <div class="form-group text-center">
                                                    <button type="submit" class="btn btn-primary mt-2 ps-3 pe-3" name="submit">Submit</button>
                                                </div>
                                            </form>
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