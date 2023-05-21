<?php

include 'components/connection.php';

session_start();

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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./styles/styles.css ?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://kit.fontawesome.com/8eb0534a39.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js" integrity="sha512-gmwBmiTVER57N3jYS3LinA9eb8aHrJua5iQD7yqYCKa5x6Jjc7VDVaEA0je0Lu0bP9j7tEjV3+1qUm6loO99Kw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>BURPGER</title>
</head>

<body>
    <?php include 'components/loading.php'; ?>
    <div class="main-container">
        <?php include 'components/main_header.php'; ?>

        <main>
            <!-- HERO SECTION -->
            <section class="hero | padding-block-900">
                <div class="container">
                    <div class="even-columns">
                        <div class="flow">
                            <h1 class="fs-primary-heading fw-bold">Your home of the best delicious patties!</h1>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore quos quas doloremque ipsum, aspernatur hic recusandae minima porro dolorem odio? Odio, animi! Excepturi incidunt deleniti culpa non et asperiores impedit.</p>
                            <button class="button">Order Now</button>
                        </div>
                        <div>
                            <img src="./assets/images/header1.svg" alt="">
                        </div>
                    </div>
                </div>
            </section>
            <!-- CATEGORY SECTION -->
            <section class="home-category" id="menu">

                <h1 class="title">food category</h1>

                <div class="box-container">
                    <a href="category.php?category=Burger" class="box">
                        <img src="assets/images/burger.png" alt="">
                        <h3>Burger Club</h3>
                    </a>
                    <a href="category.php?category=Fries" class="box">
                        <img src="assets/images/french-fries.png" alt="">
                        <h3>French Fries</h3>
                    </a>
                    <a href="category.php?category=Drinks" class="box">
                        <img src="assets/images/drink.png" alt="">
                        <h3>Drinks</h3>
                    </a>
                </div>
            </section>
            <!-- SHOW PRODUCTS -->
            <section class="products">
                <h1 class="title">Fresh menus</h1>
                <div class="box-container">
                    <?php
                    $select_products = "SELECT * FROM `products` LIMIT 6";
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
                                    <div class="price"><span>&#8369;</span><?php echo $row['price']; ?></div>
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
                    } else {
                        echo '<p class="empty">no products added yet!</p>';
                    }
                    ?>
                </div>
                <!-- <div class="more-btn">
                <a href="menu.html" class="btn">veiw all</a>
                </div> -->
            </section>
        </main>
    </div>
    <script src="./js/main-container.js"></script>
    <script src="./js/script.js"></script>
</body>

</html>