<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$databasename = 'Kairos';
$conn = mysqli_connect($servername, $username, $password, $databasename);
if (!$conn) {
    die("Sorry failed to connect: " . mysqli_connect_error());
}

// --------------------------------------------- fetch data For search ------------------------
$data = array();

// fetch data ( FROM Notes )

$sql = "SELECT left(title, 105) as title
        FROM (  SELECT title
                FROM notes
                WHERE userHandle = 'tashin19'
                UNION ALL
                SELECT details
                FROM notes
                WHERE userHandle = 'tashin19'
                ) as ntc;";

$result  =  mysqli_query($conn, $sql);  // get query result 

foreach ($result as $row) {
    $data[] = $row['title'];
}

// fetch data ( FROM Blogs )

$sql = "SELECT left(topicName, 105) as topicName
        FROM (SELECT topicName
              FROM blog
              UNION
              SELECT description
              FROM blog
              ) as ntc;";

$result  =  mysqli_query($conn, $sql);  // get query result 

foreach ($result as $row) {
    $data[] = $row['topicName'];
}

// fetch data ( FROM Category )

$sql = "SELECT name
        FROM category;";

$result  =  mysqli_query($conn, $sql);  // get query result 

foreach ($result as $row) {
    $data[] = $row['name'];
}

// fetch data (FROM Life_library)

$sql = "SELECT left(bookname, 105) as bookname
        FROM (  SELECT bookname
                FROM life_library 
                UNION ALL
                SELECT authorName
                FROM life_library
                UNION ALL
                SELECT details
                FROM life_library
                ) as ntc";

$result  =  mysqli_query($conn, $sql);  // get query result 

foreach ($result as $row) {
    $data[] = $row['bookname'];
}

// fetch data ( FROM personal journal)

$sql = "SELECT left(title, 105) as title
        FROM (  SELECT title
                FROM personal_journal
                WHERE userHandle = 'tashin19'
                UNION ALL
                SELECT details
                FROM personal_journal
                WHERE userHandle = 'tashin19'
                ) as ntc;";

$result  =  mysqli_query($conn, $sql);  // get query result 

foreach ($result as $row) {
    $data[] = $row['title'];
}

// print_r($data);
//--------------------------------------------- DATA fetch done -----------------------------------

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Global Search Navbar</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Navbar</a>
        <div class="collapse navbar-collapse">

            <form class="form-inline ml-auto" method="GET" action="searchbaroutput.php">

                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="query" value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">

                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
</body>

</html>