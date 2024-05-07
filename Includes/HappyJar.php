<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kairos</title>
    <link rel="icon" type="image/x-icon" href="/Images/Picture1.png"></link>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <style>
        #goalButton .btn {
            width: 50px; /* Set the width */
            height: 50px; /* Set the height */
            padding: 0; /* Remove any default padding */
            border-radius: 10px; /* Set border radius to 10 (half of the width/height) */
            display: flex; /* Use flexbox */
            justify-content: center; /* Align content horizontally */
            align-items: center; /* Align content vertically */
            position: relative; /* Relative positioning for absolute positioning of icons */
        }

        #goalButton .btn i {
            font-size: 1.5rem; /* Adjust the font size of the icon */
            position: absolute; /* Position the icons absolutely */
            top: 50%; /* Center vertically */
            left: 50%; /* Center horizontally */
            transform: translate(-50%, -50%); /* Move the icons back by half of their own width and height */
        }
    </style>
</head>
<body>
    <div id="goalButton" class="position-fixed bottom-0 end-0 mb-4 me-4 bg-transparent z-3">
        <button class="btn btn-secondary shadow" type="button">
        <i class="far fa-frown bg-transparent"></i>
        <i class="fas fa-grin-alt bg-transparent" style="visibility: hidden;"></i> <!-- Initially hidden -->
        </button>
    </div>

    <script>
        // JavaScript to handle icon change on hover
        document.querySelector('#goalButton .btn').addEventListener('mouseover', function() {
            this.querySelector('.far').style.visibility = 'hidden'; // Hide frown icon
            this.querySelector('.fas').style.visibility = 'visible'; // Show grin-alt icon
        });

        document.querySelector('#goalButton .btn').addEventListener('mouseout', function() {
            this.querySelector('.far').style.visibility = 'visible'; // Show frown icon
            this.querySelector('.fas').style.visibility = 'hidden'; // Hide grin-alt icon
        });
    </script>
</body>
</html>
