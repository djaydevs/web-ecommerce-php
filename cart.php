<?php
include 'components/connection.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location: index.php');
};


if (isset($_POST['delete_item'])) {
   $id = $_POST['cid'];
   $item = "DELETE FROM cart WHERE id = '$id'";
   $res = mysqli_query($conn, $item);
   $message[] = 'cart item deleted!';
}

if (isset($_POST['delete_all'])) {
   $delete_cart = "DELETE FROM cart WHERE user_id = '$user_id'";
   $res = mysqli_query($conn, $delete_cart);
   $message[] = 'deleted all from cart!';
}

if (isset($_POST['update_qty'])) {
   $cart_id = $_POST['cid'];
   $qty = mysqli_real_escape_string($conn, $_POST['qty']);
   $update_qty = "UPDATE cart SET quantity = '$qty' WHERE id = $cart_id";
   $res = mysqli_query($conn, $update_qty);
   $message[] = 'cart quantity updated';
}

$grand_total = 0;

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
   <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js" integrity="sha512-gmwBmiTVER57N3jYS3LinA9eb8aHrJua5iQD7yqYCKa5x6Jjc7VDVaEA0je0Lu0bP9j7tEjV3+1qUm6loO99Kw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <title>BURPGER</title>
</head>

<body>
   <?php include 'components/loading.php' ?>
   <div class="main-container">
      <?php include 'components/main_header.php' ?>
      <div class="top-header">
         <h2 class="fs-secondary-heading fw-bold">Shopping Cart</h2>
      </div>
      <main>
         <section class="products">
            <h3 class="title | fs-third-heading fw-medium">your cart</h3>

            <div class="box-container">
               <?php
               $grand_total = 0;
               $display = "SELECT * FROM cart WHERE user_id = '$user_id'";
               $output = mysqli_query($conn, $display);
               if (mysqli_num_rows($output) > 0) {
                  while ($row = $output->fetch_assoc()) {
               ?>
                     <form action="" method="POST" class="box">
                        <input type="hidden" name="cid" value="<?php echo $row['id']; ?>">
                        <a href="quick_view.php?pid=<?php echo $row['pid']; ?>" class="fas fa-eye"></a>
                        <button type="submit" class="fas fa-times" name="delete_item" onclick="return confirm('delete this item?');"></button>
                        <img src="./assets/images/<?php echo $row['image']; ?>" alt="">
                        <div class="name"><?php echo $row['name']; ?></div>
                        <div class="flex">
                           <div class="price"><span>&#8369;</span><?php echo $row['price']; ?></div>
                           <input type="number" name="qty" class="qty" value="<?php echo $row['quantity']; ?>" min="1" max="99" maxlength="2">
                           <button type="submit" class="fas fa-edit" name="update_qty"></button>
                        </div>
                        <div class="sub-total"> sub total : <span>$<?php echo $sub_total = ($row['price'] * $row['quantity']); ?>/-</span> </div>
                     </form>
               <?php
                     $grand_total += $sub_total;
                  }
               } else {
                  echo '<p class="empty">your cart is empty</p>';
               }
               ?>

            </div>

            <div class="cart-total">
               <p>cart total : <span>&#8369;<?= $grand_total; ?></span></p>
               <a href="checkout.php" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">proceed to checkout</a>
            </div>

            <div class="more-btn">
               <form action="" method="post">
                  <button type="submit" class="delete-btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" name="delete_all" onclick="return confirm('delete all from cart?');">delete all</button>
               </form>
               <a href="index.php" class="btn">continue shopping</a>
            </div>

         </section>
      </main>
   </div>
   <script src="./js/main-container.js"></script>
   <script src="./js/script.js"></script>
</body>

</html>