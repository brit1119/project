<?php include 'protect.php'; ?>

<!DOCTYPE HTML>
<html lang="en" data-bs-theme="dark">

<head>
    <title>Order's Details</title>
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
                <h1 class="mb-4 py-4 text-center text-light">Order Details</h1>
            </div>

            <!-- PHP read one record will be here -->
            <?php
            // get passed parameter value, in this case, the record ID
            // isset() is a PHP function used to verify if a value is there or not
            $orderId = isset($_GET['orderId']) ? $_GET['orderId'] : die('ERROR: Record ID not found.');

            // include database connection
            include 'config/database.php';



            // select the category name based on the category ID
            $query = "SELECT o.orderId, c.fName, c.lName, o.orderDate FROM orders o INNER JOIN customers c ON o.username = c.username WHERE o.orderId = $orderId;";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $orderId);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);

            // display the Title
            echo "<h5 class='py-4 text-light'>Order ID  <span class='fw-normal text-body pe-5 fs-3'>{$orderId}</span>  Customer <span class='fw-normal text-body pe-5 fs-3'>{$fName} {$lName}</span> Order Date <span class='fw-normal text-body pe-5 fs-3'>{$orderDate}</span></h3>";

            // check if the category ID exists
            if ($stmt->rowCount() > 0) {

                // select order details
                $query = "SELECT p.productName, p.price, ord.quantity, ord.quantity * p.price AS totalAmount FROM orders o INNER JOIN orderDetails ord ON o.orderId = ord.orderId INNER JOIN products p ON ord.productId = p.productId WHERE ord.orderId = $orderId ORDER BY ord.orderDetailsId DESC;";
                $stmt = $con->prepare($query);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {

                    // display the products in a table
                    echo "<table class='table table-hover'>";
                    echo "<tr>";
                    echo "<th>Product Name</th>";
                    echo "<th class='text-end'>Price</th>";
                    echo "<th class='text-center'>Quantity</th>";
                    echo "<th class='text-end'>Total Amount</th>";
                    echo "</tr>";
                    echo "<tbody class='table-group-divider'>";



                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<tr>";
                        echo "<td>{$productName}</td>";
                        echo "<td class='col-1' align='end'>" . number_format($price, 2, '.', '') . "</td>";
                        echo "<td align='center'>{$quantity}</td>";
                        echo "<td align='end'>" . number_format($totalAmount, 2, '.', '') . "</td>";

                        echo "</tr>";
                    }
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<div class='alert alert-danger'>Order details not found.</div>";
            }
            ?>

            <table class="table table-borderless">
                <tr>
                    <td class="align-item-start">
                        <a href='order_read.php' class='btn btn-dark border-primary'>Back to My Orders</a>
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