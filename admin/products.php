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
            header('location:products.php');
        } else {
            if ($image_size > 2000000) {
                $message[] = 'image size is too large';
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);

                $sqlInsert = "INSERT INTO products (name, category, price, image, description) VALUES ('$prodName', '$category', '$price', '$image', '$description')";
                $result = mysqli_query($conn, $sqlInsert);
                $message[] = 'new product added!';
                header('location:products.php');
            }
        }
    }

    if ($result) {
        $_SESSION['status'] = "Products Data Added Successfully !";
    } else {
        $_SESSION['status'] = "Products Data failed to save !";
    }
}

# ALERT MESSAGE ON THE HEADER

if (isset($message)) {
    foreach ($message as $message) {
        echo '
        <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
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

# DELETE PRODUCTS FROM DATABASE AND IMAGE FOLDER (LOCAL STORAGE)

if (isset($_GET['delete'])) {

    $id = $_GET['delete'];
    $query = "SELECT * FROM products WHERE product_ID = '$id'";
    $output = mysqli_query($conn, $query);

    $filename = $output->fetch_assoc();
    unlink('../assets/images/' . $filename['image']);
    $deleteQuery = "DELETE FROM products WHERE product_ID = $id";
    $result = mysqli_query($conn, $deleteQuery);
    header('location:products.php');

    # ADD DELETE QUERY FOR ADD TO CART...

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/admin_products.css ?v=<?php echo time(); ?>">
    <title>Admin - Products</title>
</head>

<body>
    <!-- ADD PRODUCTS -->

    <section class="style-products">

        <h1 class="title">Add New Products</h1>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="flex">
                <div class="input-box">
                    <input type="text" name="product-name" class="box" required placeholder="Enter product name">
                    <select name="product-category" class="box" required>
                        <option value="" selected disabled>Select Category</option>
                        <option value="Burger">Burger</option>
                        <option value="Fries">Fries</option>
                        <option value="Drinks">Drinks</option>
                    </select>
                </div>
                <div class="input-box">
                    <input type="number" min="0" name="product-price" class="box" required placeholder="Enter product price">
                    <input type="file" name="image" required class="box" accept="image/jpg, image/.jpeg, image/png, image/webp">
                </div>
            </div>
            <textarea name="product-details" class="box" cols="25" rows="5" required placeholder="Enter product details"></textarea>
            <input type="submit" class="btn" value="Add Products" name="add-product">
        </form>
    </section>

    <!-- SHOW PRODUCTS -->

    <?php
    $select = "SELECT * FROM `products`";
    $rslt = mysqli_query($conn, $select);
    ?>

    <section class="show-products">
        <div class="box-container">

            <?php
            if ($rslt == true) {
                if ($rslt->num_rows > 0) {
                    while ($row = $rslt->fetch_assoc()) {
            ?>
                        <div class="box">
                            <div class="price">&#8369;<?php echo $row['price']; ?>/-</div>
                            <img src="../assets/images/<?php echo $row['image']; ?>" alt="">
                            <div class="name"><?php echo $row['name']; ?></div>
                            <div class="category"><?php echo $row['category']; ?></div>
                            <div class="details"><?php echo $row['description']; ?></div>
                            <div class="flex-btn">
                                <a href="update_product.php?update=<?php echo $row['product_ID']; ?>" class="option-btn">update</a>
                                <a href="products.php?delete=<?php echo $row['product_ID']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
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

</body>

</html>