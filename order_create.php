<?php include 'protect.php'; ?>

<!DOCTYPE HTML>
<html lang="en" data-bs-theme="dark">

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
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
            <div class="section-title text-light">
                <h2>Create Order</h2>
            </div>

            <?php
            include 'config/database.php';

            if ($_POST) {
                try {

                    $success = true;

                    // posted values
                    $orderId = htmlspecialchars(strip_tags($_POST['orderId']));
                    if (isset($_POST['username'])) $username = $_POST['username'];
                    $productId1 = htmlspecialchars(strip_tags($_POST['productId1']));
                    $productId2 = htmlspecialchars(strip_tags($_POST['productId2']));
                    $productId3 = htmlspecialchars(strip_tags($_POST['productId3']));
                    $quantity1 = htmlspecialchars(strip_tags($_POST['quantity1']));
                    $quantity2 = htmlspecialchars(strip_tags($_POST['quantity2']));
                    $quantity3 = htmlspecialchars(strip_tags($_POST['quantity3']));
                    $orderDate = htmlspecialchars(strip_tags($_POST['orderDate']));


                    if (empty($username)) {
                        $userError = "*Please select a username.";
                        $success = false;
                    }

                    if (empty($productId1) || empty($productId2) || empty($productId3)) {
                        $idError = "*Please select a product.";
                        $success = false;
                    }

                    if (empty($quantity1) || empty($quantity2) || empty($quantity3)) {
                        $quantityError = "*Please enter its quantity.";
                        $success = false;
                    }


                    if ($success == true) {
                        //query1 
                        $query1 = "INSERT INTO orders SET username=:username, orderDate=:orderDate";
                        $stmt1 = $con->prepare($query1);
                        $stmt1->bindParam(':username', $username);
                        $orderDate = date('Y-m-d');
                        $stmt1->bindParam(':orderDate', $orderDate);

                        if ($stmt1->execute()) {
                            $orderId = $con->lastInsertId();

                            $data = array(
                                array($orderId, $productId1, $quantity1),
                                array($orderId, $productId2, $quantity2),
                                array($orderId, $productId3, $quantity3),
                            );

                            // Insert into database
                            $query2 = "INSERT INTO orderDetails (orderId, productId, quantity) VALUES ";
                            $values = array();
                            foreach ($data as $row) {
                                $values[] = "('" . implode("', '", $row) . "')";
                            }
                            $query2 .= implode(", ", $values);

                            $stmt2 = $con->prepare($query2);

                            //execute 2nd query
                            if ($stmt2->execute()) {
                                echo "<div class='alert alert-success'>Record was saved.</div>";
                                $username = "";
                                $productId1 = "";
                                $productId2 = "";
                                $productId3 = "";
                                $quantity1 = "";
                                $quantity2 = "";
                                $quantity3 = "";
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
                        <td class="text-light">Username</td>
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
                        <td class="text-light">Product 1</td>
                        <td class="input-group">
                            <div class="col-9">
                                <select class='form-select' name='productId1' value="<?php echo isset($productId1) ? htmlspecialchars($productId1) : ''; ?>">
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
                                    <input type="number" name='quantity1' class="form-control" value="<?php echo isset($quantity1) ? htmlspecialchars($quantity1) : ''; ?>">
                                </div>
                                <?php if (isset($quantityError)) { ?>
                                    <span class="text-danger"><?php echo $quantityError; ?></span>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="text-light">Product 2</td>
                        <td class="input-group">
                            <div class="col-9">
                                <select class='form-select' name='productId2' value="<?php echo isset($productId2) ? htmlspecialchars($productId2) : ''; ?>">
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
                                    <input type="number" name='quantity2' class="form-control" value="<?php echo isset($quantity2) ? htmlspecialchars($quantity2) : ''; ?>">
                                </div>
                                <?php if (isset($quantityError)) { ?>
                                    <span class="text-danger"><?php echo $quantityError; ?></span>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="text-light">Product 3</td>
                        <td class="input-group">
                            <div class="col-9">
                                <select class='form-select' name='productId3' value="<?php echo isset($productId3) ? htmlspecialchars($productId3) : ''; ?>">
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
                                    <input type="number" name='quantity3' class="form-control" value="<?php echo isset($quantity3) ? htmlspecialchars($quantity3) : ''; ?>">
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
                            <input type='submit' value='Save' class='btn btn-primary' />
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