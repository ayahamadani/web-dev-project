<?php

include('connection/test_conn.php');

// Assign the input variables
$sku = $name = $price = $weight = $size = $height = $length = $width = $type = '';
$errors = array(
    'sku' => '',
    'name' => '',
    'price' => '',
    'weight' => '',
    'size' => '',
    'height' => '',
    'length' => '',
    'type' => '',
    'width' => ''
);

if (isset($_POST['submit'])) {
    if (empty($_POST['Type_Switcher'])) {
        $errors['type'] = 'Type is required.';
    } else {
        // Assign the type var
        $type = $_POST['Type_Switcher'];
        if (!in_array($type, ['DVD', 'Book', 'Furniture'])) {
            $errors['type'] = 'Invalid type selected.';
        }
    }

    if (empty($_POST['sku'])) {
        $errors['sku'] = 'SKU is required.';
    } else {
        // Assign the sku var
        $sku = $_POST['sku'];
        if (!preg_match('/^(?=.*\d)(?=.*[A-Z])[A-Z\d]{8}$/', $sku)) {
            $errors['sku'] = 'SKU must be valid.';
        }
    }

    if (empty($_POST['name'])) {
        $errors['name'] = 'Name is required.';
    } else {
        // Assign the name var
        $name = $_POST['name'];
        if (!preg_match('/^[A-Za-z]?[A-Za-z0-9-_]{3,15}$/', $name)) {
            $errors['name'] = 'Name must be from 3 to 15 characters.';
        }
    }

    if (empty($_POST['price'])) {
        $errors['price'] = 'Price is required.';
    } else {
        // Assign the price var
        $price = $_POST['price'];
        if (!preg_match('/^(?:[1-9]\d*(?:\.\d{2})?)$/', $price)) {
            $errors['price'] = 'The price should have a maximum of two decimal places.';
        }
    }

    // Assign the type var
    $type = $_POST['Type_Switcher'];

    if ($type === 'DVD') {
        if (empty($_POST['size'])) {
            $errors['size'] = 'Size is required for DVD.';
        } else {
            // Assign the size var
            $size = $_POST['size'];
        }
    }

    if ($type === 'Book') {
        if (empty($_POST['weight'])) {
            $errors['weight'] = 'Weight is required.';
        } else {
            // Assign the weight var
            $weight = $_POST['weight'];
            if (!preg_match('/^[0-9]*$/', $weight)) {
                $errors['weight'] = 'Weight must be valid.';
            }
        }
    }

    if ($type === 'Furniture') {
        if (empty($_POST['height'])) {
            $errors['height'] = 'Height is required.';
        } else {
            // Assign the height var
            $height = $_POST['height'];
            if (!preg_match('/^[0-9]*$/', $height)) {
                $errors['height'] = 'Height must be valid.';
            }
        }

        if (empty($_POST['length'])) {
            $errors['length'] = 'Length is required.';
        } else {
            // Assign the length var
            $length = $_POST['length'];
            if (!preg_match('/^[0-9]*$/', $length)) {
                $errors['length'] = 'Length must be valid.';
            }
        }

        if (empty($_POST['width'])) {
            $errors['width'] = 'Width is required.';
        } else {
            // Assign the width var
            $width = $_POST['width'];
            if (!preg_match('/^[0-9]*$/', $width)) {
                $errors['width'] = 'Width must be valid.';
            }
        }
    }
}

if (isset($_POST['submit'])) {
    // Rest of the code for form validation and error handling
    if (array_filter($errors)) {
        // Checking if there are errors in the form
        echo 'There are errors in the form.';
        if(isset($_POST["type"] ) === "Book") {
            echo "the book type was selected";
        }
    } else {
        // Check if SKU already exists
        $checkSql = "SELECT COUNT(*) as count FROM products WHERE sku = ?";
        $checkStmt = mysqli_prepare($conn, $checkSql);
        mysqli_stmt_bind_param($checkStmt, 's', $sku);
        mysqli_stmt_execute($checkStmt);
        $result = mysqli_stmt_get_result($checkStmt);
        $row = mysqli_fetch_assoc($result);

        // If a row exists, a matching SKU exists, so display an error
        if ($row['count'] > 0) {
            $errors['sku'] = 'SKU already exists.';
        } else {
            // Insert new product into the database
            $insertSql = "INSERT INTO products (sku, name, price, weight, size, height, length, width, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $insertStmt = mysqli_prepare($conn, $insertSql);
            mysqli_stmt_bind_param($insertStmt, 'ssiiiiiis', $sku, $name, $price, $weight, $size, $height, $length, $width, $type);

            if (mysqli_stmt_execute($insertStmt)) {
                // Success
                header('Location: index.php');
                exit();
            } else {
                echo 'Query error: ' . mysqli_stmt_error($insertStmt);
            }
        }
    }
}

