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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./styles/styles.css ?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/8eb0534a39.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js" integrity="sha512-gmwBmiTVER57N3jYS3LinA9eb8aHrJua5iQD7yqYCKa5x6Jjc7VDVaEA0je0Lu0bP9j7tEjV3+1qUm6loO99Kw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>BURPGER</title>
</head>

<body>
    <?php include 'components/loading.php'; ?>
    <div class="main-container">
        <?php include 'components/main_header.php'; ?>
        <main class="main-bg">
            <!-- HERO SECTION -->
            <section class="hero | padding-block-80">
                <div class="container">
                    <div class="even-columns">
                        <div class="flow">
                            <h1 class="fs-primary-heading fw-extrabold">Your home of the best delicious patties!</h1>
                            <p>Burpger is now online! Order your favorite burgers and combos with just few clicks at the comfort of your home.</p>
                            <button class="btn transition primary-btn">Order Now</button>
                        </div>
                        <div>
                            <img src="./assets/images/hero.svg" alt="">
                        </div>
                    </div>
                </div>
            </section>
            <!-- CATEGORY SECTION -->
            <section class="home-category | padding-block-50 container" id="menu">
                <h2 class="title | fs-secondary-heading">Categories</h2>
                <div class="box-container">
                    <a href="category.php?category=Fries" class="box transition">
                        <img src="assets/images/cat-fries.png" alt="">
                        <h3 class="fs-third-heading fw-semi-bold">Fries</h3>
                        <p>Enjoy our crispy and golden fries made from the finest potatoes, seasoned to perfection</p>
                    </a>
                    <a href="category.php?category=Burger" class="center-box transition">
                        <img src="assets/images/cat-burger.png" alt="">
                        <h3 class="fs-third-heading fw-semi-bold">Burger Club</h3>
                        <p>Indulge in mouthwatering burgers crafted with juicy beef patties or plant-based alternatives, topped with fresh ingredients and served on toasted buns</p>
                    </a>
                    <a href="category.php?category=Drinks" class="box transition">
                        <img src="assets/images/cat-drinks.png" alt="">
                        <h3 class="fs-third-heading fw-semi-bold">Drinks</h3>
                        <p>Quench your thirst with our refreshing selection of customizable drinks</p>
                    </a>
                </div>
            </section>
            <!-- SHOW PRODUCTS -->
            <section class="products">
                <h1 class="title">Fresh menus</h1>
                <div class="box-container">
                    <?php
                    $select_products = "SELECT * FROM `products` LIMIT 5";
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
        <footer id="contacts">
            <section class="contact | container">
                <div class="row">
                    <div class="image">
                        <img id="contacts-bg" src="./assets/images/contacts.png" alt="">
                        <div class="info">
                            <div class="information">
                                <img src="./assets/icons/location.png" class="icon" alt="" />
                                <p>124 Bikini Bottom, Cronch St.</p>
                            </div>
                            <div class="information">
                                <img src="./assets/icons/mail.png" class="icon" alt="" />
                                <p>service@burpger.com</p>
                            </div>
                            <div class="information">
                                <img src="./assets/icons/phone.png" class="icon" alt="" />
                                <p>123-456-789</p>
                            </div>
                        </div>
                    </div>
                    <form action="" method="POST">
                        <h3 class="third-heading fw-medium">Contact Us</h3>
                        <input type="text" name="name" maxlength="50" class="box" placeholder="Name" required>
                        <input type="email" name="email" maxlength="50" class="box" placeholder="Email" required>
                        <textarea name="msg" class="box" required placeholder="Message" maxlength="500" cols="30" rows="10"></textarea>
                        <input type="submit" value="Send Message" name="send" class="send-btn | btn transition primary-btn">
                    </form>
                </div>
            </section>
            <div id="copyright">
                <p>&copy; 2023 | Burpger Inc.<br><br>DISCLAIMER<br>Burpger Inc. is not a real fast food company.<br>For educational purposes only.</p>
            </div>
        </footer>
    </div>
    <script src="./js/main-container.js"></script>
    <script src="./js/script.js"></script>
</body>

</html>