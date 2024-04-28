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



//----------------- New Book  ---------------

$sql = "SELECT 
        CASE 
            WHEN LENGTH(n.title) > 20 THEN CONCAT(LEFT(n.title, 12), '...')
            ELSE n.title
        END AS title, n.title, n.userHandle
        FROM notes AS n
        LEFT JOIN life_library AS li ON LOWER(TRIM(n.title)) = LOWER(TRIM(li.bookName))
        WHERE n.public = 1 AND li.bookName IS NULL;";

$result =  mysqli_query($conn, $sql);

$newBooks = mysqli_fetch_all($result);

// print_r($newBooks);

// foreach ($newBooks as $book) {
//     print_r($book);
// }

$bookName = '';
$authorName = '';

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

                <!------------------ Books need to add ------------------>

                <div class="flex-grow-1 pt-2" style="height: 30vh; overflow-y: auto;">
                    <div class="container-fluid" style="overflow-x: auto; white-space: nowrap;">
                        <div class="row row-cols-1 row-cols-md-5 g-4">

                            <?php foreach ($newBooks as $book) { ?>
                                <div class="col">
                                    <a href="Life-Library-Books.php?bookname=<?php echo urlencode($book[1]); ?>" class="card-link" style="text-decoration: none; color: inherit;">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <?php echo htmlspecialchars($book[0]); ?>
                                                </h5>
                                                <p class="card-text">Note published by <br>
                                                    <?php echo htmlspecialchars($book[2]); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>
                            
                        </div>
                    </div>
                </div>

                <?php
                if (isset($_GET['bookname'])) {
                    $bookName = urldecode($_GET['bookname']);  // Decode the book name
                }
                ?>


                <!-- add descreption -->

                <div class="flex-grow-1 pt-2 " style="overflow-y: auto;">

                    <div class="row col-8 mx-auto mt-5">

                        <form method="post" action="" enctype="multipart/form-data">

                            <div class="form-group">
                                <label for="fullName">Book Name</label>
                                <input type="text" name="bookName" class="form-control" id="" placeholder="" value="<?php echo htmlspecialchars($bookName); ?>">
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
        </div>
    </div>



</body>

</html>