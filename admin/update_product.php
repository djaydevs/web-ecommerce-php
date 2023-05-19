<?php 
error_reporting(0);

    include '../components/connection.php';

    # ALERT MESSAGE ON THE HEADER

    if(isset($message)){
        foreach( $message as $message){
        echo '
        <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
        }
    }

    #UPDATE PRODUCT FROM DATABASE AND FOLDER

    if(isset($_POST['update_product'])) {

        $id = $_POST['pid'];
        $prodName = mysqli_real_escape_string($conn, $_POST['name']);
        $category = mysqli_real_escape_string($conn, $_POST['product-category']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $details = mysqli_real_escape_string($conn, $_POST['details']);

        $image = mysqli_real_escape_string($conn, $_FILES['image']['name']) ;
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../images/'.$image;
        $old_img = $_POST['old_image'];

        $update = "UPDATE products SET `name` = '$prodName', category = '$category', price = '$price', description = '$details' WHERE product_ID = '$id'";
        $result = mysqli_query($conn, $update);

        $message[] = 'PRODUCT UPDATED SUCCESSFULLY';

        # FOR IMAGE UPDATES
        if(!empty($image)) {
            if($image_size > 2000000){
                $message[] = 'image size is too large';
            }else{
                $new_img = "UPDATE products SET image = '$image' WHERE product_ID = '$id'";
                $result = mysqli_query($conn, $new_img);

                if ($result) {
                    move_uploaded_file($image_tmp_name, $image_folder);
                    // $filename = $result->fetch_assoc();    
                    unlink('../images/' .$old_img);
                    $message[] = 'Image upadated successfully';
                }                
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/admin_products.css ?v=<?php echo time(); ?>">
    <title>Admin - Update Products</title>
</head>
<body>
<p>Update Products</p>

<section class="update-products">

    <h1 class="title"> UPDATE PRODUCTS </h1>

    <!-- FOR DISPLAYING DATA IN UPDATE -->
    <?php         
        $update_id = $_GET['update'];
        $query = "SELECT * FROM products WHERE product_ID = '$update_id'";
        $output = mysqli_query($conn, $query); 

        if($output){
            if (mysqli_num_rows($output) > 0) {
                while($row = $output->fetch_assoc()) {
    ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="old_image" value="<?php echo $row['image']; ?>">
        <input type="hidden" name="pid" value="<?php echo $row['product_ID']; ?>">
        <img src="../images/<?php echo $row['image']; ?>" alt="">
        <input type="text" name="name" placeholder = "Enter product name" required class="box" value="<?php echo $row['name']; ?>">
        <input type="text" name="price" min="0" placeholder = "Enter product price" required class="box" value="<?php echo $row['price']; ?>">
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
            <a href="products.php" class="option-btn">CANCEL</a>
        </div>
    </form>

    <?php 
        }
        } else {
            echo '<p class="empty">NO PRODUCTS FOUND !</p>';    
        }
    }
                    
    ?>

</section>

</body>
</html>