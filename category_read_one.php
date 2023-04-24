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

    <!-- container -->
    <?php include 'nav.php'; ?>

    <div class="container">
        <section>
            <div class="page-header">
                <h1 class="mb-4 py-4 text-center text-light">Category's Detail</h1>
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
                echo "<h3 class='py-4 text-light'>{$catName}</h3>";


                // display the products in a table
                echo "<table class='table table-hover'>";
                echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>Name</th>";
                echo "<th>Description</th>";
                echo "<th class='text-end'>Price</th>";
                echo "</tr>";
                echo "<tbody class='table-group-divider'>";

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    echo "<tr>";
                    echo "<td>{$productId}</td>";
                    echo "<td>{$productName}</td>";
                    echo "<td>{$description}</td>";
                    echo "<td class='text-end'>" . number_format($price, 2, '.', '') . "</td>";
                    echo "<td>";

                    // we will use this links on next part of this post
                    echo "<a href='update.php?orderDetailsId={$orderDetailsId}' class='btn btn-outline-primary m-r-1em mx-1'>Edit</a>";

                    // we will use this links on next part of this post
                    echo "<a href='#' onclick='delete_user({$orderDetailsId});'  class='btn btn-outline-danger mx-1'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<div class='alert alert-danger'>Category not found.</div>";
            }
            ?>
        </section>

    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="assets/js/main.js"></script>
</body>


</html>