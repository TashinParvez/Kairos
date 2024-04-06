<?php

include('/Kairos/Dashboard/connect_db.php');

if (isset($_POST['submit'])) { // submit btn name 

    if ($_FILES['image']['error'] === 0) {


        $tempname = $_FILES['image']['tmp_name'];

        // target = path to store the image
        $file_name = $_FILES['image']['name'];
        $folder = '../../Images/Books/' . $file_name;  // Assuming Upload.php is inside Kairos/Others/


        $new_file_name = uniqid('', true) . '_' . $file_name;
        $folder = '../../Images/Books/' . $new_file_name;

        $sql = "INSERT INTO image(file) 
                VALUES ('$new_file_name')";

        $result = mysqli_query($conn, $sql); // store file name to the database

        if (move_uploaded_file($tempname, $folder)) {
            echo "File Uploaded Successfully!";
        } else {
            echo "Failed to upload file.";
        }
    } else {
        echo "Error uploading file: " . $_FILES['image']['error'];
    }
}

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



</head>

<body>

    <div class="row col-8 mx-auto mt-5">

        <form method="post" action="Upload.php" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="formFile" class="form-label">Default file input example</label>

                <input class="form-control" type="file" id="formFile" name="image">
            </div>
            <div>
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            </div>
        </form>
    </div>

</body>

</html>