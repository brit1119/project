<?php include 'protect.php'; ?>

<!DOCTYPE HTML>
<html lang="en" data-bs-theme="dark">

<head>
    <title>Create products</title>
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
                <h1 class="mb-4 py-4 text-center">Create Product</h1>
            </div>

            <!-- html form to create product will be here -->
            <!-- PHP insert code will be here -->
            <?php
            include 'config/database.php';

            if ($_POST) {
                try {

                    $success = true;

                    // posted values
                    $productName = htmlspecialchars(strip_tags($_POST['productName']));
                    $description = htmlspecialchars(strip_tags($_POST['description']));
                    $price = htmlspecialchars(strip_tags($_POST['price']));

                    //add ex
                    $promoPrice = htmlspecialchars(strip_tags($_POST['promoPrice']));
                    $manufactureDate = htmlspecialchars(strip_tags($_POST['manufactureDate']));
                    $expiredDate = htmlspecialchars(strip_tags($_POST['expiredDate']));
                    if (isset($_POST['catName'])) $catName = $_POST['catName'];


                    if (empty($productName)) {
                        $nameError = "*Please enter a product name.";
                        $success = false;
                    }

                    if (empty($catName)) {
                        $catError = "*Please select a category.";
                        $success = false;
                    }

                    if (empty($description)) {
                        $desError = "*Please enter product description.";
                        $success = false;
                    }

                    if (empty($price)) {
                        $priceError = "*Please enter product price.";
                        $success = false;
                    }

                    if (empty($manufactureDate)) {
                        $manuError = "*Please select product manufacture date.";
                        $success = false;
                    }



                    if (!empty($promoPrice)) {
                        if ($promoPrice > $price) {
                            $promoError = "*Promo price must be lesser than original price.";
                            $success = false;
                        }
                    }

                    if (!empty($expiredDate)) {
                        if ($manufactureDate >= $expiredDate) {
                            $expiredError = "*Expired date must be later than manufacture date.";
                            $success = false;
                        }
                    }


                    if ($success == true) {
                        // insert query 

                        $query = "INSERT INTO products SET productName=:productName, catName=:catName ,description=:description, price=:price, created=:created, manufactureDate=:manufactureDate";
                        // prepare query for execution
                        $stmt = $con->prepare($query);
                        // bind the parameters
                        $stmt->bindParam(':productName', $productName);
                        $stmt->bindParam(':catName', $catName);
                        $stmt->bindParam(':description', $description);
                        $stmt->bindParam(':price', $price);
                        $stmt->bindParam(':manufactureDate', $manufactureDate);


                        // specify when this record was inserted to the database
                        $created = date('Y-m-d H:i:s');
                        $stmt->bindParam(':created', $created);

                        // Execute the query
                        if ($stmt->execute()) {
                            echo "<div class='alert alert-success'>Record was saved.</div>";
                            $productName = "";
                            $catName = "";
                            $description = "";
                            $price = "";
                            $promoPrice = "";
                            $manufactureDate = "";
                            $expiredDate = "";
                        } else {
                            echo "<div class='alert alert-danger'>Unable to save record. Please fill in all fields.</div>";
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
                <table class='table table-hover table-borderless'>
                    <tr>
                        <td class="text-light col-2">Name</td>
                        <td>
                            <input type='text' name='productName' class='form-control' placeholder="Enter a product name" value="<?php echo isset($productName) ? htmlspecialchars($productName) : ''; ?>" />
                            <?php if (isset($nameError)) { ?>
                                <span class="text-danger"> <?php echo $nameError; ?> </span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-light">Category</td>
                        <td>
                            <select class='form-select' name='catName' value="<?php echo isset($catName) ? htmlspecialchars($catName) : ''; ?>">
                                <option selected>Select a Category</option>

                                <?php

                                $query = "SELECT catId, catName FROM category";
                                $stmt = $con->prepare($query);
                                $stmt->execute();
                                $num = $stmt->rowCount();
                                if ($num > 0) {
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);

                                ?>
                                        <option value="<?php echo $catId; ?>"><?php echo $catName; ?> </option>
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
                        <td class="text-light">Description</td>
                        <td><textarea name='description' class='form-control' placeholder="Enter description" value="<?php echo isset($description) ? htmlspecialchars($description) : ''; ?>"></textarea>
                            <?php if (isset($desError)) { ?>
                                <span class="text-danger">
                                    <?php echo $desError; ?>
                                </span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-light">Price</td>
                        <td><input type='number' name='price' class='form-control' placeholder="Enter a price" value="<?php echo isset($price) ? htmlspecialchars($price) : ''; ?>" />
                            <?php if (isset($priceError)) { ?>
                                <span class="text-danger">
                                    <?php echo $priceError; ?>
                                </span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-light">Promo Price</td>
                        <td><input type='number' name='promoPrice' class='form-control' placeholder="Enter promotion price" value="<?php echo isset($promoPrice) ? htmlspecialchars($promoPrice) : ''; ?>" />
                            <?php if (isset($promoError)) { ?>
                                <span class="text-danger">
                                    <?php echo $promoError; ?>
                                </span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-light">Manufacture Date</td>
                        <td><input type='date' name='manufactureDate' class='form-control' value="<?php echo isset($manufactureDate) ? htmlspecialchars($manufactureDate) : ''; ?>" />
                            <?php if (isset($manuError)) { ?>
                                <span class="text-danger">
                                    <?php echo $manuError; ?>
                                </span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-light">Expired Date</td>
                        <td><input type='date' name='expiredDate' class='form-control' value="<?php echo isset($expiredDate) ? htmlspecialchars($expiredDate) : ''; ?>" />
                            <?php if (isset($expiredError)) { ?>
                                <span class="text-danger">
                                    <?php echo $expiredError; ?>
                                </span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type='submit' value='Create Product' class='btn btn-primary' />
                            <a href='index.php' class='btn btn-dark border-secondary-subtle'>Back to My Products</a>
                        </td>
                    </tr>
                </table>
            </form>
        </section>

    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>