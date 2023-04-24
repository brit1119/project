<header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center justify-content-between">
        <h1 class="logo"><a href="index.php">BRIT</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto active" href="index.php">Home</a></li>
                <li class="dropdown"><a href="order_read.php"><span>Order</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a href="order_read.php">My Orders</a></li>
                        <li><a href="order_create.php">Create Order</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a href="product_read.php"><span>Product</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a href="product_read.php">My Products</a></li>
                        <li><a href="product_create.php">Create Product</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a href="product_read.php"><span>Category</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a href="category_read.php">My Category</a></li>
                        <li><a href="category_create.php">Create Category</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a href="product_read.php"><span>Customer</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a href="customer_read.php">My Customers</a></li>
                        <li><a href="customer_create.php">Create Customer</a></li>
                    </ul>
                </li>
                <!-- Button trigger modal -->
                <a class="getstarted nav-link link-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">
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
                                <a href="logout.php" type="button" class="btn btn-primary">Log out</a>

                            </div>
                        </div>
                    </div>
                </div>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->

<!-- container -->



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
                    <a href="logout.php" type="button" class="btn btn-primary">Log out</a>

                </div>
            </div>
        </div>
    </div>
</li>
</ul>
</div>
</div>