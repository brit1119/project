<?php include 'protect.php'; ?>

<!DOCTYPE HTML>
<html lang="en" data-bs-theme="dark">

<head>
    <title>Index</title>
    <meta charset="utf-8">
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <link href="assets/css/style.css" rel="stylesheet">


</head>

<body>

    <?php

    include 'nav.php';
    include 'config/database.php';


    //latest order
    $query = "SELECT c.fName, c.lName, o.orderDate, ord.quantity * p.price AS totalAmount
FROM orders o
INNER JOIN customers c ON o.username = c.username
INNER JOIN orderDetails ord ON o.orderId = ord.orderId
INNER JOIN products p ON ord.productId = p.productId
ORDER BY o.orderDate DESC LIMIT 0,1";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $fName = $row['fName'];
    $lName = $row['lName'];
    $orderDate = $row['orderDate'];
    $totalAmount = $row['totalAmount'];



    //latest added customer
    $query = "SELECT fName, lName, username, regDateNTime
FROM customers
ORDER BY regDateNTime DESC; LIMIT 0,1";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $fName = $row['fName'];
    $lName = $row['lName'];
    $username = $row['username'];
    $regDateNTime = $row['regDateNTime'];




    //best selling product
    $query = "SELECT p.productName, c.catName, SUM(ord.quantity) AS totalSold
FROM orders o
INNER JOIN orderDetails ord ON o.orderID = ord.orderId
INNER JOIN products p ON ord.productId = p.productId
INNER JOIN category c ON p.catId = c.catId
GROUP BY p.productId  
ORDER BY `totalSold` DESC LIMIT 0,1";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $productName = $row['productName'];
    $catName = $row['catName'];
    $totalSold = $row['totalSold'];



    //worst selling product
    $query = "SELECT p.productName, c.catName, SUM(ord.quantity) AS totalSold
FROM orders o
INNER JOIN orderDetails ord ON o.orderID = ord.orderId
INNER JOIN products p ON ord.productId = p.productId
INNER JOIN category c ON p.catId = c.catId
GROUP BY p.productId  
ORDER BY `totalSold` ASC LIMIT 0,1";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $productName1 = $row['productName'];
    $catName1 = $row['catName'];
    $totalSold1 = $row['totalSold'];


    ?>



    <!-- container -->

    <div class="container">



        <section id="pricing" class="pricing section-bg">
            <div class="container" data-aos="fade-up">

                <div class="page-header">
                    <h1 class="mb-4 py-4 text-center text-light">Dashboard</h1>
                </div>

                <div class="row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-light-emphasis">Latest Order </h5>
                                <p class="card-text">
                                <table class='table table-hover text-center mt-4 mb-5'>
                                    <tr>
                                        <th>Customer Name</th>
                                        <th>Order Date</th>
                                        <th>Total</th>
                                    </tr>
                                    <tr>
                                        <td><?php echo $fName . " ";
                                            echo $lName; ?></td>
                                        <td><?php echo $orderDate; ?></td>
                                        <td><?php echo number_format((float)htmlspecialchars($totalAmount, ENT_QUOTES), 2, '.', ''); ?></td>
                                    </tr>
                                </table>
                                </p>
                                <a href="order_read.php" class="btn-buy">View Orders</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-light-emphasis">Lastest Added Customer</h5>
                                <p class="card-text">
                                <table class='table table-hover text-center mt-4 mb-5'>
                                    <tr>
                                        <th>Customer Name</th>
                                        <th>Username</th>
                                        <th>Registration Date & Time</th>
                                    </tr>
                                    <tr>
                                        <td><?php echo $fName . " ";
                                            echo $lName; ?></td>
                                        <td><?php echo $username; ?></td>
                                        <td><?php echo $regDateNTime; ?></td>
                                    </tr>
                                </table>
                                </p>
                                <a href="customer_read.php" class="btn-buy">View Customers</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">

                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-light-emphasis">Best Selling Product</h5>
                                <p class="card-text">
                                <table class='table table-hover text-center mt-4 mb-5'>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Sold Amount</th>
                                    </tr>
                                    <tr>
                                        <td><?php echo $productName; ?></td>
                                        <td><?php echo $catName; ?></td>
                                        <td><?php echo $totalSold; ?></td>
                                    </tr>
                                </table>
                                </p>
                                <a href="product_read.php" class="btn-buy">View Products</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-light-emphasis">Worst Selling Product </h5>
                                <p class="card-text">
                                <table class='table table-hover text-center mt-4 mb-5'>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Sold Amount</th>
                                    </tr>
                                    <tr>
                                        <td><?php echo $productName1; ?></td>
                                        <td><?php echo $catName1; ?></td>
                                        <td><?php echo $totalSold1; ?></td>
                                    </tr>
                                </table>
                                </p>
                                <a href="product_read.php" class="btn-buy">View Products</a>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </section><!-- End Pricing Section -->

    </div>



    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

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