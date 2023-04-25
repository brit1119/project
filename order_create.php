<?php include 'protect.php'; ?>

<!DOCTYPE HTML>
<html lang="en" data-bs-theme="dark">

<head>
    <title>Create Order</title>
    <meta charset="utf-8">
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>


    <!-- container -->
    <?php include 'nav.php'; ?>

    <div class="container">
        <section>
            <div class="page-header">
                <h1 class="mb-4 py-4 text-center">Create Order</h1>
            </div>

            <?php
            include 'config/database.php';

            if ($_POST) {
                try {

                    $success = true;

                    // posted values
                    $orderId = htmlspecialchars(strip_tags($_POST['orderId']));
                    if (isset($_POST['username'])) $username = $_POST['username'];
                    $productId = $_POST['productId'];
                    $quantity = $_POST['quantity'];



                    if (empty($username)) {
                        $userError = "*Please select a username.";
                        $success = false;
                    }

                    foreach ($productId as $product) {
                        if (empty($product)) {
                            $idError = "*Please select a product.";
                            $success = false;
                        }
                    }

                    foreach ($quantity as $eachQuantity) {
                        if (empty($eachQuantity)) {
                            $quantityError = "*Please enter its quantity.";
                            $success = false;
                        }
                    }

                    // for ($x = 0; $x < count($productId); $x++) {
                    //     $data[] = "('" . $orderId . "', '" . $productId[$x] . "', '" . $quantity[$x] . "')";

                    //     if (empty($productId)) {
                    //         $idError = "*Please select a product.";
                    //         $success = false;
                    //     }

                    //     if (empty($quantity)) {
                    //         $quantityError = "*Please enter its quantity.";
                    //         $success = false;
                    //     }
                    // }




                    if ($success == true) {
                        //query1 
                        $query1 = "INSERT INTO orders SET username=:username, orderDate=:orderDate";
                        $stmt1 = $con->prepare($query1);
                        $stmt1->bindParam(':username', $username);
                        $orderDate = date('Y-m-d');
                        $stmt1->bindParam(':orderDate', $orderDate);

                        if ($stmt1->execute()) {
                            $orderId = $con->lastInsertId();


                            // Insert into database
                            $query2 = "INSERT INTO orderDetails (orderId, productId, quantity) VALUES ";
                            $values = array();
                            for ($x = 0; $x < count($productId); $x++) {
                                $values[] = "('" . $orderId . "', '" . $productId[$x] . "', '" . $quantity[$x] . "')";
                            }
                            $query2 = $query2 . implode(", ", $values);
                            $stmt2 = $con->prepare($query2);

                            //execute 2nd query
                            if ($stmt2->execute()) {
                                echo "<div class='alert alert-success'>Record was saved.</div>";
                                $username = "";
                                $productId = "";
                                $quantity = "";
                            } else {
                                echo "<div class='alert alert-danger'>Unable to save order details.</div>";
                            }
                        } else {
                            echo "<div class='alert alert-danger'>Unable to save order.</div>";
                        }
                    }
                }


                // show error
                catch (PDOException $exception) {
                    die('ERROR: ' . $exception->getMessage());
                }
            }

            ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <table class='table table-hover table-borderless'>
                    <tr>
                        <td class="text-light col-2">Username</td>
                        <td>
                            <select class='form-select' name='username' value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
                                <option selected>Select a Username</option>

                                <?php

                                $query = "SELECT username FROM customers";
                                $stmt = $con->prepare($query);
                                $stmt->execute();
                                $num = $stmt->rowCount();
                                if ($num > 0) {
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);

                                ?>
                                        <option value="<?php echo $username; ?>"><?php echo $username; ?> </option>
                                <?php
                                    }
                                }
                                ?>

                            </select>
                            <?php if (isset($userError)) { ?>
                                <span class="text-danger"> <?php echo $userError; ?> </span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-light">Product</td>
                        <td class="input-group">
                            <div class="col-9">
                                <select class='form-select' name='productId[]' value="<?php echo isset($productId) ? htmlspecialchars($productId) : ''; ?>">
                                    <option selected>Select a Product</option>

                                    <?php

                                    $query = "SELECT productId, productName FROM products";
                                    $stmt = $con->prepare($query);
                                    $stmt->execute();
                                    $num = $stmt->rowCount();
                                    if ($num > 0) {
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            extract($row);

                                    ?>
                                            <option value="<?php echo $productId; ?>"><?php echo $productName; ?> </option>
                                    <?php
                                        }
                                    }
                                    ?>

                                </select>
                                <?php if (isset($idError)) { ?>
                                    <span class="text-danger"> <?php echo $idError; ?> </span>
                                <?php } ?>

                            </div>

                            <div class="col-3">
                                <div class="input-group">
                                    <span class="input-group-text">Quantity</span>
                                    <input type="number" name='quantity[]' class="form-control" value="<?php echo isset($quantity) ? htmlspecialchars($quantity) : ''; ?>">
                                </div>
                                <?php if (isset($quantityError)) { ?>
                                    <span class="text-danger"><?php echo $quantityError; ?></span>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>


                    <tr>
                        <td></td>
                        <td>
                            <input type='submit' value='Create Order' class='btn btn-primary' />
                            <a href='order_read.php' class='btn btn-dark border-secondary-subtle'>Back to My Orders</a>
                        </td>
                    </tr>
                </table>
            </form>

        </section>

    </div>


    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!-- Vendor JS Files -->
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>