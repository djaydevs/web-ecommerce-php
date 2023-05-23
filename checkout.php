<?php 
   
    include 'components/connection.php';

    session_start();

    if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    }else{
    $user_id = '';
    header('location:index.php');
    };

    if (isset($_POST['submit'])) {
      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      $number = $_POST['number'];
      $number = filter_var($number, FILTER_SANITIZE_STRING);
      $email = $_POST['email'];
      $email = filter_var($email, FILTER_SANITIZE_STRING);
      $method = $_POST['method'];
      $method = filter_var($method, FILTER_SANITIZE_STRING);
      $address = $_POST['address'];
      $address = filter_var($address, FILTER_SANITIZE_STRING);
      $total_products = $_POST['total_products'];
      $total_price = $_POST['total_price'];
  
      $check_cart = $conn->prepare("SELECT COUNT(*) FROM `cart` WHERE user_id = ?");
      $check_cart->execute([$user_id]);
      $cart_items_count = $check_cart->get_result();
  
      if ($cart_items_count->num_rows > 0) {
          if ($address == '') {
              $message[] = 'please add your address!';
          } else {
              $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
              $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);
  
              $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
              $delete_cart->execute([$user_id]);
  
              $message[] = 'Order placed successfully!';
          }
      } else {
          $message[] = 'your cart is empty';
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

   <?php include 'components/main_header.php'; ?>

   <section class="checkout">

      <form action="" method="post">

         <div class="cart-items">
         <h3>cart items</h3>
            <?php
                  $grand_total = 0;
                  $cart_items[] ='';
                  $display = "SELECT * FROM cart WHERE user_id = '$user_id'";
                  $output = mysqli_query($conn, $display);
                  if(mysqli_num_rows($output) > 0){
                     while ($row = $output->fetch_assoc()) {
                        $cart_items[] = $row['name'].' ('.$row['price'].' x '. $row['quantity'].') - ';
                        $total_products = implode($cart_items);
                        $grand_total += ($row['price'] * $row['quantity']);
               ?>
               <p><span class="name"><?= $row['name']; ?></span><span class="price">$<?= $row['price']; ?> x <?= $row['quantity']; ?></span></p>
               <?php
                     }
                  }else{
                     echo '<p class="empty">your cart is empty</p>';
                  }
               ?>
               <p class="grand-total"><span class="name">grand total :</span><span class="price">$<?= $grand_total; ?></span></p>
               <a href="cart.php" class="check-btn">view cart</a>
         </div>

         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
         <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
         <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
         <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
         <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">

         <div class="user-info">
         <h3>your info</h3>
         <p><i class="fas fa-user"></i><span><?= $fetch_profile['name'] ?></span></p>
         <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number'] ?></span></p>
         <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
         <a href="user_profile_update_profile.php" class="check-btn">update info</a>
         <h3>delivery address</h3>
         <p><i class="fas fa-map-marker-alt"></i><span><?php if($fetch_profile['address'] == ''){echo 'please enter your address..';}else{echo $fetch_profile['address'];}?></span></p>
         <a href="user_profile_update_address.php" class="check-btn">update address</a>
         <select name="method" class="box" required>
            <option value="" disabled selected>select payment method --</option>
            <option value="cash on delivery">Cash on delivery</option>
            <option value="credit card">Credit card</option>
            <option value="paytm">G-cash</option>
            <option value="paypal">Paypal</option>
         </select>   
         <input type="submit" value="place order" class="check-btn" <?php if($fetch_profile['address'] == ''){echo 'disabled';} ?>" style="width:100%; background:var(--red); color:var(--white);" name="submit">
      </div>
   </form>
   </section> 

   <script src="./js/main-container.js"></script>
   <script src="./js/script.js"></script>
</body>  
</html> 