<?php include 'protect.php'; ?>

<!DOCTYPE HTML>
<html lang="en" data-bs-theme="dark">

<head>
    <title>Category</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body">

    <?php include 'nav.php'; ?>

    <!-- container -->

    <div class="container">
        <section class="pricing section-bg">
            <div class="page-header">
                <h1 class="mb-4 py-4 text-center">My Category</h1>
            </div>

            <!-- PHP code to read records will be here -->
            <?php
            // include database connection
            include 'config/database.php';

            // delete message prompt will be here
            $action = isset($_GET['action']) ? $_GET['action'] : "";

            // if it was redirected from delete.php
            if ($action == 'deleted') {
                echo "<div class='alert alert-success'>Record was deleted.</div>";
            }

            if ($action == 'failed') {
                echo "<div class='alert alert-danger'>Record was failed to delete.</div>";
            }

            // select all data
            $query = "SELECT c.catId, catName, catDes, catCreated, COUNT(productName) AS totalP FROM category c INNER JOIN products p ON c.catId = p.catId GROUP BY c.catId ORDER BY c.catId ASC";

            if ($_POST) {
                $search = htmlspecialchars(strip_tags($_POST['search']));
                $query = "SELECT c.catId, catName, catDes, catCreated, COUNT(productName) AS totalP FROM category c INNER JOIN products p ON c.catId = p.catId GROUP BY c.catId ORDER BY c.catId ASC WHERE catName LIKE '%$search%';";
            }
            $stmt = $con->prepare($query);
            $stmt->execute();

            // this is how to get number of rows returned
            $num = $stmt->rowCount();

            ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="row justify-content-between g-2 pt-3">
                <div class='col-8'><a href='category_create.php' class='btn-buy m-b-1em fs-5 fw-medium'>Create New Category</a></div>

                <div class="col">
                    <input type="text" class="form-control" name="search" id="search" placeholder="Search">
                </div>
                <div class="col-1">
                    <button type="submit" class="col-12 btn btn-outline-primary mb-3">Search</button>
                </div>

            </form>

            <?php


            //total number
            echo "<h5 class='py-2 mt-5 text-light'>Total: {$num}</h5>";

            //check if more than 0 record found
            if ($num > 0) {

                // data from database will be here
                echo "<table class='table table-hover'>"; //start table

                //creating our table heading
                echo "<tr>";
                echo "<th>Category ID</th>";
                echo "<th>Name</th>";
                echo "<th>Description</th>";
                echo "<th>Date Created</th>";
                echo "<th class='text-center'>Total Product Amount</th>";
                echo "<th>Action</th>";
                echo "</tr>";
                echo "<tbody class='table-group-divider'>";

                // table body will be here
                // retrieve our table contents
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // extract row
                    // this will make $row['firstname'] to just $firstname only
                    extract($row);
                    // creating new table row per record

                    echo "<tr>";
                    echo "<td class='text-end'>{$catId}</td>";
                    echo "<td>{$catName}</td>";
                    echo "<td class='col-5'>{$catDes}</td>";
                    echo "<td>{$catCreated}</td>";
                    echo "<td class='text-center'>{$totalP}</td>";
                    echo "<td class='col-2'>";

                    // read one record
                    echo "<a href='category_read_one.php?catId={$catId}' class='btn btn-dark border-secondary-subtle m-r-1em mx-1'>More</a>";

                    // we will use this links on next part of this post
                    echo "<a onclick='delete_user({$catId});'  class='btn btn-outline-danger mx-1'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";



                // end table
                echo "</table>";
            }
            // if no records found
            else {
                echo "<div class='alert alert-danger'>No records found.</div>";
            }
            ?>
        </section>


    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="assets/js/main.js"></script>

    <!-- confirm delete record will be here -->
    <script type='text/javascript'>
        // confirm record deletion
        function delete_user(catId) {

            var answer = confirm('Are you sure? Delete(' + catId + ')');

            if (answer) {
                // if user clicked ok,
                // pass the id to delete.php and execute the delete query
                window.location = 'category_delete.php?catId=' + catId;
            }
        }
    </script>


    </body>

</html>