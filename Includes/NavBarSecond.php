<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$databasename = 'Kairos';

// connection obj
$conn = mysqli_connect($servername, $username, $password, $databasename);

// check connection
if (!$conn) {
    exit('Sorry failed to connect: ' . mysqli_connect_error());
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

$result = mysqli_query($conn, $sql);  // get query result

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

$result = mysqli_query($conn, $sql);  // get query result

foreach ($result as $row) {
    $data[] = $row['topicName'];
}

// fetch data ( FROM Category )

$sql = "SELECT name
        FROM category;";

$result = mysqli_query($conn, $sql);  // get query result

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

$result = mysqli_query($conn, $sql);  // get query result

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

$result = mysqli_query($conn, $sql);  // get query result

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
    <title>Kairos</title>
    <link rel="icon" type="image/x-icon" href="/Images/Picture1.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
</head>

<body>
    <header class="header shadow z-2">
        <div class="container-fluid bg-white" style="background-color: transparent;">
            <div class="container-fluid bg-white align-items-right">

                <!------------------------------------ search bar ------------------------------------>

                <form class="searchBar bg-white" method="GET" action="../Includes/global-search-bar.php">
                    <span id="search-txt" class="z-10000">Search</span>
                    <input type="search" class="bg-white align-items-center border-secondary" name="country_name" value="<?php echo isset($_GET['country_name']) ? htmlspecialchars($_GET['country_name']) : ''; ?>" id="country_name" placeholder="Search Keyword" autocomplete="off" required style="width: 800px;" />
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
                <!-- ----------------------------- -->
            </div>
        </div>
    </header>
    <script>
        $(document).ready(function() {
            var countries = <?php echo json_encode($data); ?>;
            var countriesBloodhound = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                local: countries
            });

            $('#country_name').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, {
                name: 'countries',
                source: countriesBloodhound,
                templates: {
                    suggestion: function(data) {
                        return '<div class="tt-suggestion tt-selectable">' + data + '<hr></div>';
                    }
                }
            });

            $('#country_name').bind('typeahead:render', function() {
                $('.tt-suggestion').on('mouseover', function() {
                    $('.tt-suggestion').removeClass('tt-cursor');
                    $(this).addClass('tt-cursor');
                });
            });
        });
    </script>
    <style>
        .tt-menu {
            width: 800px;
        }

        .tt-suggestion {
            padding: 10px 20px;
            border-bottom: 1px solid #ccc;
        }

        .tt-suggestion.tt-cursor {
            background-color: #f0f0f0;
            color: #000;
        }

        .tt-suggestion hr {
            margin: 0;
            border: 0;
            border-top: 1px solid #eee;
        }
    </style>
</body>

</html>