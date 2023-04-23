<!DOCTYPE HTML>
<html lang="en" data-bs-theme="dark">

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


        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->
        <?php
        session_start(); // start the session
        if (isset($_SESSION['warning'])) {
            // display the warning message
            echo '<div class="alert alert-danger">' . $_SESSION['warning'] . '</div>';

            // unset the warning message
            unset($_SESSION['warning']);
        }


        if (isset($_POST['submit'])) {
            include 'config/database.php';

            // posted values
            $username = htmlspecialchars(strip_tags($_POST['username']));
            $pw = $_POST['pw'];

            $success = true;


            if (empty($username)) {
                $userError = "*Please enter a username.";
                $success = false;
            }


            if (empty($pw)) {
                $pwError = "*Please enter a password.";
                $success = false;
            }


            if ($success == true) {


                // prepare query for execution
                $query = "SELECT * FROM customers WHERE username = :username";
                $stmt = $con->prepare($query);
                $stmt->bindParam(':username', $username);
                $stmt->execute();

                //return result
                $result = $stmt->rowCount();

                // check if the query returned a result
                if ($result == 1) {

                    //fetch data into user
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                    //check password
                    if ($user['pw'] == md5($pw)) {

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
                            echo "<div class='alert alert-danger'>Your account is currently inactive.</div>";
                        }
                    }
                } else {
                    // login failed
                    echo "<div class='alert alert-danger'>Invalid Username or Password</div>";
                }
            }
        }


        ?>


        <!-- html form here where the product information will be entered -->


        <h1 class="my-4 pt-4 text-center">Log In</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="row justify-content-center ">
            <div class="col-md-6 col-lg-4">
                <div class="mb-3">
                    <label for="username1" class="form-label">Username</label>
                    <input type="text" class="form-control" name='username' id="username1" aria-describedby="userHelp" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
                    <div id="userHelp" class="form-text">
                        <?php if (isset($userError)) { ?>
                            <span class="text-danger">
                                <?php echo $userError; ?>
                            </span>
                        <?php } ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password1" class="form-label">Password</label>
                    <input type="password" name='pw' class="form-control" id="password1" aria-describedby="pwHelp" value="<?php echo isset($pw) ? htmlspecialchars($pw) : ''; ?>">
                    <div id="pwHelp" class="form-text">
                        <?php if (isset($pwError)) { ?>
                            <span class="text-danger">
                                <?php echo $pwError; ?>
                            </span>
                        <?php } ?>
                    </div>
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Log In</button>
            </div>
        </form>








    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script defer="" src="https://static.cloudflareinsights.com/beacon.min.js/vb26e4fa9e5134444860be286fd8771851679335129114" integrity="sha512-M3hN/6cva/SjwrOtyXeUa5IuCT0sedyfT+jK/OV+s+D0RnzrTfwjwJHhd+wYfMm9HJSrZ1IKksOdddLuN6KOzw==" data-cf-beacon="{&quot;rayId&quot;:&quot;7b225ae4ab043c5d&quot;,&quot;token&quot;:&quot;cd0b4b3a733644fc843ef0b185f98241&quot;,&quot;version&quot;:&quot;2023.3.0&quot;,&quot;si&quot;:100}" crossorigin="anonymous"></script>



    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>