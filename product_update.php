<?php include 'protect.php'; ?>

<!DOCTYPE HTML>
<html lang="en" data-bs-theme="dark">

<head>
    <title>PDO - Read Records - PHP CRUD Tutorial</title>
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
                <h1 class="mb-4 py-4 text-center">My Products</h1>
            </div>

            <!-- PHP read record by ID will be here -->
            <?php
            // get passed parameter value, in this case, the record ID
            // isset() is a PHP function used to verify if a value is there or not
            $productId = isset($_GET['productId']) ? $_GET['productId'] : die('ERROR: Record ID not found.');

            //include database connection
            include 'config/database.php';

            // read current record's data
            try {
                // prepare select query
                $query = "SELECT productId, productName, description, catName, price ,promoPrice, manufactureDate, expiredDate FROM products p INNER JOIN category c ON p.catId = c.catId WHERE productId =  ? ";
                $stmt = $con->prepare($query);

                // this is the first question mark
                $stmt->bindParam(1, $productId);

                // execute our query
                $stmt->execute();

                // store retrieved row to a variable
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // values to fill up our form
                $productId = $row['productId'];
                $productName = $row['productName'];
                $description = $row['description'];
                $catName = $row['catName'];
                $price = $row['price'];
                $promoPrice = $row['promoPrice'];
                $manufactureDate = $row['manufactureDate'];
                $expiredDate = $row['expiredDate'];
            }

            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
            ?>

            <!-- HTML form to update record will be here -->
            <!-- PHP post to update record will be here -->
            <?php

            $success = true;
            // check if form was submitted
            if ($_POST) {
                try {
                    // posted values
                    if (empty($_POST["productName"])) {
                        $nameErr = "Name is required *";
                        $success = false;
                    }

                    if (empty($_POST["catName"])) {
                        $catError = "*Please select a category.";
                        $success = false;
                    }

                    if (empty($_POST["description"])) {
                        $desError = "*Please enter product description.";
                        $success = false;
                    }

                    if (empty($_POST["price"])) {
                        $priceError = "*Please enter product price.";
                        $success = false;
                    }

                    if (!empty($_POST["promoPrice"])) {
                        if ($_POST["promoPrice"] > $_POST["price"]) {
                            $promoError = "*Promo price must be lesser than original price.";
                            $success = false;
                        }
                    }

                    if (empty($_POST["manufactureDate"])) {
                        $manuError = "*Please select product manufacture date.";
                        $success = false;
                    }



                    if (!empty($_POST["expiredDate"])) {
                        if ($_POST["manufactureDate"] >= $_POST["expiredDate"]) {
                            $expiredError = "*Expired date must be later than manufacture date.";
                            $success = false;
                        }
                    }

                    if ($success) {
                        // write update query
                        // in this case, it seemed like we have so many fields to pass and
                        // it is better to label them and not use question marks
                        $query = "UPDATE products SET productName=:productName, catId=:catId, description=:description, price=:price, promoPrice=:promoPrice, manufactureDate=:manufactureDate, expiredDate=:expiredDate WHERE productId=:productId ";

                        // prepare query for excecution
                        $stmt = $con->prepare($query);
                        // posted values
                        $productName = htmlspecialchars(strip_tags($_POST['productName']));
                        $catName = htmlspecialchars(strip_tags($_POST['catName']));
                        $description = htmlspecialchars(strip_tags($_POST['description']));
                        $price = htmlspecialchars(strip_tags($_POST['price']));
                        $promoPrice = htmlspecialchars(strip_tags($_POST['promoPrice']));
                        $manufactureDate = htmlspecialchars(strip_tags($_POST['manufactureDate']));
                        $expiredDate = htmlspecialchars(strip_tags($_POST['expiredDate']));
                        // bind the parameters
                        $stmt->bindParam(':productName', $productName);
                        $stmt->bindParam(':catId', $catName);
                        $stmt->bindParam(':description', $description);
                        $stmt->bindParam(':price', $price);
                        $stmt->bindParam(':promoPrice', $promoPrice);
                        $stmt->bindParam(':manufactureDate', $manufactureDate);
                        $stmt->bindParam(':expiredDate', $expiredDate);
                        $stmt->bindParam(':productId', $productId);


                        // Execute the query
                        if ($stmt->execute()) {
                            echo "<div class='alert alert-success'>Record was updated.</div>";
                        } else {
                            echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Unable to update record. Please fill in correct information.</div>";
                    }
                }
                // show errors
                catch (PDOException $exception) {
                    die('ERROR: ' . $exception->getMessage());
                }
            } ?>


            <!--we have our html form here where new record information can be updated-->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?productId={$productId}"); ?>" method="post">
                <table class='table table-hover table-borderless'>
                    <tr>
                        <td>Product ID</td>
                        <td><?php echo htmlspecialchars($productId, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td class='col-2'>Product Name</td>
                        <td><input type='text' name='productName' value="<?php echo htmlspecialchars($productName, ENT_QUOTES);  ?>" class='form-control' />
                            <?php if (isset($nameError)) { ?>
                                <span class="text-danger"> <?php echo $nameError; ?> </span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td class='col-2'>Category</td>
                        <td>
                            <select class='form-select' name='catName' value="<?php isset($cat) ? $cat : ' ';
                                                                                isset($catName) ? $catName : ' '; ?>">
                                <option selected>

                                    <?php
                                    if ($_POST['catName']) {
                                        $query = "SELECT catName FROM category WHERE catId = $catName";
                                        $stmt = $con->prepare($query);
                                        $stmt->bindParam(1, $catId);
                                        $stmt->execute();
                                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $cat = $row['catName'];
                                        echo $cat;
                                    } else {
                                        echo $catName;
                                    }

                                    ?>
                                </option>

                                <?php

                                $query = "SELECT catId, catName FROM category";
                                $stmt = $con->prepare($query);
                                $stmt->execute();
                                $num = $stmt->rowCount();
                                if ($num > 0) {
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);

                                ?>
                                        <option value=" <?php echo $catId; ?>"><?php echo $catName; ?> </option>
                                <?php
                                    }
                                }
                                ?>

                            </select>
                            <?php if (isset($catError)) { ?>
                                <span class="text-danger"> <?php echo $catError; ?> </span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td><textarea name='description' class='form-control'><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></textarea>
                            <?php if (isset($desError)) { ?>
                                <span class="text-danger"> <?php echo $desError; ?> </span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td><input type='text' name='price' value="<?php echo htmlspecialchars($price, ENT_QUOTES);  ?>" class='form-control' />
                            <?php if (isset($priceError)) { ?>
                                <span class="text-danger"> <?php echo $priceError; ?> </span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Promotion Price</td>
                        <td><input type='text' name='promoPrice' value="<?php echo htmlspecialchars($promoPrice, ENT_QUOTES);  ?>" class='form-control' />
                            <?php if (isset($promoError)) { ?>
                                <span class="text-danger"> <?php echo $promoError; ?> </span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Manufacture Date</td>
                        <td><input type='date' name='manufactureDate' value="<?php echo htmlspecialchars($manufactureDate, ENT_QUOTES);  ?>" class='form-control' />
                            <?php if (isset($manuError)) { ?>
                                <span class="text-danger"> <?php echo $manuError; ?> </span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Expired date</td>
                        <td><input type='date' name='expiredDate' value="<?php echo htmlspecialchars($expiredDate, ENT_QUOTES);  ?>" class='form-control' />
                            <?php if (isset($expiredError)) { ?>
                                <span class="text-danger"> <?php echo $expiredError; ?> </span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type='submit' value='Save Changes' class='btn btn-primary' />
                            <a href='product_read.php' class='btn btn-dark border-secondary-subtle'>Back to My Products</a>
                        </td>
                    </tr>
                </table>
            </form>
        </section>
    </div>
    <!-- end .container -->
</body>

</html>