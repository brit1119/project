<?php
// include database connection
include 'config/database.php';

try {
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $user = isset($_GET['username']) ? $_GET['username'] :  die('ERROR: Record ID not found.');


    // check wether have product in any order
    $query = "SELECT username FROM orders WHERE username = ? LIMIT 0,1";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $user);
    $stmt->execute();
    $num = $stmt->rowCount();

    if ($num > 0) {
        header('Location:customer_read.php?action=failed');
    } else {
        // delete query
        $query = "DELETE FROM customers WHERE username = ?";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $user);

        if ($stmt->execute()) {
            // redirect to read records page and
            // tell the user record was deleted
            header('Location: customer_read.php?action=deleted');
        } else {
            die('Unable to delete record.');
        }
    }
}
// show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
