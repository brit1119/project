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
        <div class="page-header">
            <h1>LOG IN</h1>
        </div>

        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->
        <?php
        session_start(); // start the session

        if (isset($_POST['submit'])) {
            include 'config/database.php';

            // posted values
            $username = htmlspecialchars(strip_tags($_POST['username']));
            $pw = htmlspecialchars(strip_tags($_POST['pw']));

            $success = true;


            if (empty($username)) {
                $userError = "*Please enter a username.";
                $success = false;
            } elseif (strlen($username) < 6) {
                $userError = "*Username must be at least 6 characters.";
                $success = false;
            } elseif ($username == trim($username)) {
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
            }


            if ($success == true) {


                // prepare query for execution
                $query = "SELECT * FROM customers WHERE username = :username AND pw = :pw";
                $stmt = $con->prepare($query);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':pw', $pw);
                $stmt->execute();

                //return result
                $result = $stmt->rowCount();

                // check if the query returned a result
                if ($result == 1) {

                    //fetch data into user
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                    //check account status
                    if ($user['accStatus'] == 'active') {
                        // login successful
                        // set the session variable
                        $_SESSION['username'] = $username;

                        // redirect to the dashboard
                        header("Location: index.php");
                        exit();
                    } else {
                        // account is inactive
                        $error = "Your account is currently inactive.";
                        echo "<div class='alert alert-danger'>Your account is currently inactive.</div>";
                    }
                } else {
                    // login failed
                    $error = "Invalid username or password.";
                    echo "<div class='alert alert-danger'>Invalid Username or Password</div>";
                }
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
                    <td></td>
                    <td>
                        <input type='submit' name='submit' value='Log in' class='btn btn-primary' />
                    </td>
                </tr>
            </table>
        </form>


    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>



    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>