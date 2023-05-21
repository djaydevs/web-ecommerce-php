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

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" type="text/css" href="./styles/styles.css ?v=<?php echo time(); ?>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js" integrity="sha512-gmwBmiTVER57N3jYS3LinA9eb8aHrJua5iQD7yqYCKa5x6Jjc7VDVaEA0je0Lu0bP9j7tEjV3+1qUm6loO99Kw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>BURPGER</title>
</head>

<body>
    <?php include 'components/loading.php'; ?>
    <?php include 'components/main_header.php'; ?>

    <!-- SHOW PRODUCTS -->

    <section class="products">

        <h1 class="title">Food Category</h1>

        <div class="box-container">

            <?php
            $category = $_GET['category'];
            $query = "SELECT * FROM products WHERE category = '$category'";
            $res = mysqli_query($conn, $query);
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
    <script src="./js/script.js"></script>
</body>

</html>