<?php 
    include 'components/connection.php';

    session_start();

    if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    }else{
    $user_id = '';
    header('location:home.php');
    };

        
    if(isset($_POST['delete_item'])){
        $id = $_POST['cid'];
        $item = "DELETE FROM cart WHERE id = '$id'";
        $res = mysqli_query($conn, $item);
        $message[] = 'cart item deleted!';
    }
    
    if(isset($_POST['delete_all'])){
        $delete_cart = "DELETE FROM cart WHERE user_id = '$user_id'";
        $res = mysqli_query($conn, $delete_cart);
        $message[] = 'deleted all from cart!';
    }
    
    if(isset($_POST['update_qty'])){
        $cart_id = $_POST['cid'];
        $qty = mysqli_real_escape_string($conn, $_POST['qty']);
        $update_qty = "UPDATE cart SET quantity = '$qty' WHERE id = $cart_id";
        $res = mysqli_query($conn, $update_qty);
        $message[] = 'cart quantity updated';
    }
    
    $grand_total = 0;

    # ALERT MESSAGE ON THE HEADER

    if(isset($message)){
        foreach($message as $message){
        echo '
        <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./styles/styles.css ?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js" integrity="sha512-gmwBmiTVER57N3jYS3LinA9eb8aHrJua5iQD7yqYCKa5x6Jjc7VDVaEA0je0Lu0bP9j7tEjV3+1qUm6loO99Kw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>BURPGER</title>
</head>
<body>

<div class="loading-page">
    <svg id="loading-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M61.1 224C45 224 32 211 32 194.9c0-1.9 .2-3.7 .6-5.6C37.9 168.3 78.8 32 256 32s218.1 136.3 223.4 157.3c.5 1.9 .6 3.7 .6 5.6c0 16.1-13 29.1-29.1 29.1H61.1zM144 128a16 16 0 1 0 -32 0 16 16 0 1 0 32 0zm240 16a16 16 0 1 0 0-32 16 16 0 1 0 0 32zM272 96a16 16 0 1 0 -32 0 16 16 0 1 0 32 0zM16 304c0-26.5 21.5-48 48-48H448c26.5 0 48 21.5 48 48s-21.5 48-48 48H64c-26.5 0-48-21.5-48-48zm16 96c0-8.8 7.2-16 16-16H464c8.8 0 16 7.2 16 16v16c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V400z"/></svg>
</div>

<?php include 'components/main_header.php'?>

<script src="./js/script.js"></script>
<script>
    gsap.fromTo(
        ".loading-page",
        { opacity: 1 },
        {
            opacity: 0,
            display: "none",
            duration: 1.5,
            delay: 2,
        }
    );
</script>

<div class="heading">
   <h3>shopping cart</h3>
   <p><a href="home.php">home</a> <span> / cart</span></p>
</div>

<section class="products">

   <h1 class="title">your cart</h1>

   <div class="box-container">

      <?php
         $grand_total = 0;
         $display = "SELECT * FROM cart WHERE user_id = '$user_id'";
         $output = mysqli_query($conn, $display);
         if(mysqli_num_rows($output) > 0){
            while ($row = $output->fetch_assoc()) {
      ?>
      <form action="" method="POST" class="box">
         <input type="hidden" name="cid" value="<?php echo $row['id']; ?>">
         <a href="quick_view.php?pid=<?php echo $row['pid']; ?>" class="fas fa-eye"></a>
         <button type="submit" class="fas fa-times" name="delete_item" onclick="return confirm('delete this item?');"></button>
         <img src="./assets/images/<?php echo $row['image']; ?>" alt="">
         <div class="name"><?php echo $row['name']; ?></div>
         <div class="flex">
            <div class="price"><span>$</span><?php echo $row['price']; ?></div>
            <input type="number" name="qty" class="qty" value="<?php echo $row['quantity']; ?>" min="1" max="99" maxlength="2">
            <button type="submit" class="fas fa-edit" name="update_qty"></button>
         </div>
         <div class="sub-total"> sub total : <span>$<?php echo $sub_total = ($row['price'] * $row['quantity']); ?>/-</span> </div>
      </form>
      <?php
               $grand_total += $sub_total;
            }
         }else{
            echo '<p class="empty">your cart is empty</p>';
         }
      ?>

   </div>

   <div class="cart-total">
      <p>cart total : <span>$<?= $grand_total; ?></span></p>
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
   </div>

   <div class="more-btn">
      <form action="" method="post">
         <button type="submit" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" name="delete_all" onclick="return confirm('delete all from cart?');">delete all</button>
      </form>
      <a href="index.php" class="btn">continue shopping</a>
   </div>

</section>

</body>
</html>
