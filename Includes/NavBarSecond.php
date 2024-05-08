<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$databasename = 'Kairos';


// connection obj
$conn = mysqli_connect($servername, $username, $password, $databasename);

// check connection
if (!$conn) {
    die("Sorry failed to connect: " . mysqli_connect_error());
}


$data = array();
// --------------------------------------------- fetch data For search ------------------------
// fetch data ( FROM Notes )

$sql = "SELECT title
        FROM notes
        WHERE userHandle = 'tashin19'
        UNION ALL
        SELECT details
        FROM notes
        WHERE userHandle = 'tashin19';";

$result  =  mysqli_query($conn, $sql);  // get query result 

foreach ($result as $row) {
    $data[] = $row['title'];
}

// fetch data ( FROM Blogs )

$sql = "SELECT topicName
        FROM blog
        UNION
        SELECT description
        FROM blog;";

$result  =  mysqli_query($conn, $sql);  // get query result 

foreach ($result as $row) {
  $data[] = $row['topicName'];
}

// fetch data ( FROM Category )

$sql = "SELECT name
        FROM `category`;";

$result  =  mysqli_query($conn, $sql);  // get query result 

foreach ($result as $row) {
  $data[] = $row['name'];
}

// fetch data ( FROM Life_library)

$sql = "SELECT bookname
        FROM `life_library` 
        UNION ALL
        SELECT details
        FROM `life_library`";

$result  =  mysqli_query($conn, $sql);  // get query result 

foreach ($result as $row) {
  $data[] = $row['bookname'];
}

// fetch data ( FROM personal journal)

$sql = "SELECT title
        FROM `personal_journal`
        WHERE userHandle = 'tashin19'
        UNION ALL
        SELECT details
        FROM `personal_journal`
        WHERE userHandle = 'tashin19';";

$result  =  mysqli_query($conn, $sql);  // get query result 

foreach ($result as $row) {
  $data[] = $row['title'];
}

// print_r($data);
//--------------------------------------------- DATA fetch done ---------------------

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kairos</title>
    <link rel="icon" type="image/x-icon" href="/Images/Picture1.png">
    </link>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
      <link rel="stylesheet" href="style.css">

       <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="library/bootstrap-5/bootstrap.min.css" rel="stylesheet" />
    <script src="library/bootstrap-5/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="library/bootstrap-5/bootstrap.min.css" rel="stylesheet" />

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Typeahead.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>


</head>

<body>

    <style>
      *{
        z-index: 5000;
      }
#navSearch {
  --background: #ffffff;
  --text-color: #414856;
  --primary-color: #111111;
  --border-radius: 10px;
  --width: 190px;    
  --height: 55px;      
  background: var(--background);
  width: auto;
  height: var(--height);
  position: relative;
  overflow: hidden;
  border-radius: var(--border-radius);
  box-shadow: 0 10px 30px rgba(#414856, .05);
  display: flex;
  justify-content: center;
  align-items: center;
  input[type="text"] {
    position: relative;
    width: var(--height);
    height: var(--height);
    font: 400 16px 'Varela Round', sans-serif;
    color: var(--text-color);
    border: 0;
    box-sizing: border-box;
    outline: none;
    padding: 0 0 0 40px;
    transition: width .6s ease;
    z-index: 10;
    opacity: 0;
    cursor: pointer;
    &:focus {
      z-index: 0;
      opacity: 1;
      width: var(--width);
      ~ .symbol {
        &::before {
          width: 0%;
        }
        &:after {
          clip-path: inset(0% 0% 0% 100%);
          transition: clip-path .04s linear .105s;
        }
        .cloud {
          top: -30px;
          left: -30px;
          transform: translate(0, 0);
          transition: all .6s ease;
        }
        .lens {
          top: 20px;
          left: 15px;
          transform: translate(0, 0);
          fill: var(--primary-color);
          transition: top .5s ease .1s, left .5s ease .1s, fill .3s ease;
        }
      }
    }
  }
  .symbol {
    height: 100%;
    width: 100%;
    position: absolute;
    top: 0;
    z-index: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: transparent;
    &:before {
      content:"";
      position: absolute;
      right: 0;
      width: 100%;
      height: 100%;
      background: var(--primary-color);
      z-index: -1;
      transition: width .6s ease;
    }
    &:after {
      content:"";
      position: absolute;
      top: 21px;
      left: 21px;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      background: var(--primary-color);
      z-index: 1;
      clip-path: inset(0% 0% 0% 0%);
      transition: clip-path .04s linear .225s;
    }
    .cloud,
    .lens {
      position: absolute;
      fill: #fff;
      stroke: currentColor;
      top: 50%;
      left: 50%;
    }
    .cloud {
      width: 35px;
      height: 32px;
      transform: translate(-50%, -60%);
      transition: all .6s ease;
    }
    .lens {
      fill: #fff;
      width: 16px;
      height: 16px;
      z-index: 2;
      top: 24px;
      left: 24px;
      transition: top .3s ease, left .3s ease, fill .2s ease .2s;
    }
  }
}

