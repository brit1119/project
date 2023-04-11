<?php
session_start();

if (!isset($_SESSION["username"])) {
    $warning = "You need to log in to access this page.";
    $_SESSION['warning'] = $warning;

    header("Location:login.php");
}
