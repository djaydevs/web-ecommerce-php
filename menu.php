<?php

session_start();
include 'components/connection.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
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
   <title>Menu</title>
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
   <link rel="stylesheet" type="text/css" href="./styles/styles.css ?v=<?php echo time(); ?>">
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/8eb0534a39.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js" integrity="sha512-gmwBmiTVER57N3jYS3LinA9eb8aHrJua5iQD7yqYCKa5x6Jjc7VDVaEA0je0Lu0bP9j7tEjV3+1qUm6loO99Kw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <?php include 'components/loading.php'; ?>
    <div class="main-container">
        <?php include 'components/main_header.php'; ?>
        <div class="heading-menu">
        <h3>Our menu</h3>
        <p><a href="index.php">Home</a> <span> / Menu</span></p>
        </div>
        <section class="products">

        <h1 class="title">Fresh menus</h1>

            <div class="box-container">
                <?php
                    $select_products ="SELECT * FROM `products`";
                    $res = mysqli_query($conn, $select_products);
                            if (mysqli_num_rows($res) > 0) {
                                while ($row = $res->fetch_assoc()) {
                ?>
                <form action="" method="post" class="box">
                    <input type="hidden" name="pid" value="<?php echo $row['product_ID']; ?>">
                    <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                    <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                    <input type="hidden" name="image" value="<?php echo $row['image']; ?>">
                    <a href="quick_view.php?pid=<?php echo $row['product_ID']; ?>" class="fas fa-eye"></a>
                    <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
                    <img src="./assets/images/<?php echo $row['image']; ?>" alt="">
                    <a href="category.php?category=<?php echo $row['category']; ?>" class="cat"><?php echo $row['category']; ?></a>
                    <div class="name"><?php echo $row['name']; ?></div>
                    <div class="flex">
                        <div class="price"><span>$</span><?php echo $row['price']; ?></div>
                        <input type="number" name="qty" class="qty" min="1" max="99" value="0" maxlength="2">

                        <script>
                            document.querySelectorAll('input[type="number"]').forEach(numberInput => {
                                numberInput.oninput = () => {
                                    if (numberInput.value.length > numberInput.maxLength) numberInput.value = numberInput.value.slice(0, numberInput.maxLength);
                                };
                            });
                        </script>
                    </div>
                </form>
                <?php
                        }
                    }else{
                        echo '<p class="empty">no products added yet!</p>';
                    }
                ?>
            </div>
        </section>
    </div>
<script src="./js/main-container.js"></script>
<script src="./js/script.js"></script>
</body>
</html>