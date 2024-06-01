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

$result = mysqli_query($conn, $sql);

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

$result = mysqli_query($conn, $sql);

foreach ($result as $row) {
    $data[] = $row['topicName'];
}

// fetch data ( FROM Category )

$sql = "SELECT name
        FROM category;";

$result = mysqli_query($conn, $sql);

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

$result = mysqli_query($conn, $sql);

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

$result = mysqli_query($conn, $sql);

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
                <!-- <form class="searchBar bg-white" method="GET" action="../Includes/nomanTry.php"> -->
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
    <header class="upContainer shadow z-2">
        <div class="upContainerProfile">
            <div class="profile">
                <a href="\Profile\editProfile.php">
                    <svg class="bg-white" width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.4" d="M12.1605 10.87C12.0605 10.86 11.9405 10.86 11.8305 10.87C9.45055 10.79 7.56055 8.84 7.56055 6.44C7.56055 3.99 9.54055 2 12.0005 2C14.4505 2 16.4405 3.99 16.4405 6.44C16.4305 8.84 14.5405 10.79 12.1605 10.87Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M7.1607 14.56C4.7407 16.18 4.7407 18.82 7.1607 20.43C9.9107 22.27 14.4207 22.27 17.1707 20.43C19.5907 18.81 19.5907 16.17 17.1707 14.56C14.4307 12.73 9.9207 12.73 7.1607 14.56Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
        </div>
        <div class="upContainerSignOut">
            <div class="signOut">
                <a href="#">
                    <svg class="bg-white" width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 4.5H8C5.64298 4.5 4.46447 4.5 3.73223 5.23223C3 5.96447 3 7.14298 3 9.5V14.5C3 16.857 3 18.0355 3.73223 18.7678C4.46447 19.5 5.64298 19.5 8 19.5H9" stroke="#1C274C" stroke-width="1.5" />
                        <path d="M9 6.4764C9 4.18259 9 3.03569 9.70725 2.4087C10.4145 1.78171 11.4955 1.97026 13.6576 2.34736L15.9864 2.75354C18.3809 3.17118 19.5781 3.37999 20.2891 4.25826C21 5.13652 21 6.40672 21 8.94711V15.0529C21 17.5933 21 18.8635 20.2891 19.7417C19.5781 20.62 18.3809 20.8288 15.9864 21.2465L13.6576 21.6526C11.4955 22.0297 10.4145 22.2183 9.70725 21.5913C9 20.9643 9 19.8174 9 17.5236V6.4764Z" stroke="#1C274C" stroke-width="1.5" />
                        <path d="M12 11V13" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </a>
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