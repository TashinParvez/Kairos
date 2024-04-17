<?php

include('../Dashboard/connect_db.php'); // database connection

$firstName = $lastName = $nationality = $religion = $mail = $userHandle = $password = $confirmPassword = $oldPassword = '';

$previousUserHandle = $_GET['userHandle'];

// check get request userHandle 
if (isset($_GET['userHandle'])) {

    $userHandle = mysqli_real_escape_string($conn, $_GET['userHandle']);

    //----------------- Get users Info ---------------

    // sql query

    $sql = "SELECT firstName, lastName, nationality,religion, mail, userHandle
            FROM user_info
            WHERE userHandle = '$userHandle' ";

    $result =  mysqli_query($conn, $sql);  // get query result

    $userInfo = mysqli_fetch_all($result); // conver to array

    // print_r($userInfo);


    // for memory free
    mysqli_free_result($result);
    mysqli_close($conn);
} else {  // full else remove after adding login 


    $userHandle = mysqli_real_escape_string($conn, 'bijoy123');

    //----------------- Get users Info ---------------

    // sql query

    $sql = "SELECT firstName, lastName, nationality,religion, mail, userHandle
            FROM user_info
            WHERE userHandle = '$userHandle'; ";




    $result =  mysqli_query($conn, $sql);  // get query result

    $userInfo = mysqli_fetch_all($result); // conver to array


    $firstName = $userInfo[0][0];
    $lastName = $userInfo[0][1];
    $nationality = $userInfo[0][2];
    $religion = $userInfo[0][3];
    $mail = $userInfo[0][4];
    $userHandle = $userInfo[0][5];

    // $password = $userInfo[0][0]; 


    // print_r($userInfo);


    // for memory free
    mysqli_free_result($result);
    mysqli_close($conn);
}

if (isset($_POST['cancel'])) {
    header('Location: editProfile.php');
}

$errors = array('firstName' => '', 'lastName' => '', 'nationality' => '', 'religion' => '', 'mail' => '', 'userHandle' => '', 'password' => '', 'confirmPassword' => '', 'oldPassword' => '');

if (isset($_POST['update'])) {


    //................ Retrieve all data  from input field ...............

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $nationality = $_POST['nationality'];
    $religion = $_POST['religion'];
    // $mail = $_POST['mail'];
    $userHandle = $_POST['userHandle'];

    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $oldPassword = $_POST['oldPassword'];


    //................... escape sql chars .....................

    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
    $religion = mysqli_real_escape_string($conn, $_POST['religion']);
    // $mail = mysqli_real_escape_string($conn, $_POST['mail']);
    $userHandle = mysqli_real_escape_string($conn, $_POST['userHandle']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);


    //.............. All input field validation checking ...................
    // check first name
    if (empty($firstName)) {
        $errors['firstName'] = 'This field cannot be empty!';
    } else {
        if (!preg_match('/^[a-zA-Z\s\.]+$/', $firstName)) {
            $errors['firstName'] = 'This field contains letters and space only!';
        }
    }

    // check last name
    if (empty($lastName)) {
        $errors['lastName'] = 'This field cannot be empty!';
    } else {
        if (!preg_match('/^[a-zA-Z0-9\s\.]+$/', $lastName)) {
            $errors['lastName'] = 'This field contains letters and spaces only!';
        }
    }

    // check nationality
    if (empty($nationality)) {
        $errors['nationality'] = 'This field cannot be empty!';
    } else {
        if (!preg_match('/^[a-zA-Z0-9\s\.]+$/', $nationality)) {
            $errors['nationality'] = 'This field contains letters and spaces only!';
        }
    }

    // check religion
    if (empty($religion)) {
        $errors['religion'] = 'This field cannot be empty!';
    } else {
        if (!preg_match('/^[a-zA-Z\s]+$/', $religion)) {
            $errors['religion'] = 'This field contains letters and spaces only!';
        }
    }

    // check email  ** Mail checking is unnecessary as it cannot be changed **

    // if (empty($mail)) {
    //     $errors['mail'] = 'This field cannot be empty!';
    // } else {
    //     if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    //         $errors['mail'] = 'Invalid email!';
    //     } else {

    //         // Duplication checking for email
    //         $sql = "SELECT userHandle FROM user_info WHERE mail = '$mail'";
    //         $result = mysqli_query($conn, $sql);
    //         if ($result && mysqli_num_rows($result) > 0) {
    //             $errors['mail'] = 'Sorry, this email is already registered!
    //                                 Please use a different one';
    //         }
    //     }
    // }

    // check user handle
    if (empty($userHandle)) {
        $errors['userHandle'] = 'This field cannot be empty!';
    } else {
        if (strlen($userHandle) < 8) {
            $errors['userHandle'] = 'User handle length(8-20)!';
        } else if ((!preg_match('/^[a-zA-Z0-9\-\@\_\.]+$/', $userHandle)) ||
            (!(strtoupper($userHandle[0]) >= 'A' || strtoupper($userHandle[0]) <= 'Z'))
        ) {
            $errors['userHandle'] = 'Invalid user handle!';
        } else {

            // Duplication checking for user handle
            $sql = "SELECT userHandle FROM user_info WHERE userHandle = '$userHandle'";
            $result = mysqli_query($conn, $sql);
            $userHandleValue = mysqli_fetch_assoc($result);
            if (($result && mysqli_num_rows($result) > 0) && ($previousUserHandle !== $userHandleValue['userHandle'])) {
                $errors['userHandle'] = 'The username you entered is not available!
                                            Please try another one';
            }
            mysqli_free_result($result);
        }
    }

    // check password
    // if (empty($password)) {
    //     $errors['password'] = 'This field cannot be empty!';
    // } else {
    //     if (strlen($password) < 8) {
    //         $errors['password'] = 'Password length(8-20)';
    //     }
    // }

    // password field empty means user don't want to change the password
    $sql = "SELECT password
    FROM user_info
    WHERE userHandle = '$previousUserHandle'";

    $result = mysqli_query($conn, $sql);
    $passwordValue = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    if (!empty($password)) {
        if (strlen($password) < 8) {
            $errors['password'] = 'Password length(8-20)';
        } else {
            // check confirm password
            if (!empty($password) && $confirmPassword !== $password) {
                $errors['confirmPassword'] = "Password doesn't match!";
            } else {
                if (!empty($password) && !empty($confirmPassword)) {
                    if ($passwordValue) {
                        if ($oldPassword !== $passwordValue['password']) {
                            $errors['oldPassword'] = "Incorrect password!";
                        }
                    }
                }
            }
        }
    } else {
        $password = $passwordValue['password'];
    }



    if (!array_filter($errors)) {

        // create sql
        $sql = "UPDATE user_info SET firstName = '$firstName', lastName ='$lastName', nationality = '$nationality',
        userHandle ='$userHandle', password = '$password', religion = '$religion'
        WHERE userHandle = '$previousUserHandle'";

        // save to db and check
        if (mysqli_query($conn, $sql)) {
            // success
            header('Location: editProfile.php');
        } else {
            echo 'query error: ' . mysqli_error($conn);
        }

        // close connection
        mysqli_close($conn);
    }
} // end POST check



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="editProfile.php">
    <link rel="stylesheet" href="../Dashboard/style.css">

    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


