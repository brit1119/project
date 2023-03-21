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
        <div class="py-4">
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="product_create.php">Create Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="customer_create.php">Create Customer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact Us</a>
                </li>
            </ul>
        </div>

        <div class="page-header">
            <h1>Create Product</h1>
        </div>

        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->
        <?php
        if ($_POST) {
            // include database connection
            include 'config/database.php';
            try {

                $success = true;

                // posted values
                $name = htmlspecialchars(strip_tags($_POST['name']));
                $description = htmlspecialchars(strip_tags($_POST['description']));
                $price = htmlspecialchars(strip_tags($_POST['price']));

                //add ex
                $promoPrice = htmlspecialchars(strip_tags($_POST['promoPrice']));
                $manufactureDate = htmlspecialchars(strip_tags($_POST['manufactureDate']));
                $expiredDate = htmlspecialchars(strip_tags($_POST['expiredDate']));





                if (empty($name) || empty($description) || empty($price) || empty($manufactureDate)) {
                    echo "<div class='alert alert-danger'>Please fill in all the field other than Promo Price and Expired Date.</div>";
                    $success = false;
                }

                if (!empty($promoPrice)) {
                    if ($promoPrice > $price) {
                        echo "<div class='alert alert-danger'>Promo price must be lesser than price.</div>";
                        $success = false;
                    }
                }

                if (!empty($expiredDate)) {
                    if ($manufactureDate >= $expiredDate) {
                        echo "<div class='alert alert-danger'>Manufacturing Date must be ealier than Expired Date</div>";
                        $success = false;
                    }
                }


                if ($success == true) {
                    // insert query + add ex

                    $query = "INSERT INTO products SET name=:name, description=:description, price=:price, created=:created, promoPrice=:promoPrice, manufactureDate=:manufactureDate, expiredDate=:expiredDate";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
                    // bind the parameters
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':price', $price);

                    //add ex
                    $stmt->bindParam(':promoPrice', $promoPrice);
                    $stmt->bindParam(':manufactureDate', $manufactureDate);
                    $stmt->bindParam(':expiredDate', $expiredDate);

                    // specify when this record was inserted to the database
                    $created = date('Y-m-d H:i:s');
                    $stmt->bindParam(':created', $created);

                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
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
                    <td>Name</td>
                    <td><input type='text' name='name' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name='description' class='form-control'></textarea></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='number' name='price' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Promo Price</td>
                    <td><input type='number' name='promoPrice' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Manufacture Date</td>
                    <td><input type='date' name='manufactureDate' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Expired Date</td>
                    <td><input type='date' name='expiredDate' class='form-control' /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='index.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>


    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>