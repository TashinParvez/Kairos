<?php

$firstName = $lastName = $nationality = $religion = $mail = $userHandle = $password = $confirmPassword = '';
$errors = array('firstName' => '', 'lastName' => '', 'nationality' => '', 'religion' => '', 'mail' => '', 'userHandle' => '', 'password' => '', 'confirmPassword' => '');

if (isset($_POST['signUp'])) {

    //...................... Database Connection ..............................

    // connect to the database
    $conn = mysqli_connect('localhost', 'root', '', 'kairos');

    // check connection
    if (!$conn) {
        echo 'Connection error: ' . mysqli_connect_error();
    }

    //.............................*******************.............................

    //................ Retrieve all data  from input field ...............
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $nationality = $_POST['nationality'];
    $religion = $_POST['religion'];
    $mail = $_POST['mail'];
    $userHandle = $_POST['userHandle'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    //................... escape sql chars .....................
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
    $religion = mysqli_real_escape_string($conn, $_POST['religion']);
    $mail = mysqli_real_escape_string($conn, $_POST['mail']);
    $userHandle = mysqli_real_escape_string($conn, $_POST['userHandle']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    //.............. All input field validation checking ...................
    // check first name
    if (empty($firstName)) {
        $errors['firstName'] = 'This field cannot be empty!';
    } else {
        if (!preg_match('/^[a-zA-Z\s]+$/', $firstName)) {
            $errors['firstName'] = 'This field contains letters and space only';
        }
    }

    // check last name
    if (empty($lastName)) {
        $errors['lastName'] = 'This field cannot be empty!';
    } else {
        if (!preg_match('/^[a-zA-Z0-9\s\.]+$/', $lastName)) {
            $errors['lastName'] = 'This field contains letters and spaces only';
        }
    }

    // check nationality
    if (empty($nationality)) {
        $errors['nationality'] = 'This field cannot be empty!';
    } else {
        if (!preg_match('/^[a-zA-Z0-9\s\.]+$/', $nationality)) {
            $errors['nationality'] = 'This field contains letters and spaces only';
        }
    }

    // check religion
    if (empty($religion)) {
        $errors['religion'] = 'This field cannot be empty!';
    } else {
        if (!preg_match('/^[a-zA-Z\s]+$/', $religion)) {
            $errors['religion'] = 'This field contains letters and spaces only';
        }
    }

    // check email
    if (empty($mail)) {
        $errors['mail'] = 'This field cannot be empty!';
    } else {
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $errors['mail'] = 'Invalid email';
        } else {

            // Duplication checking for email
            $sql = "SELECT userHandle FROM user_info WHERE mail = '$mail'";
            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                $errors['mail'] = 'Sorry, this email is already registered.
                                    Please use a different one';
            }
        }
    }

    // check user handle
    if (empty($userHandle)) {
        $errors['userHandle'] = 'This field cannot be empty!';
    } else {
        if (strlen($userHandle) < 8) {
            $errors['userHandle'] = 'User handle length(8-20)';
        } else if ((!preg_match('/^[a-zA-Z0-9\-\@\_\.]+$/', $userHandle)) ||
            (!(strtoupper($userHandle[0]) >= 'A' || strtoupper($userHandle[0]) <= 'Z'))
        ) {
            $errors['userHandle'] = 'Invalid user handle';
        } else {

            // Duplication checking for user handle
            $sql = "SELECT userHandle FROM user_info WHERE userHandle = '$userHandle'";
            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                $errors['userHandle'] = 'The username you entered is not available.
                                            Please try another one';
            }
        }
    }

    // check password
    if (empty($password)) {
        $errors['password'] = 'This field cannot be empty!';
    } else {
        if (strlen($password) < 8) {
            $errors['password'] = 'Password length(8-20)';
        }
    }

    // check confirm password
    if (!empty($password) && $confirmPassword !== $password) {
        $errors['confirmPassword'] = "Password doesn't match";
    }

    if (!array_filter($errors)) {

        // create sql
        $sql = "INSERT INTO user_info(firstName, lastName, nationality, religion, mail, userHandle, password)
                VALUES('$firstName', '$lastName', '$nationality', '$religion', '$mail', '$userHandle','$password')";

        // save to db and check
        if (mysqli_query($conn, $sql)) {
            // success
            header('Location: #');
        } else {
            echo 'query error: ' . mysqli_error($conn);
        }

        // close connection
        mysqli_close($conn);
    }
} // end POST check

?>

<!DOCTYPE html>
<html>


<section class="container grey-text">
    <h4 class="center">Sign Up</h4>
    <form class="white" action="signUp.php" method="POST">
        <label>First Name</label>
        <input type="text" name="firstName" value="<?php echo htmlspecialchars($firstName) ?>">
        <div class="red-text"><?php echo $errors['firstName']; ?></div>

        <label>Last Name</label>
        <input type="text" name="lastName" value="<?php echo htmlspecialchars($lastName) ?>">
        <div class="red-text"><?php echo $errors['lastName']; ?></div>

        <label>Nationality</label>
        <input type="text" name="nationality" value="<?php echo htmlspecialchars($nationality) ?>">
        <div class="red-text"><?php echo $errors['nationality']; ?></div>

        <label>Religion</label>
        <input type="text" name="religion" value="<?php echo htmlspecialchars($religion) ?>">
        <div class="red-text"><?php echo $errors['religion']; ?></div>

        <label>Email</label>
        <input type="text" name="mail" value="<?php echo htmlspecialchars($mail) ?>">
        <div class="red-text"><?php echo $errors['mail']; ?></div>

        <label>User Handle</label>
        <input type="text" name="userHandle" value="<?php echo htmlspecialchars($userHandle) ?>">
        <div class="red-text"><?php echo $errors['userHandle']; ?></div>

        <label>Password</label>
        <input type="password" name="password" value="<?php echo htmlspecialchars($password) ?>">
        <div class="red-text"><?php echo $errors['password']; ?></div>

        <label>Confirm Password</label>
        <input type="password" name="confirmPassword" value="<?php echo htmlspecialchars($confirmPassword) ?>">
        <div class="red-text"><?php echo $errors['confirmPassword']; ?></div>

        <input type="submit" name="signUp" value="Sign Up" class="btn brand z-depth-0">

        <div class="center login">
            <span>Already have an account? </span>
            <a href="/login.php">Login</a>
        </div>
        </div>
    </form>
</section>


</html>