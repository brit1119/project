<!-- container -->

<div class="container">
    <div class="py-4">
        <ul class="nav nav-pills nav-fill fs-4 fw-light" method="post">
            <li class="nav-item active">
                <a class="nav-link link-secondary" href="index.php">Home</a>
            </li>
            <li class="nav-item dropdown">
                <div class="dropdown-center">
                    <button class="nav-link link-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Orders
                    </button>
                    <ul class="dropdown-menu dropdown-menu-light">
                        <li><a class="dropdown-item" href="order_read.php">My Orders</a></li>
                        <li><a class="dropdown-item" href="order_create.php">Create Order</a></li>
                    </ul>
                </div>
            <li class="nav-item dropdown">
                <div class="dropdown-center">
                    <button class="nav-link link-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Products
                    </button>
                    <ul class="dropdown-menu dropdown-menu-light">
                        <li><a class="dropdown-item" href="product_read.php">My Products</a></li>
                        <li><a class="dropdown-item" href="product_create.php">Create Product</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item dropdown">
                <div class="dropdown-center">
                    <button class="nav-link link-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Category
                    </button>
                    <ul class="dropdown-menu dropdown-menu-light">
                        <li><a class="dropdown-item" href="category_read.php">My Category</a></li>
                        <li><a class="dropdown-item" href="category_create.php">Create Category</a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item dropdown">
                <div class="dropdown-center">
                    <button class="nav-link link-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Customers
                    </button>
                    <ul class="dropdown-menu dropdown-menu-light">
                        <li><a class="dropdown-item" href="customer_read.php">My Customers</a></li>
                        <li><a class="dropdown-item" href="customer_create.php">Create Customer</a></li>
                    </ul>
                </div>
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
                                <a href="logout.php" type="button" class="btn btn-primary">Log out</a>

                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>