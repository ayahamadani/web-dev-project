<!-- index.php -->

<?php
include('connection/test_conn.php');

// Write query to get all products
$sql = 'SELECT sku, name, type, length, width, height, price, size, weight FROM products';

// Make the query and get the result
$result = mysqli_query($conn, $sql);

// Fetch the results as an array
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Free the result from memory
mysqli_free_result($result);

// Close the database connection
mysqli_close($conn);

// remove-products.php

include('connection/test_conn.php');

// Assuming you have a database connection established

// Check if form is submitted and delete button is clicked
if (isset($_POST['delete'])) {
    // Get the selected SKUs from the form submission
    if($_POST['product_keys'])
    $selectedSKUs = $_POST['product_keys'];

    // Prepare a SQL query to delete products with matching SKUs
    $sql = "DELETE FROM products WHERE sku = ?";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);

    // Bind the SKU parameter
    mysqli_stmt_bind_param($stmt, 's', $sku);

    // Iterate over selected SKUs and execute the prepared statement
    foreach ($selectedSKUs as $sku) {
        // Execute the statement for each SKU
        if (mysqli_stmt_execute($stmt)) {
            header('Location: index.php');   
        } else
        echo "Error deleting record: " . mysqli_stmt_error($stmt) . "<br>";
    }
    // Close the statement
    mysqli_stmt_close($stmt);
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <?php include('header.php'); ?>
    <div class="container">
        <div>
            <form method="POST" action="index.php">
            <?php if (!empty($products)) : ?>
                <?php foreach ($products as $product) : ?>
                    <div class="card">
                        <input type="checkbox" name="product_keys[]" class="remove-checkbox" value="<?php echo htmlspecialchars($product['sku']) ?>"/>
                        <h3 id="sku"><?php echo htmlspecialchars($product['sku']) ?></h3>
                        <h3><?php echo htmlspecialchars($product['name']) ?></h3>
                        <h3><?php echo htmlspecialchars($product['price']) ?> $</h3>
                        <?php if ($product['type'] === 'DVD') : ?>
                            <h3>Size: <?php echo htmlspecialchars($product['size']) ?> MB</h3>
                        <?php endif; ?>
                        <?php if ($product['type'] === 'Book') : ?>
                            <h3>Weight: <?php echo htmlspecialchars($product['weight']) ?> KG</h3>
                        <?php endif; ?>
                        <?php if ($product['type'] === 'Furniture') : ?>
                            <h3>Dimensions: <?php echo htmlspecialchars($product['height']), " x " . htmlspecialchars($product['width']), " x " . htmlspecialchars($product['length']) ?></h3>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                    <input type="submit" name="delete" value="Delete Selected Products" style="">
          <?php endif; ?>
            </form>
        </div>
    </div>
</body>
</html>
