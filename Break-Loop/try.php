<?php
// connect database
$servername = 'localhost';
$username = 'root';
$password = '';
$databasename = 'Kairos';

$conn = mysqli_connect($servername, $username, $password, $databasename);

// check connection
if (!$conn) {
    die("Sorry failed to connect: " . mysqli_connect_error());
}

// -------------------------------------------------
$userHandle = 'tashin19';

$loopName = 'loop1';

$p1DoThis = null;
$p1WantToDoThis = null;

$p2DoThis = null;
$p2WantToDoThis = null;

$p3DoThis = null;
$p3WantToDoThis = null;


// ---------------------------------------- --------- ----------------------------------


// -------------------------------------------------------------------------------

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kairos</title>
    <!-- CSS Links -->
    <link rel="stylesheet" href="style.css">

    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</head>

<body class="bg-custom">



    <main class="main bg-white shadow z-0">
        <!------------------------------ head Segment ------------------------------>
        <div class="row p-4 p-md-5 mb-4 rounded text-bg-secondary justify-content-center">
            <div class="col-10 text-bg-secondary d-flex flex-column ">
                <h1 class="display-6 fst-italic text-bg-secondary">
                    Are you <b class="text-bg-secondary">Procrastinating</b> ? <br>
                    wasting your <b class="text-bg-secondary">Time</b> ?<br>
                    are you in a <b class="text-bg-secondary">Loop</b> ?
                </h1>
            </div>
            <div class="tashin col-2 text-bg-secondary d-flex flex-column justify-content-center">
                <button type="button" class="btn btn-outline-danger " data-bs-toggle="modal" data-bs-target="#exampleModal">YES</button>
                <button type="button" class="btn btn-outline-dark">NO</button>
            </div>
        </div>
        <!------------------------------ Modal (YES) ------------------------------>
        <div class="modal fade modal-dialog modal-dialog-centered modal-dialog-scrollable" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row mb-3">
                                <label for="input1" class="col-sm-6 col-form-label">What are you feeling?</label>
                                <div class="col-sm-6">
                                    <input type="" class="form-control" id="input1">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="input2" class="col-sm-6 col-form-label">Are you doing something?</label>
                                <div class="col-sm-6">
                                    <input type="" class="form-control" id="input2">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Help</button>
                    </div>
                </div>
            </div>
        </div>
        <!------------------------------ Body Segment ------------------------------>


        <!------------------------------ Body Segment ------------------------------>
        <div class="row p-4 p-md-5 mb-4">
            <div class="row justify-content-between">
                <h2 class="col-4">Loops</h2>

                <button type="button" class="btn col-2 btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                    Launch demo modal
                </button>

                <!-------------- New loop Modal -------------->
                <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel2">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="row mb-3">
                                        <label for="input1" class="col-sm-6 col-form-label">Loop Name</label>
                                        <div class="col-sm-6">
                                            <input type="" class="form-control" id="input1">
                                        </div>
                                    </div>
                                    <hr>
                                    <!-- ------------------ -->
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Problem-1</label>
                                        <div class="row justify-content-center">

                                            <div id="emailHelp" class="form-text">You do this</div>
                                            <input type="text" class="col-6 form-control" id="" aria-describedby="">

                                            <div id="emailHelp" class="form-text">You want to do this</div>
                                            <input type="text" class="col-6 form-control" id="" aria-describedby="">

                                        </div>
                                    </div>
                                    <hr>
                                    <!-- ------------------ -->

                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Problem-2</label>
                                        <div class="row justify-content-center">

                                            <div id="emailHelp" class="form-text">You do this</div>
                                            <input type="text" class="col-6 form-control" id="" aria-describedby="">

                                            <div id="emailHelp" class="form-text">You want to do this</div>
                                            <input type="text" class="col-6 form-control" id="" aria-describedby="">

                                        </div>
                                    </div>
                                    <hr>
                                    <!-- ------------------ -->

                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Problem-2</label>
                                        <div class="row justify-content-center">

                                            <div id="emailHelp" class="form-text">You do this</div>
                                            <input type="text" class="col-6 form-control" id="" aria-describedby="">

                                            <div id="emailHelp" class="form-text">You want to do this</div>
                                            <input type="text" class="col-6 form-control" id="" aria-describedby="">

                                        </div>
                                    </div>
                                    <!-- ------------------ -->

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <hr>

            <!------------------- cards ------------------->
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Doctor Suggestion</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="#" class="btn btn-primary">Update Loop</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="#" class="btn btn-primary">Update Loop</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- ------------------------------------------------------------------- -->

    </main>
</body>

</html>