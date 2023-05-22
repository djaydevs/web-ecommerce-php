<?php

include 'components/connection.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:index.php');
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>orders</title>

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
    
    <!-- orders function -->
    <section class="orders">

   <h1 class="title">your orders</h1>

   <div class="box-container">
    
   <?php
      if($user_id == ''){
         echo '<p class="empty">please login to see your orders</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         $result = $select_orders->get_result();
         if($result->num_rows > 0){
            while ($row = $result->fetch_assoc()){
   ?>
   <div class="box">
      <p>Placed on : <span><?= $row['placed_on']; ?></span></p>
      <p>Name : <span><?= $row['name']; ?></span></p>
      <p>Email : <span><?= $row['email']; ?></span></p>
      <p>Number : <span><?= $row['number']; ?></span></p>
      <p>Address : <span><?= $row['address']; ?></span></p>
      <p>Payment Method : <span><?= $row['method']; ?></span></p>
      <p>Your Orders : <span><?= $row['total_products']; ?></span></p>
      <p>Total Price : <span>&#8369;<?= $row['total_price']; ?>/-</span></p>
      <p> Payment Status : <span style="color:<?php if($row['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $row['payment_status']; ?></span> </p>
   </div>
   <?php
      }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
      }
   ?>

   </div>

</section>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>
</body>
</html>