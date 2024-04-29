<?php
// database connection
include '../Dashboard/connect_db.php';

$userHandle = 'noman123';

$search_text = '';

if (isset($_POST['search'])) { // Showing searched blogs
    $search_text = $_POST['search_field'];

    // query for showing search's blogs
    $sql = "SELECT concat(COALESCE(concat(firstName, ' '), ''), COALESCE(lastName, '')) AS name, date(b.created_at) AS created_date, topicName, description, created_at
            FROM blog AS b INNER JOIN user_info AS u
            ON b.userHandle = u.userHandle
            WHERE concat(COALESCE(concat(firstName, ' '), ''), COALESCE(lastName, '')) LIKE '%".$search_text."%'
            OR topicName LIKE '%".$search_text."%'
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
            echo 'query error: '.mysqli_error($conn);
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
    <link rel="icon" type="image/x-icon" href="/Images/Picture1.png"></link>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        include '../Includes/NavBarSecond.php'; // uncomment
include '../Includes/Sidebar.php'; // uncomment
?>
    <script>
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
            max-width: 80vw;
            height: 80%;
            max-height: 70vh;
            background-color: white;
        }

        #blogDescription {
            background-color: white;
            height: 100%;
            max-height: 60vh;
        }
        .card{
            height: fit-content;
        }
    </style>

<main class="main bg-white shadow">
    <div class="container bg-white">
        <div class="row align-items-start bg-white">
            <div class="col-2 bg-white">
            </div>
            <div class="col-7 bg-white">
                <form action="blog.php" method="POST">
                    <div class="row align-items-start mb-3 bg-white">
                        <div class="col-9 bg-white">
                            <div class="input-group bg-white" style="padding-left: 1vw;">
                                <input type="search" class="form-control rounded bg-white" style="background-color: ;" name="search_field" value="<?php echo htmlspecialchars($search_text); ?>" placeholder="Which one you are looking for..." aria-label="search" aria-describedby="search-addon" />
                                <button type="submit" class="btn btn-outline-primary bg-white" name="search" data-mdb-ripple-init>Search</button>
                            </div>
                        </div>
                        <div class="col-3 bg-white" style="display: grid; place-items: center;">
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createBlogModal">Create a blog</button>

                        </div>
                    </div>
                </form>
                <div class="scrollable-container bg-white">
                    <?php if ($blogs === 'Empty result!') {
                        ?>
                        <div class="card mb-2 bg-white" style="background: snow;">
                            <div class="card-body bg-white">
                                <p class="card-text bg-white"> <?php echo htmlspecialchars($blogs); ?> </p>
                            </div>
                        </div>
                    <?php } else { ?>
                        <?php
                            foreach ($blogs as $blog) {
                                ?>
                            <div class="card mb-2 bg-white">

                                <div class="card-header bg-white">

                                    <div class="row align-items-start bg-white">
                                        <div class="col-1 bg-white">
                                            <a class="navbar-brand bg-white" href="#">
                                                <img src="../images/logo2.png" class="bg-white" alt="Bootstrap" height="30">
                                            </a>
                                        </div>
                                        <div class="col bg-white">
                                            <a href="#" class="bg-white" style="text-decoration: none; color:black"><?php echo htmlspecialchars($blog[0]); ?></a>
                                            <br>
                                            <h7 class="bg-white"><?php echo htmlspecialchars($blog[1]); ?></h7>
                                        </div>
                                    </div>

                                </div>

                                <div class="card-body bg-white">

                                    <h5 class="card-title bg-white"><?php echo htmlspecialchars($blog[2]); ?></h5>
                                    <p class="card-text bg-white">
                                        <?php
                                                if (strlen($blog[3]) < 205) {
                                                    echo htmlspecialchars($blog[3]);
                                                } else {
                                                    echo htmlspecialchars(substr($blog[3], 0, 200));
                                                }
                                ?>
                                    </p>

                                    <a class="bg-white" href="#" style="text-decoration: none;">...</a>

                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>

                </div>
            </div>
            <div class="col bg-white">
            </div>
        </div>
    </div>
    <div class="modal fade bg-white" id="createBlogModal" tabindex="-1" aria-labelledby="createBlogModalLabel" aria-hidden="true">
        <div class="modal-dialog bg-white" id="customModal">
            <div class="modal-content bg-white">
                <div class="modal-header bg-white">
                    <h5 class="modal-title bg-white" id="createBlogModalLabel">Create a Blog</h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-white">
                    <form action="blog.php" method="POST">
                        <div class="mb-3 bg-white">
                            <label for="blogTopic" class="form-label bg-white">Blog Topic</label>
                            <input type="text" class="form-control bg-white" id="blogTopic" name="blogTopic" required>
                        </div>
                        <div class="mb-3 bg-white">
                            <label for="blogDescription" class="form-label bg-white">Blog Description</label>
                            <textarea class="form-control bg-white" id="blogDescription" name="blogDescription" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary bg-white" name="post">Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </main>

</body>

</html>