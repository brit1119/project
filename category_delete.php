<?php
// include database connection
include 'config/database.php';
try {
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $catId = isset($_GET['catId']) ? $_GET['catId'] :  die('ERROR: Record ID not found.');


    // check wether have product in any cat
    $query = "SELECT catId FROM products WHERE catId = ? LIMIT 0,1";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $catId);
    $stmt->execute();
    $num = $stmt->rowCount();

    if ($num > 0) {
        header('Location:category_read.php?action=failed');
    } else {
        // delete query
        $query = "DELETE FROM category WHERE catId = ?";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $catId);

        if ($stmt->execute()) {
            // redirect to read records page and
            // tell the user record was deleted
            header('Location: category_read.php?action=deleted');
        } else {
            die('Unable to delete record.');
        }
    }
}
// show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
