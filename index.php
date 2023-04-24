<?php include 'protect.php'; ?>

<!DOCTYPE HTML>
<html lang="en" data-bs-theme="dark">

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
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


    ?>



    <!-- container -->

    <div class="container">



        <section id="pricing" class="pricing section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-title text-light">
                    <h2>Dashboard</h2>
                </div>

                <div class="row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-light-emphasis">Latest Order </h5>
                                <p class="card-text">
                                <table class='table table-hover text-center mt-3 mb-5'>
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
                    <div class="row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-light-emphasis">Highest Purchased Product</h5>
                                    <p class="card-text">
                                    <table class='table table-hover text-center mt-3 mb-5'>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Category</th>
                                            <th>Sold Amount</th>
                                        </tr>
                                        <tr>
                                            <td><?php echo $fName . " ";
                                                echo $lName; ?></td>
                                            <td><?php echo $orderDate; ?></td>
                                        </tr>
                                    </table>
                                    </p>
                                    <a href="order_read.php" class="btn-buy">View Products</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                            <div class="box">
                                <h3>Free</h3>
                                <h4><sup>$</sup>0<span> / month</span></h4>
                                <ul>
                                    <li>Aida dere</li>
                                    <li>Nec feugiat nisl</li>
                                    <li>Nulla at volutpat dola</li>
                                    <li class="na">Pharetra massa</li>
                                    <li class="na">Massa ultricies mi</li>
                                </ul>
                                <div class="btn-wrap">
                                    <a href="#" class="btn-buy">Buy Now</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 mt-4 mt-md-0" data-aos="fade-up" data-aos-delay="200">
                            <div class="box featured">
                                <h3>Business</h3>
                                <h4><sup>$</sup>19<span> / month</span></h4>
                                <ul>
                                    <li>Aida dere</li>
                                    <li>Nec feugiat nisl</li>
                                    <li>Nulla at volutpat dola</li>
                                    <li>Pharetra massa</li>
                                    <li class="na">Massa ultricies mi</li>
                                </ul>
                                <div class="btn-wrap">
                                    <a href="#" class="btn-buy">Buy Now</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="300">
                            <div class="box">
                                <h3>Developer</h3>
                                <h4><sup>$</sup>29<span> / month</span></h4>
                                <ul>
                                    <li>Aida dere</li>
                                    <li>Nec feugiat nisl</li>
                                    <li>Nulla at volutpat dola</li>
                                    <li>Pharetra massa</li>
                                    <li>Massa ultricies mi</li>
                                </ul>
                                <div class="btn-wrap">
                                    <a href="#" class="btn-buy">Buy Now</a>
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