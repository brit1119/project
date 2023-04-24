<?php include 'protect.php'; ?>

<!DOCTYPE HTML>
<html lang="en" data-bs-theme="dark">

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

</head>

<body>

    <?php include 'nav.php'; ?>

    <!-- container -->

    <div class="container">
        <div class="page-header">
            <h1 class="mb-4 py-4 text-center">My Orders</h1>
        </div>

        <!-- PHP code to read records will be here -->
        <?php
        // include database connection
        include 'config/database.php';

        $query = "SELECT * FROM orders";

        if ($_POST) {
            $search = htmlspecialchars(strip_tags($_POST['search']));
            $query = "SELECT * FROM products WHERE name LIKE '%$search%';";
        }



        // select all data

        $stmt = $con->prepare($query);
        $stmt->execute();

        // this is how to get number of rows returned
        $num = $stmt->rowCount();


        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="row justify-content-between g-2 pt-3">
            <div class='col-8'><a href='order_create.php' class='btn btn-primary m-b-1em'>Create New Order</a></div>

            <div class="col">
                <label for="search" class="visually-hidden">Search</label>
                <input type="text" class="form-control" name="search" id="search" placeholder="Search">
            </div>
            <div class="col-1">
                <button type="submit" class="col-12 btn btn-primary mb-3">Search</button>
            </div>

        </form>

        <?php

        //check if more than 0 record found
        if ($num > 0) {

            // data from database will be here
            echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

            //creating our table heading
            echo "<tr>";
            echo "<th>Order ID</th>";
            echo "<th>Username</th>";
            echo "<th>Order Date</th>";
            echo "<th>Action</th>";
            echo "</tr>";

            // table body will be here
            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td class='col-1'>{$orderId}</td>";
                echo "<td class='col-1'>{$username}</td>";
                echo "<td class='col'>{$orderDate}</td>";
                echo "<td class='col-3'>";
                // read one record
                echo "<a href='order_read_one.php?orderId={$orderId}' class='btn btn-info m-r-1em mx-1'>Read</a>";

                // we will use this links on next part of this post
                echo "<a href='update.php?orderId={$orderId}' class='btn btn-primary m-r-1em mx-1'>Edit</a>";

                // we will use this links on next part of this post
                echo "<a href='#' onclick='delete_user({$orderId});'  class='btn btn-danger mx-1'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }



            // end table
            echo "</table>";
        }
        // if no records found
        else {
            echo "<div class='alert alert-danger'>No records found.</div>";
        }
        ?>



    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
</body>

<!-- confirm delete record will be here -->

</body>

</html>