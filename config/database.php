<?php
// used to connect to the database
$host = "localhost";
$db_name = "brit1119";
$Username = "brit1119";
$password = "Xh50iAlxzo0wTP8@";

try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $Username, $password);
}

// show error
catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
}
