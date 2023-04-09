<!-- container -->
<div class="container">
    <div class="py-4">
        <ul class="nav nav-pills nav-fill fs-4 fw-light">
            <li class="nav-item active">
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