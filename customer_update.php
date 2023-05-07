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
            $username = isset($_GET['username']) ? $_GET['username'] : die('ERROR: Record ID not found.');

            //include database connection
            include 'config/database.php';

            // read current record's data
            try {
                // prepare select query
                $query = "SELECT username, fName, lName, pw, gender, dOB, regDateNTime FROM customers WHERE username = ? LIMIT 0,1 ";
                $stmt = $con->prepare($query);

                // this is the first question mark
                $stmt->bindParam(1, $username);

                // execute our query
                $stmt->execute();

                // store retrieved row to a variable
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // values to fill up our form
                $username = $row['username'];
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

            if ($_POST) {
                try {
                    // password validation 
                    if (!empty($_POST["pw"]) || !empty($_POST["oldP"]) || !empty($_POST["conP"])) {

                        // check old pw is same as recorded
                        if (md5($_POST['oldP']) == $pw) {

                            // check posted old and new pw is same 
                            if (md5($_POST['oldP']) == md5($_POST['pw'])) {
                                $pwErr = "*New password cannot be the same as your old password";
                                $success = false;
                            } else {
                                $pw = md5($_POST['pw']);
                            }

                            // check con pw
                            if (empty($_POST["conP"])) {
                                $conErr = "*Please comfirm your password";
                                $success = false;
                            } else {
                                $conP = ($_POST['conP']);
                                if (($_POST['pw']) != ($_POST['conP'])) {
                                    $conErr = "*Please type the correct new password";
                                    $success = false;
                                }
                            }
                        } else {
                            $oldErr = "*Please type you old password";
                            $success = false;
                        }
                    }

                    if (empty($_POST["fName"])) {
                        $fNameErr = "*First name is required";
                        $flag = false;
                    } else {
                        $fName = htmlspecialchars(strip_tags($_POST['fName']));
                    }

                    if (empty($_POST["lName"])) {
                        $lNameErr = "*Last name is required";
                        $flag = false;
                    } else {
                        $lName = htmlspecialchars(strip_tags($_POST['lName']));
                    }

                    $gender = htmlspecialchars(strip_tags($_POST['gender']));
                    $dOB = htmlspecialchars(strip_tags($_POST['dOB']));




                    if ($success == true) {
                        // write update query
                        // in this case, it seemed like we have so many fields to pass and
                        // it is better to label them and not use question marks
                        $query = "UPDATE customers SET pw=:pw, fName=:fName, lName=:lName, gender=:gender, dOB=:dOB WHERE username = :username";
                        // prepare query for excecution
                        $stmt = $con->prepare($query);
                        // bind the parameters
                        $stmt->bindParam(':fName', $fName);
                        $stmt->bindParam(':lName', $lName);
                        $stmt->bindParam(':pw', $pw);
                        $stmt->bindParam(':gender', $gender);
                        $stmt->bindParam(':dOB', $dOB);
                        // Execute the query
                        if ($stmt->execute()) {
                            echo "<div class='alert alert-success'>Record was updated.</div>";
                        } else {
                            echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                    }
                }
                // show errors
                catch (PDOException $exception) {
                    die('ERROR: ' . $exception->getMessage());
                }
            } ?>


            <!--we have our html form here where new record information can be updated-->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?username={$username}"); ?>" method="post">
                <table class='table table-hover table-borderless'>
                    <tr>
                        <td>Username</td>
                        <td><?php echo htmlspecialchars($username, ENT_QUOTES);  ?></td>
                    </tr>
                    </tr>
                    <tr>
                        <td>First name</td>
                        <td><input type='text' name='fName' value="<?php echo htmlspecialchars($fName, ENT_QUOTES);  ?>" class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Last name</td>
                        <td><input type='text' name='lName' value="<?php echo htmlspecialchars($lName, ENT_QUOTES);  ?>" class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Old password</td>
                        <td><input type='password' name='oldP' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>New password</td>
                        <td><input type='password' name='newP' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Confirm new password</td>
                        <td><input type='password' name='conP' class='form-control' /></td>
                    </tr>

                    <tr>
                        <td>Gender</td>
                        <td><input type='radio' id=male name='gender' value="male" <?php
                                                                                    if ($gender == 'male') {
                                                                                        echo "checked";
                                                                                    } ?> />
                            <label for="male">Male</label>

                            <input type='radio' id=female name='gender' value="female" <?php
                                                                                        if ($gender == 'female') {
                                                                                            echo "checked";
                                                                                        } ?> />
                            <label for="female">Female</label>
                        </td>
                    </tr>
                    <tr>
                        <td>Date of birth</td>
                        <td><input type="date" id="dOB" name="dOB" value="
                        <?php echo htmlspecialchars($dOB, ENT_QUOTES);  ?>" class='form-control' />
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