.NavContainer {
  background: #fff;
  font: 400 16px 'Varela Round', sans-serif;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  .socials {
    position: fixed;
    display: block;
    left: 20px;
    bottom: 20px;
    > Nava {
      display: block;
      width: 30px;
      opacity: var(--opacity, .2);
      transform: scale(var(--scale, .8));
      transition: transform .3s cubic-bezier(0.38,-0.12, 0.24, 1.91);
    }
  }
}
    </style>

    <header class="header shadow z-2">
        <div class="container-fluid" style="background-color: transparent;">
            <div class="container-fluid bg-white align-items-right">
            <form class="searchBar" action="">
                <span id="search-txt">Search</span>
                <!-- <input type="search" required> -->
                <input type="search" name="country_name" id="country_name" placeholder="Search Keyword" autocomplete="off" required style="width: 800px;"/>
                <i class="fa fa-search"></i>
            </form>
            </div>
        </div>
    </header>
    <header class="upContainer shadow z-2">
        <div class="upContainerProfile">
            <div class="profile">
                <a href="\Profile\editProfile.php">
                    <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                    <svg class="bg-white" width="40" height="40" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.4"
                            d="M12.1605 10.87C12.0605 10.86 11.9405 10.86 11.8305 10.87C9.45055 10.79 7.56055 8.84 7.56055 6.44C7.56055 3.99 9.54055 2 12.0005 2C14.4505 2 16.4405 3.99 16.4405 6.44C16.4305 8.84 14.5405 10.79 12.1605 10.87Z"
                            stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M7.1607 14.56C4.7407 16.18 4.7407 18.82 7.1607 20.43C9.9107 22.27 14.4207 22.27 17.1707 20.43C19.5907 18.81 19.5907 16.17 17.1707 14.56C14.4307 12.73 9.9207 12.73 7.1607 14.56Z"
                            stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
        </div>
        <div class="upContainerSignOut">
            <div class="signOut">
                <a href="#">
                    <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                    <svg class="bg-white" width="40" height="40" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M9 4.5H8C5.64298 4.5 4.46447 4.5 3.73223 5.23223C3 5.96447 3 7.14298 3 9.5V14.5C3 16.857 3 18.0355 3.73223 18.7678C4.46447 19.5 5.64298 19.5 8 19.5H9"
                            stroke="#1C274C" stroke-width="1.5" />
                        <path
                            d="M9 6.4764C9 4.18259 9 3.03569 9.70725 2.4087C10.4145 1.78171 11.4955 1.97026 13.6576 2.34736L15.9864 2.75354C18.3809 3.17118 19.5781 3.37999 20.2891 4.25826C21 5.13652 21 6.40672 21 8.94711V15.0529C21 17.5933 21 18.8635 20.2891 19.7417C19.5781 20.62 18.3809 20.8288 15.9864 21.2465L13.6576 21.6526C11.4955 22.0297 10.4145 22.2183 9.70725 21.5913C9 20.9643 9 19.8174 9 17.5236V6.4764Z"
                            stroke="#1C274C" stroke-width="1.5" />
                        <path d="M12 11V13" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </a>
            </div>
        </div>
    </header>
    <script>
        document.getElementById('searchInput').addEventListener('focus', function () {
            document.querySelector('.container-fluid.bg-white.align-items-right').classList.add('hidden');
        });
    </script>
</body>

</html>

<script>
    $(document).ready(function() {
        var countries = <?php echo json_encode($data); ?>;

        // Instantiate the Bloodhound suggestion engine
        var countriesBloodhound = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: countries
        });

        // Initialize the Typeahead plugin
        $('#country_name').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'countries',
            source: countriesBloodhound
        });
    });
</script>
<script>
    document.getElementById("country_name").addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            // Get the value entered in the input field
            var countryName = document.getElementById("country_name").value;
            // Redirect to another page passing the search query as a parameter
            window.location.href = "/Includes/SideNavMain.php";
        }
    });
</script>