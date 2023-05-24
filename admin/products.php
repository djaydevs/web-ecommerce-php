<?php
error_reporting(0);

include '../components/connection.php';

# ADD PRODUCTS TO DATABASE AND IMAGES TO FOLDER

if (isset($_POST['add-product'])) {

    $prodName = mysqli_real_escape_string($conn, $_POST['product-name']);
    $category = mysqli_real_escape_string($conn, $_POST['product-category']);
    $price = mysqli_real_escape_string($conn, $_POST['product-price']);
    $description = mysqli_real_escape_string($conn, $_POST['product-details']);

    //UPLOADING IMAGE TO PATH AND DATABASE
    $image = mysqli_real_escape_string($conn, $_FILES['image']['name']);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../assets/images/' . $image;

    $sqlSelect = "SELECT * FROM products WHERE name = '$prodName'";
    $result = mysqli_query($conn, $sqlSelect);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $message[] = "Products already exists !";
            header('location:home.php?display=products');
        } else {
            if ($image_size > 2000000) {
                $message = 'image size is too large';
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);

                $sqlInsert = "INSERT INTO products (name, category, price, image, description) VALUES ('$prodName', '$category', '$price', '$image', '$description')";
                $result = mysqli_query($conn, $sqlInsert);
                $message = 'New product added!';
                header('location: home.php?display=products&message=' . urlencode($message));
            }
        }
    }

    if ($result) {
        $_SESSION['status'] = "Products Data Added Successfully !";
    } else {
        $_SESSION['status'] = "Products Data failed to save !";
    }
}

# ALERT MESSAGE

if (isset($message)) {
    foreach ($message as $message) {
        echo '
        <div class="message">
            <span>' . $message . '</span>
        </div>
        <script>
        setTimeout(function() {
            var messages = document.getElementsByClassName("message");
            while (messages[0]) {
                messages[0].remove();
            }
        }, 5000); // 5 seconds
        </script>
        ';
    }
}

if (isset($_GET['message'])) {
    $message = $_GET['message'];
    echo '
    <div class="message">
        <span>' . $message . '</span>
    </div>
    <script>
        setTimeout(function() {
            var messages = document.getElementsByClassName("message");
            while (messages[0]) {
                messages[0].remove();
            }
        }, 5000); // 5 seconds
    </script>
    ';
}

# DELETE PRODUCTS FROM DATABASE AND IMAGE FOLDER (LOCAL STORAGE)

if (isset($_GET['delete'])) {

    $id = $_GET['delete'];
    $query = "SELECT * FROM products WHERE product_ID = '$id'";
    $output = mysqli_query($conn, $query);

    $filename = $output->fetch_assoc();
    unlink('../assets/images/' . $filename['image']);
    $deleteQuery = "DELETE FROM products WHERE product_ID = $id";
    $result = mysqli_query($conn, $deleteQuery);
    $message = 'Product Deleted!';
    header('location: home.php?display=products&message=' . urlencode($message));

    # ADD DELETE QUERY FOR ADD TO CART...

}
#UPDATE PRODUCT FROM DATABASE AND FOLDER

