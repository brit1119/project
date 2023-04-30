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
                    if (isset($_POST['customer'])) $customer = $_POST['customer'];
                    if (isset($_POST['product'])) $product = $_POST['product'];
                    if (isset($_POST['quantity'])) $quantity = $_POST['quantity'];



                    if (empty($customer)) {
                        $userError = "*Please select a customer.";
                        $success = false;
                    }

                    foreach ($product as $eachProduct) {
                        if (empty($eachProduct)) {
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




                    if ($success == true) {

                        $flag = true;
                        //query1 
                        $query1 = "INSERT INTO orders SET username=:username, orderDate=:orderDate";
                        $stmt1 = $con->prepare($query1);
                        $stmt1->bindParam(':username', $customer);
                        $orderDate = date('Y-m-d');
                        $stmt1->bindParam(':orderDate', $orderDate);

                        if ($stmt1->execute()) {
                            $orderId = $con->lastInsertId();


                            // Insert into database
                            $query2 = "INSERT INTO orderDetails (orderId, productId, quantity) VALUES ";
                            $values = array();
                            for ($x = 0; $x < count($product); $x++) {
                                $values[] = "('" . $orderId . "', '" . $product[$x] . "', '" . $quantity[$x] . "')";
                            }
                            $query2 .= implode(", ", $values);
                            $stmt2 = $con->prepare($query2);

                            //execute 2nd query
                            if ($stmt2->execute()) {
                                echo "<div class='alert alert-success'>Order was saved successfully.</div>";
                                $customer = "";
                                $product = "";
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
                        <td class="text-light col-2">Customer</td>
                        <td>
                            <select class='form-select' name='customer' value="<?php echo isset($customer) ? htmlspecialchars($customer) : ''; ?>">
                                <option selected value="">Select a Customer</option>

                                <?php

                                $query = "SELECT username, fName, lName FROM customers";
                                $stmt = $con->prepare($query);
                                $stmt->execute();
                                $num = $stmt->rowCount();
                                if ($num > 0) {
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);

                                ?>
                                        <option value="<?php echo $username; ?>"><?php echo $fName . ' ' . $lName; ?> </option>
                                <?php
                                    }
                                }
                                ?>

                            </select>
                            <?php echo $customer;
                            if (isset($userError)) { ?>
                                <span class="text-danger"> <?php echo $userError; ?> </span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-light">Product</td>
                        <td class="input-group">
                            <div class="col-9">
                                <select class='form-select' name='product[]' value="<?php echo isset($product) ? htmlspecialchars($product) : ''; ?>">
                                    <option selected value="">Select a Product</option>

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
                        <td class="text-light">Product</td>
                        <td class="input-group">
                            <div class="col-9">
                                <select class='form-select' name='product[]' value="<?php echo isset($product) ? htmlspecialchars($product) : ''; ?>">
                                    <option selected value="">Select a Product</option>

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
                        <td class="text-light">Product</td>
                        <td class="input-group">
                            <div class="col-9">
                                <select class='form-select' name='product[]' value="<?php echo isset($product) ? htmlspecialchars($product) : ''; ?>">
                                    <option selected value="">Select a Product</option>

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
                        <td class="text-light">Product</td>
                        <td class="input-group">
                            <div class="col-9">
                                <select class='form-select' name='product[]' value="<?php echo isset($product) ? htmlspecialchars($product) : ''; ?>">
                                    <option selected value="">Select a Product</option>

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
                        <td class="text-light">Product</td>
                        <td class="input-group">
                            <div class="col-9">
                                <select class='form-select' name='product[]' value="<?php echo isset($product) ? htmlspecialchars($product) : ''; ?>">
                                    <option selected value="">Select a Product</option>

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