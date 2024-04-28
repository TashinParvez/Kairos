<?php
// database connection
include('../Dashboard/connect_db.php');

$userHandle = 'noman123';

$search_text = '';

if (isset($_POST['search'])) { // Showing searched blogs

    $search_text = $_POST['search_field'];

    // query for showing search's blogs
    $sql = "SELECT concat(COALESCE(concat(firstName, ' '), ''), COALESCE(lastName, '')) AS name, date(b.created_at) AS created_date, topicName, description, created_at
            FROM blog AS b INNER JOIN user_info AS u
            ON b.userHandle = u.userHandle
            WHERE concat(COALESCE(concat(firstName, ' '), ''), COALESCE(lastName, '')) LIKE '%" . $search_text . "%'
            OR topicName LIKE '%" . $search_text . "%'
            ORDER BY created_at DESC";

    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $blogs = mysqli_fetch_all($result);
    } else {
        $blogs = 'Empty result!';
    }
} else { // Showing all blogs

    $sql = "SELECT concat(COALESCE(concat(firstName, ' '), ''), COALESCE(lastName, '')) AS name, date(b.created_at) AS created_date, topicName, description
            FROM blog AS b INNER JOIN user_info AS u
            ON b.userHandle = u.userHandle
            ORDER BY created_at DESC";

    $result = mysqli_query($conn, $sql);
    $blogs = mysqli_fetch_all($result);
}


// Creating a blog
if (isset($_POST['post'])) {
    $blogTopic = $_POST['blogTopic'];
    $blogDescription = $_POST['blogDescription'];

    if (!empty($blogTopic) && !empty($blogDescription)) {

        // $userHandle = mysqli_real_escape_string($conn, $_POST['userHandle']);
        $blogTopic = mysqli_real_escape_string($conn, $_POST['blogTopic']);
        $blogDescription = mysqli_real_escape_string($conn, $_POST['blogDescription']);

        $sql = "INSERT INTO blog(userHandle, topicName, description)
                VALUES ('$userHandle', '$blogTopic', '$blogDescription')";

        // save to db and check
        if (mysqli_query($conn, $sql)) {
            // success
            header('Location: blog.php');
        } else {
            echo 'query error: ' . mysqli_error($conn);
        }
    }
}


mysqli_free_result($result);
// close connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="editProfile.php">
    <link rel="stylesheet" href="../Dashboard/style.css">
    <link rel="stylesheet" href="library.css">

    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


</head>

<body>

    <!-- Navbar -->
    <?php include('../Dashboard/navbar.php'); ?>

    <!-- .....................****** CSS & JS  *******...................... -->

    <script>
        // Initialization for ES Users
        import {
            Ripple,
            initMDB
        } from "mdb-ui-kit";

        initMDB({
            Ripple
        });
    </script>

    <style>
        #customModal {
            width: 100%;
            /* Adjust the width as needed */
            max-width: 80vw;
            /* Set a maximum width if desired */
            height: 80%;
            /* Adjust the height as needed */
            max-height: 70vh;
            /* Set a maximum height if desired */
            /* Add any other styles as needed */
        }

        #blogDescription {
            height: 100%;
            max-height: 60vh;
        }
    </style>

    <!-- .....................*************...................... -->
    <!-- Body below navbar -->
    <div class="container">

        <div class="row align-items-start">

            <!-- First column/block -->
            <div class="col-2">

            </div>

            <!-- Second column/block -- showing blogs -->
            <div class="col-7">

                <!-- create blog & Search bar -->
                <form action="blog.php" method="POST">
                    <div class="row align-items-start mb-3">
                        <div class="col-9">
                            <div class="input-group" style="padding-left: 1vw;">
                                <input type="search" class="form-control rounded" style="background-color: ;" name="search_field" value="<?php echo htmlspecialchars($search_text) ?>" placeholder="Which one you are looking for..." aria-label="search" aria-describedby="search-addon" />
                                <button type="submit" class="btn btn-outline-primary" name="search" data-mdb-ripple-init>Search</button>
                            </div>
                        </div>
                        <div class="col-3" style="display: grid; place-items: center;">
                            <!-- <button type="submit" class="btn btn-outline-primary" name="create_blog" data-mdb-ripple-init>Create a blog</button> -->
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createBlogModal">Create a blog</button>

                        </div>
                    </div>
                </form>


                <!-- .................******** scrollable part ***********........................ -->

                <div class="scrollable-container" style="height:71.25vh; overflow-y: auto; scrollbar-width:none;">
                    <!-- Content that exceeds the height of the container -->

                    <?php if ($blogs === 'Empty result!') :
                    ?>
                        <div class="card mb-2" style="background: snow;">
                            <div class="card-body">
                                <p class="card-text"> <?php echo htmlspecialchars($blogs); ?> </p>
                            </div>
                        </div>
                    <?php else : ?>
                        <?php
                        // loop starts here
                        foreach ($blogs as $blog) {
                        ?>
                            <div class="card mb-2" style="background: snow;">

                                <div class="card-header">

                                    <div class="row align-items-start">
                                        <div class="col-1">
                                            <a class="navbar-brand" href="#"> <!--image position have to fix -->
                                                <img src="../images/logo2.png" alt="Bootstrap" height="30">
                                            </a>
                                        </div>
                                        <div class="col"> <!--name and date space have to reduce -->
                                            <a href="#" style="text-decoration: none; color:black"><?php echo htmlspecialchars($blog[0]); ?></a>
                                            <br>
                                            <h7><?php echo htmlspecialchars($blog[1]); ?></h7>
                                        </div>
                                    </div>

                                </div>

                                <div class="card-body">

                                    <h5 class="card-title"><?php echo htmlspecialchars($blog[2]); ?></h5>
                                    <p class="card-text">
                                        <?php
                                        if (strlen($blog[3]) < 205) {
                                            echo htmlspecialchars($blog[3]);
                                        } else {
                                            echo htmlspecialchars(substr($blog[3], 0, 200));
                                        }
                                        ?>
                                    </p>

                                    <a href="#" style="text-decoration: none;">...</a>

                                </div>
                            </div>
                        <?php } ?>
                    <?php endif ?>

                </div>


                <!-- .................*******************........................ -->

            </div>

            <!-- Third column -->
            <div class="col">

            </div>
        </div>
    </div>


    <!-- Modal for creating a blog -->
    <div class="modal fade" id="createBlogModal" tabindex="-1" aria-labelledby="createBlogModalLabel" aria-hidden="true">
        <div class="modal-dialog" id="customModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createBlogModalLabel">Create a Blog</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for creating a blog -->
                    <form action="blog.php" method="POST"> <!-- Now123 -->
                        <div class="mb-3">
                            <label for="blogTopic" class="form-label">Blog Topic</label>
                            <input type="text" class="form-control" id="blogTopic" name="blogTopic" required>
                        </div>
                        <div class="mb-3">
                            <label for="blogDescription" class="form-label">Blog Description</label>
                            <textarea class="form-control" id="blogDescription" name="blogDescription" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="post">Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</body>

</html>