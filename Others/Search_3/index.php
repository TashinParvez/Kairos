<?php
include('\../Kairos/Dashboard/connect_db.php'); // database connection

$sql = "SELECT title as country_name
        FROM notes  
        WHERE userHandle = 'tashin19'; ";

$result  =  mysqli_query($conn, $sql);  // get query result 

$data = array();

foreach ($result as $row) {
    $data[] = $row['country_name'];
}

// print_r($data);

?>

<!DOCTYPE html>
<html lang="en">

<head>
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


    <title>Typeahead Autocomplete using JavaScript in PHP for Bootstrap 5</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-3">&nbsp;</div>
            <div class="col-md-6">
                <input type="text" name="country_name" id="country_name" class="form-control form-control-lg" placeholder="Country Name" autocomplete="off" />
            </div>
            <div class="col-md-3">&nbsp;</div>
        </div>
    </div>

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