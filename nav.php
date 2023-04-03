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
            <ul class="nav nav-pills nav-fill fs-4 fw-light">
                <li class="nav-item">
                    <a class="nav-link link-secondary" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-secondary" href="product_read.php">My Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-secondary" href="customer_read.php">My Customers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-secondary" href="contact.php">Contact Us</a>
                </li>
                <li class="nav-item">
                    <!-- Button trigger modal -->
                    <a class="nav-link link-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Log Out
                    </a>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">LOG OUT</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to log out?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <a href="login.php" type="button" class="btn btn-primary">Log out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>



    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>