</head>

<body>
    <!-- Navbar -->

    <?php include('../Dashboard/navbar.php'); ?>

    <!-- Edit Profile -->

    <div class="container">
        <div class="row gutters">
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="account-settings">
                            <div class="user-profile">
                                <div class="user-avatar d-flex justify-content-center mb-4">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Maxwell Admin">
                                </div>
                                <h6 class="user-name">
                                    <?php echo htmlspecialchars($userHandle); ?>
                                </h6>
                                <h4 class="user-name">
                                    <?php echo htmlspecialchars($firstName . " " . $lastName); ?>
                                </h4>
                                <h6 class="user-email">
                                    <?php echo htmlspecialchars($mail); ?>
                                </h6>
                            </div>
                            <div class="about mt-3">
                                <h5>About</h5>
                                <p>I'm Yuki. Full Stack Designer I enjoy creating user-centric, delightful and human experiences.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                <form action="editProfile.php" method="POST">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="row gutters">

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <h6 class="mb-2 text-primary">Personal Details</h6>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="fullName">First Name</label>
                                        <input type="text" name="firstName" class="form-control" id="fullName" placeholder="First name" value="<?php echo htmlspecialchars($firstName) ?>">
                                    </div>
                                </div>


                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="fullName">Last Name</label>
                                        <input type="text" name="lastName" class="form-control" id="fullName" placeholder="Last name" value="<?php echo htmlspecialchars($lastName) ?>">
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="fullName">Naionality</label>
                                        <input type="text" name="nationality" class="form-control" id="fullName" placeholder="Naionality" value="<?php echo htmlspecialchars($nationality) ?>">
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="fullName">Religion</label>
                                        <input type="text" name="religion" class="form-control" id="fullName" placeholder="Religion" value="<?php echo htmlspecialchars($religion) ?>">
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="eMail">Email</label>
                                        <input type="email" name="mail" class="form-control" id="eMail" placeholder="Email" value="<?php echo htmlspecialchars($mail) ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="fullName">User Name</label>
                                        <input type="text" name="userHandle" class="form-control" id="fullName" placeholder="User Name" value="<?php echo htmlspecialchars($userHandle) ?>">
                                    </div>
                                </div>

                            </div>



                            <div class="row gutters">


                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <h6 class="mt-3 mb-2 text-primary">Change Your Password</h6>
                                </div>

                                <div class="row gutters">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="oldPassword">Old Password</label>
                                            <input type="password" class="form-control" id="oldPassword" name="oldPassword" placeholder="Enter Old Password">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="password">New Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter New Password">
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="confirmPassword">Confirm Password</label>
                                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password">
                                    </div>
                                </div>

                            </div>

                            <div class="row gutters mt-2">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="text-right">

                                        <button type="submit" id="cancel" name="cancel" class="btn btn-secondary">Cancel</button>

                                        <button type="submit" id="update" name="update" class="btn btn-primary">Update</button>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>