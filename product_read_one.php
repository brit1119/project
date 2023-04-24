<?php include 'protect.php'; ?>

<!DOCTYPE HTML>
<html lang="en" data-bs-theme="dark">

<head>
    <title>PDO - Read One Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">

    <link href="assets/css/style.css" rel="stylesheet">

<body>
    <?php include 'nav.php'; ?>

    <!-- container -->

    <div class="container">
        <section>
            <div class="page-header">
                <h1 class="mb-4 py-4 text-center text-light">Product Details</h1>
            </div>

            <!-- PHP read one record will be here -->
            <?php
            // get passed parameter value, in this case, the record ID
            // isset() is a PHP function used to verify if a value is there or not
            $productId = isset($_GET['productId']) ? $_GET['productId'] : die('ERROR: Record ID not found.');

            //include database connection
            include 'config/database.php';

            // read current record's data
            try {
                // prepare select query
                $query = "SELECT productId, productName, description, price FROM products WHERE productId = ? LIMIT 0,1";
                $stmt = $con->prepare($query);

                // this is the first question mark
                $stmt->bindParam(1, $productId);

                // execute our query
                $stmt->execute();

                // store retrieved row to a variable
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // values to fill up our form
                //or extract all at once (extract($row))
                $productId = $row['productId'];
                $productName = $row['productName'];
                $description = $row['description'];
                $price = $row['price'];
            }

            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
            ?>


            <!-- HTML read one record table will be here -->
            <!--we have our html table here where the record will be displayed-->
            <table class='table table-hover table-dark table-striped-columns'>
                <tr>
                    <td class="col-3"><b>Product ID</b></td>
                    <td><?php echo htmlspecialchars($productId, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td><b>Product Name</b></td>
                    <td><?php echo htmlspecialchars($productName, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td><b>Description</b></td>
                    <td><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td><b>Price</b></td>
                    <td><?php echo htmlspecialchars($price, ENT_QUOTES);  ?></td>
                </tr>
            </table>
            <table class="table table-borderless">
                <tr>
                    <td class="col-3"></td>
                    <td>
                        <a href='update.php?productId={$productId}' class='btn btn-primary m-r-1em'>Edit</a>
                        <a href='#' onclick='delete_user({$productId});' class='btn btn-danger'>Delete</a>
                        <a href='product_read.php' class='btn btn-dark border-secondary-subtle'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </section>


    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="assets/js/main.js"></script>
</body>


</html>