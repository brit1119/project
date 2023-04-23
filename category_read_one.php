<?php include 'protect.php'; ?>

<!DOCTYPE HTML>
<html lang="en" data-bs-theme="dark">

<head>
    <title>PDO - Read One Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">

<body>

    <!-- container -->
    <?php include 'nav.php'; ?>

    <div class="container">
        <div class="page-header">
            <h1 class="mb-4 py-4 text-center">Category's Detail</h1>
        </div>

        <!-- PHP read one record will be here -->
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $catId = isset($_GET['catId']) ? $_GET['catId'] : die('ERROR: Record ID not found.');

        // include database connection
        include 'config/database.php';

        // select the category name based on the category ID
        $query = "SELECT catName, productId, productName, description, price FROM category INNER JOIN products ON category.catId = products.catId WHERE products.catId = ?;";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $catId);
        $stmt->execute();

        // check if the category ID exists
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);

            // display the category name
            echo "<h3 class='py-4'>{$catName}</h3>";


            // display the products in a table
            echo "<table class='table table-hover table-responsive table-bordered'>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Name</th>";
            echo "<th>Description</th>";
            echo "<th>Price</th>";
            echo "</tr>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                echo "<tr>";
                echo "<td>{$productId}</td>";
                echo "<td>{$productName}</td>";
                echo "<td>{$description}</td>";
                echo "<td class='text-end'>" . number_format($price, 2, '.', '') . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<div class='alert alert-danger'>Category not found.</div>";
        }
        ?>


    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>


</html>