<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <meta charset="utf-8">
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

</head>

<body>
    <!-- container -->
    <div class="container">
        <div class="py-4">
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="product_create.php">Create Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="customer_create.php">Create Customer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact Us</a>
                </li>
            </ul>
        </div>

        <div class="page-header">
            <h1>Create Customer</h1>
        </div>

        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->
        <?php
        if ($_POST) {
            // include database connection
            include 'config/database.php';
            try {

                // posted values
                $username = htmlspecialchars(strip_tags($_POST['username']));
                $pw = htmlspecialchars(strip_tags($_POST['pw']));
                $cpw =  htmlspecialchars(strip_tags($_POST['cpw']));
                $fName = htmlspecialchars(strip_tags($_POST['fName']));
                $lName = htmlspecialchars(strip_tags($_POST['lName']));
                if (isset($_POST['gender'])) $gender = $_POST['gender'];
                $dOB = htmlspecialchars(strip_tags($_POST['dOB']));
                if (isset($_POST['accStatus'])) $accStatus = $_POST['accStatus'];


                $success = true;



                if (empty($username) || empty($pw) || empty($cpw) || empty($fName) || empty($lName) || empty($dOB) || empty($accStatus)) {
                    echo "<div class='alert alert-danger'>Please fill in all the field other than gender.</div>";
                    $success = false;
                }

                if ($cpw !== $pw) {
                    echo "<div class='alert alert-danger'>Password is not matched.</div>";
                    $success = false;
                }

                if (strlen($username) < 6) {
                    echo "<div class='alert alert-danger'>Username must be at least 6 characters.</div>";
                    $success = false;
                }

                if (strlen($pw) < 8 || strlen($cpw) < 8) {
                    echo "<div class='alert alert-danger'>Password must be at least 8 characters.</div>";
                    $success = false;
                }



                if ($success == true) {
                    // insert query + add ex
                    $query = "INSERT INTO products SET username=:username, pw=:pw, fName=:fName, lName=:lName, gender=:gender, dOB=:dOB, regDateNTime=:regDateNTime, accStatus=:accStatus";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
                    // bind the parameters
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':pw', $pw);
                    $stmt->bindParam(':pw', $pw);
                    $stmt->bindParam(':fName', $fName);
                    $stmt->bindParam(':lName', $lName);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':dOB', $dOB);
                    $stmt->bindParam(':accStatus', $accStatus);

                    // specify when this record was inserted to the database
                    $regDateNTime = date('Y-m-d H:i:s');
                    $stmt->bindParam(':regDateNTime', $regDateNTime);

                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                    }
                }
            }
            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>


        <!-- html form here where the product information will be entered -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Username</td>
                    <td><input type='text' name='username' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type='password' name='pw' class='form-control'></td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td><input type='password' name='cpw' class='form-control'></td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td><input type='text' name='fName' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type='text' name='lName' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td><input type="radio" name="gender" value="male" /> Male
                        <input type="radio" name="gender" value="female" /> Female
                </tr>
                <tr>
                    <td>Date of Birth</td>
                    <td><input type='date' name='dOB' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Account Status</td>
                    <td><input type="radio" name="accStatus" value="active" /> Active
                        <input type="radio" name="accStatus" value="inactive" /> Inactive
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='index.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>


    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>