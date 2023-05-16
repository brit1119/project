<?php include 'protect.php'; ?>

<!DOCTYPE HTML>
<html lang="en" data-bs-theme="dark">

<head>
    <title>Customer Update</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link href="assets/css/style.css" rel="stylesheet">

    <!-- custom css -->
    <style>
        .m-r-1em {
            margin-right: 1em;
        }

        .m-b-1em {
            margin-bottom: 1em;
        }

        .m-l-1em {
            margin-left: 1em;
        }

        .mt0 {
            margin-top: 0;
        }
    </style>
</head>

<body>

    <?php include 'nav.php'; ?>

    <!-- container -->
    <div class="container">
        <section class="pricing section-bg">
            <div class="page-header">
                <h1 class="mb-4 py-4 text-center">Customer Update</h1>
            </div>
            <!-- PHP read record by ID will be here -->
            <?php
            // get passed parameter value, in this case, the record ID
            // isset() is a PHP function used to verify if a value is there or not
            $name = isset($_GET['username']) ? $_GET['username'] : die('ERROR: Record ID not found.');

            //include database connection
            include 'config/database.php';

            // read current record's data
            try {
                // prepare select query
                $query = "SELECT username, fName, lName, pw, gender, dOB, regDateNTime FROM customers WHERE username = ? LIMIT 0,1 ";
                $stmt = $con->prepare($query);

                // this is the first question mark
                $stmt->bindParam(1, $name);

                // execute our query
                $stmt->execute();

                // store retrieved row to a variable
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // values to fill up our form
                $user = $row['username'];
                $fName = $row['fName'];
                $lName = $row['lName'];
                $pw = $row['pw'];
                $gender = $row['gender'];
                $dOB = $row['dOB'];
                $regDateNTime = $row['regDateNTime'];
            }

            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
            ?>

            <!-- HTML form to update record will be here -->
            <!-- PHP post to update record will be here -->
            <?php
            // check if form was submitted

            $success = true;
            $string = $success ? 'true' : 'false';

            if ($_POST) {
                try {
                    // password validation 
                    if (!empty($_POST["newP"]) || !empty($_POST["oldP"]) || !empty($_POST["conP"])) {

                        $oldP = $_POST['oldP'];
                        $newP = $_POST['newP'];
                        $conP = $_POST['conP'];

                        if (empty($oldP)) {
                            $oldErr = "*Please enter old password";
                            $success = false;
                        }
                        if (empty($newP)) {
                            $newErr = "*Please enter new password";
                            $success = false;
                        }

                        if (empty($conP)) {
                            $conErr = "*Please enter confirm password";
                            $success = false;
                        }

                        if (md5($oldP) == $pw) {

                            if ($oldP == $newP) {
                                $newErr = "*New password cannot be the same as your old password";
                                $success = false;
                            } elseif ($newP != $conP) {
                                $conErr = "*Please type the correct new password";
                                $success = false;
                            }
                        } else {
                            $oldErr = "*Old Password does not match";
                            $success = false;
                        }
                    }


                    if (empty($_POST["fName"])) {
                        $fNameErr = "*First name is required";
                        $success = false;
                    } else {
                        $fName = htmlspecialchars(strip_tags($_POST['fName']));
                    }

                    $gender = htmlspecialchars(strip_tags($_POST['gender']));
                    $dOB = htmlspecialchars(strip_tags($_POST['dOB']));

                    if (empty($_POST["lName"])) {
                        $lNameErr = "*Last name is required";
                        $success = false;
                    } else {
                        $lName = htmlspecialchars(strip_tags($_POST['lName']));
                    }




                    if ($success) {

                        // write update query
                        $query = '';
                        if (empty($newP)) {
                            $query = "UPDATE customers SET fName=:fName, lName=:lName, gender=:gender, dOB=:dOB WHERE username = :username";
                        } else {
                            $query = "UPDATE customers SET pw=:pw, fName=:fName, lName=:lName, gender=:gender, dOB=:dOB WHERE username = :username";
                        }

                        // in this case, it seemed like we have so many fields to pass and
                        // it is better to label them and not use question marks

                        // prepare query for excecution
                        $stmt = $con->prepare($query);
                        // bind the parameters
                        $stmt->bindParam(':fName', $fName);
                        $stmt->bindParam(':lName', $lName);
                        if (!empty($newP)) {
                            $stmt->bindParam(':pw', md5($newP));
                        }
                        $stmt->bindParam(':gender', $gender);
                        $stmt->bindParam(':dOB', $dOB);
                        $stmt->bindParam(':username', $user);
                        // Execute the query
                        if ($stmt->execute()) {
                            echo "<div class='alert alert-success'>Record was updated.</div>";
                        } else {
                            echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                        }
                    }
                }

                // show errors
                catch (PDOException $exception) {
                    die('ERROR: ' . $exception->getMessage());
                }
            }

            ?>


            <!--we have our html form here where new record information can be updated-->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?username={$name}"); ?>" method="post">
                <table class='table table-hover table-borderless'>
                    <tr>
                        <td>Username</td>
                        <td><?php echo htmlspecialchars($user, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td>First name</td>
                        <td><input type='text' name='fName' value="<?php echo htmlspecialchars($fName, ENT_QUOTES);  ?>" class='form-control' />
                            <?php if (isset($fNameErr)) { ?>
                                <span class="text-danger">
                                    <?php echo $fNameErr; ?>
                                </span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Last name</td>
                        <td><input type='text' name='lName' value="<?php echo htmlspecialchars($lName, ENT_QUOTES);  ?>" class='form-control' />
                            <?php if (isset($lNameErr)) { ?>
                                <span class="text-danger">
                                    <?php echo $lNameErr; ?>
                                </span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Old password</td>
                        <td><input type='password' name='oldP' class='form-control' />
                            <?php if (isset($oldErr)) { ?>
                                <span class="text-danger">
                                    <?php echo $oldErr; ?>
                                </span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>New password</td>
                        <td><input type='password' name='newP' class='form-control' />
                            <?php if (isset($newErr)) { ?>
                                <span class="text-danger">
                                    <?php echo $newErr; ?>
                                </span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Confirm new password</td>
                        <td><input type='password' name='conP' class='form-control' />
                            <?php if (isset($conErr)) { ?>
                                <span class="text-danger">
                                    <?php echo $conErr; ?>
                                </span>
                            <?php } ?>
                        </td>
                    </tr>

                    <tr>
                        <td>Gender</td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" id="male" type="radio" name="gender" value="male" <?php if ($gender == "male") {
                                                                                                                        echo "checked";
                                                                                                                    } ?>>
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="female" <?php
                                                                                                                        if ($gender == "female") {
                                                                                                                            echo "checked";
                                                                                                                        } ?>>
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Date of birth</td>
                        <td><input type="date" name="dOB" value="<?php echo $dOB; ?>" class='form-control' />
                        </td>
                    </tr>
                    <tr>
                        <td>Registration Date</td>
                        <td><?php echo htmlspecialchars($regDateNTime, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type='submit' value='Save Changes' class='btn btn-primary' />
                            <a href='customer_read.php' class='btn btn-dark border-secondary-subtle'>Back to My Customers</a>
                        </td>
                    </tr>
                </table>
            </form>
        </section>


    </div>
    <!-- end .container -->
</body>

</html>