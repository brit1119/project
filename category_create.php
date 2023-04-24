<?php include 'protect.php'; ?>

<!DOCTYPE HTML>
<html lang="en" data-bs-theme="dark">

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <meta charset="utf-8">
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- container -->
    <?php include 'nav.php'; ?>

    <div class="container">
        <section>
            <div class="page-header">
                <h1 class="mb-4 py-4 text-center">Create Category</h1>
            </div>

            <!-- html form to create product will be here -->
            <!-- PHP insert code will be here -->
            <?php
            if ($_POST) {
                // include database connection
                include 'config/database.php';
                try {

                    // posted values
                    $catName = htmlspecialchars(strip_tags($_POST['catName']));
                    $catDes = htmlspecialchars(strip_tags($_POST['catDes']));


                    $success = true;


                    if (empty($catName)) {
                        $catError = "*Please enter a category name.";
                        $success = false;
                    } elseif (empty($catDes)) {
                        $catError = "*Please enter category description.";
                        $success = false;
                    }


                    if ($success == true) {
                        // insert query
                        $query = "INSERT INTO category SET catName=:catName, catDes=:catDes, catCreated=:catCreated";
                        // prepare query for execution
                        $stmt = $con->prepare($query);
                        // bind the parameters
                        $stmt->bindParam(':catName', $catName);
                        $stmt->bindParam(':catDes', $catDes);

                        // specify when this record was inserted to the database
                        $catCreated = date('Y-m-d');
                        $stmt->bindParam(':catCreated', $catCreated);

                        // Execute the query
                        if ($stmt->execute()) {
                            echo "<div class='alert alert-success'>Record was saved.</div>";
                            $catName = "";
                            $catDes = "";
                        } else {
                            echo "<div class='alert alert-danger'>Unable to save record.</div>";
                        }
                    }
                }
                // show error
                catch (PDOException $exception) {
                    die('ERROR: ' . $exception->getMessage());
                }
            }
            ?>


            <!-- html form here where the product information will be entered -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <table class='table table-hover table-borderless'>
                    <tr>
                        <td class="text-light col-2">Category Name</td>
                        <td><input type='text' name='catName' class='form-control' placeholder="Enter category name" value="<?php echo isset($catName) ? htmlspecialchars($catName) : ''; ?>" />
                            <?php if (isset($catError)) { ?>
                                <span class="text-danger">
                                    <?php echo $catError; ?>
                                </span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-light">Description</td>
                        <td><textarea name='catDes' class='form-control' placeholder="Enter description" value="<?php echo isset($catDes) ? htmlspecialchars($catDes) : ''; ?>"></textarea>
                            <?php if (isset($catError)) { ?>
                                <span class="text-danger">
                                    <?php echo $catError; ?>
                                </span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type='submit' value='Save' class='btn btn-primary' />
                            <a href='category_read.php' class='btn btn-dark border-secondary-subtle'>Back to My Category</a>
                        </td>
                    </tr>
                </table>
            </form>
        </section>

    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="assets/js/main.js"></script>

</body>

</html>