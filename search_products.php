<?php

    session_start();
    include 'components/connection.php';
    
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
     }else{
        $user_id = '';
     };
    
    include 'components/add_to_cart.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./styles/styles.css ?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://kit.fontawesome.com/8eb0534a39.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js" integrity="sha512-gmwBmiTVER57N3jYS3LinA9eb8aHrJua5iQD7yqYCKa5x6Jjc7VDVaEA0je0Lu0bP9j7tEjV3+1qUm6loO99Kw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Search Orders</title>
</head>

<body>
    <?php include 'components/loading.php'; ?>
    <?php include 'components/main_header.php'; ?>
    <section class="search-form">
        <form method="post" action="">
            <input type="text" name="search_box" placeholder="Search product here.." class="box">
            <button type="submit" name="search_btn" class="fas fa-search"></button>
        </form>
    </section>

    <section class="products" style="min-height: 100vh; padding-top:0;">

<div class="box-container">

    <?php
        if (isset($_POST['search_box']) || isset($_POST['search_btn'])) {
            $search_box = $_POST['search_box'];

            $select_products = "SELECT * FROM `products` WHERE name LIKE '%$search_box%'";
            $result = mysqli_query($conn, $select_products);

            if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
    ?>
        <form action="" method="post" class="box">
            <input type="hidden" name="pid" value="<?= $row['product_ID']; ?>">
            <input type="hidden" name="name" value="<?= $row['name']; ?>">
            <input type="hidden" name="price" value="<?= $row['price']; ?>">
            <input type="hidden" name="image" value="<?= $row['image']; ?>">
            <a href="quick_view.php?pid=<?= $row['product_ID']; ?>" class="fas fa-eye"></a>
            <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
            <img src="./assets/images/<?= $row['image']; ?>" alt="">
            <a href="category.php?category=<?= $row['category']; ?>" class="cat"><?= $row['category']; ?></a>
            <div class="name"><?= $row['name']; ?></div>
            <div class="flex">
                <div class="price"><span>&#8369;</span><?= $row['price']; ?></div>
                <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
            </div>
        </form>
    <?php
        }
        }else{
            echo '<p class="empty">No products added yet!</p>';
        }
    }
    ?>

   </div>
<script src="./js/main-container.js"></script>
<script src="js/script.js"></script>
<script src="./js/cart.js"></script>
</body>
</html>