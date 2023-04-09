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
    <?php include 'nav.php'; ?>

    <div class="container">
        <div class="page-header">
            <h1 class="mb-4 py-4 text-center">Create Customer</h1>
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
                if (isset($_POST['catStatus'])) $catStatus = $_POST['catStatus'];


                $success = true;


                if (empty($catName)) {
                    $catError = "*Please enter a category name.";
                    $success = false;
                } elseif (empty($catDes)) {
                    $catError = "*Please enter category description.";
                    $success = false;
                } elseif (empty($catStatus)) {
                    $catError = "*Please select category status.";
                    $success = false;
                }


                if ($success == true) {
                    // insert query
                    $query = "INSERT INTO category SET catName=:catName, catDes=:catDes, catStatus=:catStatus, catCreated=:catCreated";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
                    // bind the parameters
                    $stmt->bindParam(':catName', $catName);
                    $stmt->bindParam(':catDes', $catDes);
                    $stmt->bindParam(':catStatus', $catStatus);

                    // specify when this record was inserted to the database
                    $catCreated = date('Y-m-d');
                    $stmt->bindParam(':catCreated', $catCreated);

                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                        $catName = "";
                        $catDes = "";
                        $catStatus = "";
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
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='catName' class='form-control' value="<?php echo isset($catName) ? htmlspecialchars($catName) : ''; ?>" />
                        <?php if (isset($catError)) { ?>
                            <span class="text-danger">
                                <?php echo $catError; ?>
                            </span>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><input type='text' name='catDes' class='form-control' value="<?php echo isset($catDes) ? htmlspecialchars($catDes) : ''; ?>" />
                        <?php if (isset($catError)) { ?>
                            <span class="text-danger">
                                <?php echo $catError; ?>
                            </span>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Category Status</td>
                    <td>
                        <input type="radio" name="catStatus" value="available" /> Available
                        <input type="radio" name="catStatus" value="unavailable" /> Unavailable

                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='index.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>


    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>