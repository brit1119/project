<?php include 'protect.php'; ?>

<!DOCTYPE HTML>
<html lang="en" data-bs-theme="dark">

<head>
    <title>PDO - Read One Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">

    <link href="assets/css/style.css" rel="stylesheet">

<body>

    <?php include 'nav.php'; ?>

    <!-- container -->

    <div class="container my-4 py-4">
        <section>
            <div class="page-header">
                <h1 class="mb-4 py-4 text-center">Customer's Details</h1>
            </div>



            <!-- PHP read one record will be here -->
            <?php
            // get passed parameter value, in this case, the record ID
            // isset() is a PHP function used to verify if a value is there or not
            $name = isset($_GET['username']) ? $_GET['username'] : die('ERROR: Record Username not found.');

            //include database connection
            include 'config/database.php';

            // read current record's data
            try {
                // prepare select query
                $query = "SELECT * FROM customers WHERE username = ? LIMIT 0,1";
                $stmt = $con->prepare($query);

                // this is the first question mark
                $stmt->bindParam(1, $name);

                // execute our query
                $stmt->execute();

                // store retrieved row to a variable
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // values to fill up our form
                //or extract all at once (extract($row))

                $name = $row['username'];
                $fName = $row['fName'];
                $lName = $row['lName'];
                $gender = $row['gender'];
                $dOB = $row['dOB'];
                $regDateNTime = $row['regDateNTime'];
                $accStatus = $row['accStatus'];
            }

            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
            ?>


            <!-- HTML read one record table will be here -->
            <!--we have our html table here where the record will be displayed-->
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td><b>Username</b></td>
                    <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td><b>First Name</b></td>
                    <td><?php echo htmlspecialchars($fName, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td><b>Last Name</b></td>
                    <td><?php echo htmlspecialchars($lName, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td><b>Gender</b></td>
                    <td><?php echo htmlspecialchars($gender, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td><b>Date of Birth</b></td>
                    <td><?php echo htmlspecialchars($dOB, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td><b>Registration Date and Time</b></td>
                    <td><?php echo htmlspecialchars($regDateNTime, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td><b>Account Status</b></td>
                    <td><?php echo htmlspecialchars($accStatus, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <a href='update.php?username={$name}' class='btn btn-primary m-r-1em'>Edit</a>
                        <a href='#' onclick='delete_user({$name});' class='btn btn-danger'>Delete</a>
                        <a href='customer_read.php' class='btn btn-dark'>Back to customer</a>
                    </td>
                </tr>
            </table>
        </section>


    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="assets/js/main.js"></script>
</body>


</html>