if (isset($_POST['update_product'])) {
    $pid = mysqli_real_escape_string($conn, $_POST['pid']);
    $prodName = mysqli_real_escape_string($conn, $_POST['name']);
    $category = mysqli_real_escape_string($conn, $_POST['product-category']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['details']);
    $oldImage = mysqli_real_escape_string($conn, $_POST['old_image']);

    $image = mysqli_real_escape_string($conn, $_FILES['image']['name']);
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../assets/images/' . $image;

    if ($image) {
        if ($_FILES['image']['size'] > 2000000) {
            $message = 'Image size is too large';
        } else {
            move_uploaded_file($image_tmp_name, $image_folder);
            unlink('../assets/images/' . $oldImage);
        }
    } else {
        $image = $oldImage;
    }

    $updateQuery = "UPDATE products SET name = '$prodName', category = '$category', price = '$price', image = '$image', description = '$description' WHERE product_ID = $pid";
    $result = mysqli_query($conn, $updateQuery);
    if ($result) {
        $message = 'Product updated!';
        header('location: home.php?display=products&message=' . urlencode($message));
    } else {
        $message = 'Failed to update product';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/admin_styles.css ?v=<?php echo time(); ?>">
</head>

<body>
    <div class="section-grid">
        <!-- ADD PRODUCTS -->
        <section class="style-products">
            <h2 class="fs-secondary-heading fw-semi-bold">Add New Products</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="flex">
                    <div class="input-box">
                        <input type="text" name="product-name" class="box" required placeholder="Product Name">
                        <select name="product-category" class="box" required>
                            <option value="" selected disabled>Select Category</option>
                            <option value="Burger">Burger</option>
                            <option value="Fries">Fries</option>
                            <option value="Drinks">Drinks</option>
                        </select>
                    </div>
                    <div class="input-box">
                        <input type="number" min="0" name="product-price" class="box" required placeholder="Product Price">
                        <input type="file" name="image" required class="box" accept="image/jpg, image/.jpeg, image/png, image/webp">
                    </div>
                </div>
                <textarea name="product-details" class="box" cols="25" rows="5" required placeholder="Product Details"></textarea>
                <input type="submit" class="btn transition primary-btn" value="Add Product" name="add-product">
            </form>
        </section>
        <!-- SHOW PRODUCTS -->
        <?php
        $select = "SELECT * FROM `products`";
        $rslt = mysqli_query($conn, $select);
        ?>
        <section class="show-products">
            <!-- <h3 class="fs-third-heading fw-medium">Products</h3> -->
            <div class="box-container">
                <?php
                if ($rslt == true) {
                    if ($rslt->num_rows > 0) {
                        while ($row = $rslt->fetch_assoc()) {
                ?>
                            <div class="show-box">
                                <div class="box-flow">
                                    <div class="price">&#8369; <?php echo $row['price']; ?></div>
                                    <img src="../assets/images/<?php echo $row['image']; ?>" alt="">
                                    <p class="name | fw-medium"><?php echo $row['name']; ?></p>
                                    <p class="category"><?php echo $row['category']; ?></p>
                                    <p class="details"><?php echo $row['description']; ?></p>
                                </div>
                                <div class="flex-btn">
                                    <button class="btn transition primary-btn fw-medium" name="update" onclick="openForm(<?php echo $row['product_ID']; ?>)">Update</button>
                                    <a class="btn transition secondary-btn fw-medium" href="products.php?delete=<?php echo $row['product_ID']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">Delete</a>
                                </div>
                            </div>

                <?php
                        }
                    } else {
                        echo '<p class="empty"> No products added yet! </p>';
                    }
                }
                ?>

            </div>
        </section>
    </div>
    <div class="update-form" id="update-form">
        <section class="update-products">
            <h1 class="title"> UPDATE PRODUCTS </h1>

            <!-- FOR DISPLAYING DATA IN UPDATE -->
            <?php
            $update_id = null;
            if (isset($_GET['update'])) {
                $update_id = mysqli_real_escape_string($conn, $_GET['update']);
                $query = "SELECT * FROM products WHERE product_ID = '$update_id'";
                $output = mysqli_query($conn, $query);

                if ($output) {
                    if (mysqli_num_rows($output) > 0) {
                        while ($row = $output->fetch_assoc()) {
            ?>

                            <form action="" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="old_image" value="<?php echo $row['image']; ?>">
                                <input type="hidden" name="pid" value="<?php echo $row['product_ID']; ?>">
                                <img src="../assets/images/<?php echo $row['image']; ?>" alt="">
                                <input type="text" name="name" placeholder="Enter product name" required class="box" value="<?php echo $row['name']; ?>">
                                <input type="text" name="price" min="0" placeholder="Enter product price" required class="box" value="<?php echo $row['price']; ?>">
                                <select name="product-category" class="box" required>
                                    <option selected><?php echo $row['category']; ?></option>
                                    <option value="Burger">Burger</option>
                                    <option value="Fries">Fries</option>
                                    <option value="Drinks">Drinks</option>
                                </select>
                                <textarea name="details" required placeholder="Enter product description" class="box" cols="30" rows="5"><?php echo $row['description']; ?></textarea>
                                <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
                                <div class="flex-btn">
                                    <input type="submit" class="btn" value="Update Product" name="update_product">
                                    <a href="home.php?display=products" class="option-btn">CANCEL</a>
                                </div>
                            </form>

            <?php
                        }
                    } else {
                        echo '<p class="empty">NO PRODUCTS FOUND !</p>';
                    }
                }
            }
            ?>
        </section>
    </div>
    <script>
        var selectedProductID = null;
        //Store product ID in URL
        function openForm(productID) {
            selectedProductID = productID;
            var url = 'home.php?display=products&update=' + productID;
            window.location.href = url;
        }

        // Check if a product ID is stored in the URL
        window.addEventListener('DOMContentLoaded', (event) => {
            var urlParams = new URLSearchParams(window.location.search);
            var updateParam = urlParams.get('update');
            if (updateParam) {
                selectedProductID = updateParam;
                document.getElementById("update-form").style.display = "block";
            }
        });
    </script>
</body>

</html>