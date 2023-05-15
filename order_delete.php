<?php
// include database connection
include 'config/database.php';
try {
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $orderId = isset($_GET['orderId']) ? $_GET['orderId'] :  die('ERROR: Record ID not found.');


    // delete query
    $query = "DELETE FROM orders WHERE orderId = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $orderId);


    if ($stmt->execute()) {
        // delete from orderdetails too
        $query = "DELETE FROM orderDetails WHERE orderId = ?";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $orderId);


        if ($stmt->execute()) {
            // redirect to read records page and
            // tell the user record was deleted
            header('Location:order_read.php?action=deleted');
        } else {
            die('Unable to delete in order details.');
        }
    } else {
        die('Unable to delete order.');
    }
}
// show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
