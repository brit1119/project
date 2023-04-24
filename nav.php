<header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center justify-content-between">
        <h1 class="logo"><a href="index.php">BRIT</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->


        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link 
                <?php if (basename($_SERVER['PHP_SELF']) == 'index.php') {
                    echo "active";
                } ?>" href="index.php">Home</a></li>

                <li class="dropdown"><a class="nav-link 
                <?php if (basename($_SERVER['PHP_SELF']) == 'order_read.php' || basename($_SERVER['PHP_SELF']) == 'order_create.php') {
                    echo "active";
                } ?>" href="order_read.php"><span>Order</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a href="order_read.php">My Orders</a></li>
                        <li><a href="order_create.php">Create Order</a></li>
                    </ul>
                </li>

                <li class="dropdown"><a class="nav-link 
                <?php if (basename($_SERVER['PHP_SELF']) == 'product_read.php' || basename($_SERVER['PHP_SELF']) == 'product_create.php') {
                    echo "active";
                } ?>" href="product_read.php"><span>Product</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a href="product_read.php">My Products</a></li>
                        <li><a href="product_create.php">Create Product</a></li>
                    </ul>
                </li>

                <li class="dropdown"><a class="nav-link 
                <?php if (basename($_SERVER['PHP_SELF']) == 'category_read.php' || basename($_SERVER['PHP_SELF']) == 'category_create.php') {
                    echo "active";
                } ?>" href="category_read.php"><span>Category</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a href="category_read.php">My Category</a></li>
                        <li><a href="category_create.php">Create Category</a></li>
                    </ul>
                </li>

                <li class="dropdown"><a class="nav-link 
                <?php if (basename($_SERVER['PHP_SELF']) == 'customer_read.php' || basename($_SERVER['PHP_SELF']) == 'customer_create.php') {
                    echo "active";
                } ?>" href="customer_read.php"><span>Customer</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a href="customer_read.php">My Customers</a></li>
                        <li><a href="customer_create.php">Create Customer</a></li>
                    </ul>
                </li>

                <li><a class="getstarted scrollto" href="login.php">Log Out</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->

</div>
</div>