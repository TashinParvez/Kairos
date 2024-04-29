<?php

session_start();

if (isset($_SESSION["userHandle"]))
{
    unset($_SESSION['userHandle']);
}

header('Location: login.php');
die();