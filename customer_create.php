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
    <?php include 'nav.php'; ?>

    <div class="container">
        <div class="page-header">
            <h1 class="mb-4 py-4 text-center">Create Customer</h1>
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
                $pw = $_POST['pw'];
                $cpw =  $_POST['cpw'];
                $fName = htmlspecialchars(strip_tags($_POST['fName']));
                $lName = htmlspecialchars(strip_tags($_POST['lName']));
                if (isset($_POST['gender'])) $gender = $_POST['gender'];
                $dOB = htmlspecialchars(strip_tags($_POST['dOB']));
                if (isset($_POST['accStatus'])) $accStatus = $_POST['accStatus'];


                $success = true;


                if (empty($username)) {
                    $userError = "*Please enter a username.";
                    $success = false;
                } elseif (strlen($username) < 6) {
                    $userError = "*Username must be at least 6 characters.";
                    $success = false;
                } elseif ($username !== trim($username)) {
                    //check if username contains space
                    $userError = "*Username cannot contain white space.";
                    $success = false;
                } elseif (!preg_match('@[A-Z]@', $username) || !preg_match('@[a-z]@', $username) || !preg_match('@[0-9]@', $username)) {
                    // check if username meets the requirements
                    $userError = "*Username must contain at least one letter, one number, and one symbol.";
                    $success = false;
                }


                if (empty($pw)) {
                    $pwError = "*Please enter a password.";
                    $success = false;
                } elseif (strlen($pw) < 8) {
                    $pwError = "*Password must be at least 8 characters.";
                    $success = false;
                } elseif (empty($cpw)) {
                    $cpwError = "*Please enter to confirm password.";
                    $success = false;
                } elseif ($cpw !== $pw) {
                    $cpwError = "*Password not matched.";
                    $success = false;
                } else {
                    $pw = md5($pw);
                }


                if (empty($fName)) {
                    $fNameError = "*Please enter first name.";
                    $success = false;
                }

                if (empty($lName)) {
                    $lNameError = "*Please enter last name.";
                    $success = false;
                }

                if (empty($dOB)) {
                    $dOBError = "*Please select date of birth.";
                    $success = false;
                }

                if (empty($accStatus)) {
                    $accStatusError = "*Please select account status.";
                    $success = false;
                }







                if ($success == true) {
                    // insert query
                    $query = "INSERT INTO customers SET username=:username, pw=:pw, fName=:fName, lName=:lName, gender=:gender, dOB=:dOB, regDateNTime=:regDateNTime, accStatus=:accStatus";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
                    // bind the parameters
                    $stmt->bindParam(':username', $username);
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
                        $username = "";
                        $pw = "";
                        $cpw = "";
                        $fName = "";
                        $lName = "";
                        $gender = "";
                        $dOB = "";
                        $accStatus = "";
                    } else {
                        echo "<div class='alert alert-danger'>Username already exist. Please enter another username.</div>";
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
                    <td><input type='text' name='username' class='form-control' value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" />
                        <?php if (isset($userError)) { ?>
                            <span class="text-danger">
                                <?php echo $userError; ?>
                            </span>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type='password' name='pw' class='form-control' value="<?php echo isset($pw) ? htmlspecialchars($pw) : ''; ?>" />
                        <?php if (isset($pwError)) { ?>
                            <span class="text-danger">
                                <?php echo $pwError; ?>
                            </span>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td><input type='password' name='cpw' class='form-control' value="<?php echo isset($cpw) ? htmlspecialchars($cpw) : ''; ?>" />
                        <?php if (isset($cpwError)) { ?>
                            <span class="text-danger">
                                <?php echo $cpwError; ?>
                            </span>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td><input type='text' name='fName' class='form-control' value="<?php echo isset($fName) ? htmlspecialchars($fName) : ''; ?>" />
                        <?php if (isset($fNameError)) { ?>
                            <span class="text-danger">
                                <?php echo $fNameError; ?>
                            </span>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type='text' name='lName' class='form-control' value="<?php echo isset($lName) ? htmlspecialchars($lName) : ''; ?>" />
                        <?php if (isset($lNameError)) { ?>
                            <span class="text-danger">
                                <?php echo $lNameError; ?>
                            </span>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>
                        <input type="radio" name="gender" value="male" /> Male
                        <input type="radio" name="gender" value="female" /> Female

                </tr>
                <tr>
                    <td>Date of Birth</td>
                    <td><input type='date' name='dOB' class='form-control' value="<?php echo isset($dOB) ? htmlspecialchars($dOB) : ''; ?>" />
                        <?php if (isset($dOBError)) { ?>
                            <span class="text-danger">
                                <?php echo $dOBError; ?>
                            </span>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Account Status</td>
                    <td>
                        <input type="radio" name="accStatus" value="active" /> Active
                        <input type="radio" name="accStatus" value="inactive" /> Inactive
                        <?php if (isset($accStatusError)) { ?>
                            <span class="text-danger">
                                <?php echo $accStatusError; ?>
                            </span>
                        <?php } ?>

                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='customer_read.php' class='btn btn-danger'>Back to My Customer</a>
                    </td>
                </tr>
            </table>
        </form>


    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>