?>

<!-- Your HTML code -->

<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="header-div">
    <h1>Product Add</h1>
</div>

<form class="add-page-main" method="POST" action="add-product.php" id="addForm">
    <div class="header-inner-div">
        <input type="submit" name="submit" value="Save" class="save-btn" id="saveBtn">
        <input type="button" name="cancel" value="cancel" class="save-btn" id="cancelBtn">
    </div>
    <!-- Add a Div for each input -->
    <div class="name-input">
        <h3 class="input-labels">SKU</h3>
        <input type="text" id="sku" name="sku" value="<?php echo htmlspecialchars($sku); ?>">
        <h4 id="sku_error_msg"><?php echo $errors['sku'] ?></h4>
        <h4 id="sku_regex_msg" style="display: none;">The SKU must consist of exactly 8 alphanumeric uppercase characters.</h4>
    </div>
    <div class="name-input">
        <h3 class="input-labels">Name</h3>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
        <h4 id="name_regex_msg" style="display: none;">The name must have a length ranging from 3 to 15 characters.</h4>
        <h4 id="name_error_msg"><?php echo $errors['name'] ?></h4>
    </div>
    <div class="name-input">
        <h3 class="input-labels">Price</h3>
        <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>">
        <h4 id="price_regex_msg" style="display: none;">The price should have a maximum of two decimal places.</h4>
        <h4 id="price_error_msg"><?php echo $errors['price'] ?></h4>
    </div>
    <div class="name-input">
        <h3>Type Switcher</h3>
        <select name="Type_Switcher" id="productType" class="type-switcher-input" onchange="showFields()" required>
            <option value="" selected>Select</option>
            <option value="DVD">DVD</option>
            <option value="Book">Book</option>
            <option value="Furniture">Furniture</option>
        </select>
    </div>
    <!-- furnitureField Div -->
    <div id="furnitureField" style="display: none;">
        <div class="name-input">
            <h3 class="input-labels">Height</h3>
            <input type="text" id="height" name="height" value="<?php echo htmlspecialchars($height) ?>">
            <h4 id="height_regex_msg" style="display: none;">Please submit correct data</h4>
            <h4 id="height_error_msg"><?php echo $errors['height'] ?></h4>
        </div>
        <div class="name-input">
            <h3 class="input-labels">Width</h3>
            <input type="text" id="width" name="width" value="<?php echo htmlspecialchars($width) ?>">
            <h4 id="width_regex_msg" style="display: none;">Please submit correct data</h4>
            <h4 id="width_error_msg"><?php echo $errors['width'] ?></h4>
        </div>
        <div class="name-input">
            <h3 class="input-labels">Length</h3>
            <input type="text" id="length" name="length" value="<?php echo htmlspecialchars($length) ?>">
            <h4 id="length_regex_msg" style="display: none;">Please submit correct data</h4>
            <h4 id="length_error_msg"><?php echo $errors['length'] ?></h4>
        </div>
        <h4>Please provide dimensions in HxWxL format.</h4>
    </div>
    <!-- bookField Div -->
    <div id="bookField" style="display: none">
        <div class="name-input">
            <h3 class="input-labels">Weight</h3>
            <input type="text" id="weight" name="weight" value="<?php echo htmlspecialchars($weight) ?>">
            <h4 id="weight_regex_msg" style="display: none;">Please submit correct data</h4>
            <h4 id="weight_error_msg"><?php echo $errors['weight'] ?></h4>
        </div>
        <h4>Please provide the weight of the book. (in Kg)</h4>
    </div>
    <!-- dvdField Div -->
    <div id="dvdField" style="display: none">
        <div class="name-input">
            <h3 class="input-labels">Size</h3>
            <input type="text" id="size" name="size" value="<?php echo htmlspecialchars($size) ?>">
            <h4 id="size_regex_msg" style="display: none;">Please submit correct data</h4>
            <h4 id="size_error_msg"><?php echo $errors['size'] ?></h4>
        </div>
        <h4>Please provide the size of the DVD. (in MB)</h4>
    </div>
</form>

<!-- Add Javascript -->
<script src="add-product.js"></script>
</body>
</html>
