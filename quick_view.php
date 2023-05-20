<?php

    include 'components/connection.php';

    session_start();

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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="./styles/styles.css ?v=<?php echo time(); ?>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js" integrity="sha512-gmwBmiTVER57N3jYS3LinA9eb8aHrJua5iQD7yqYCKa5x6Jjc7VDVaEA0je0Lu0bP9j7tEjV3+1qUm6loO99Kw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>BURPGER</title>
</head>
<body>

<div class="loading-page">
    <svg id="loading-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M61.1 224C45 224 32 211 32 194.9c0-1.9 .2-3.7 .6-5.6C37.9 168.3 78.8 32 256 32s218.1 136.3 223.4 157.3c.5 1.9 .6 3.7 .6 5.6c0 16.1-13 29.1-29.1 29.1H61.1zM144 128a16 16 0 1 0 -32 0 16 16 0 1 0 32 0zm240 16a16 16 0 1 0 0-32 16 16 0 1 0 0 32zM272 96a16 16 0 1 0 -32 0 16 16 0 1 0 32 0zM16 304c0-26.5 21.5-48 48-48H448c26.5 0 48 21.5 48 48s-21.5 48-48 48H64c-26.5 0-48-21.5-48-48zm16 96c0-8.8 7.2-16 16-16H464c8.8 0 16 7.2 16 16v16c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V400z"/></svg>
</div>

<?php include 'components/main_header.php'; ?>

<section class="quick-view">

    <h1 class="title">Quick View</h1>

    <?php
         $view = $_GET['pid'];
         $query = "SELECT * FROM products WHERE product_ID = '$view'";
         $res=mysqli_query($conn, $query);
         if(mysqli_num_rows($res) > 0){
            while($row = $res->fetch_assoc()) {
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="pid" value="<?php echo $row['product_ID']; ?>">
         <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
         <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
         <input type="hidden" name="image" value="<?php echo $row['image']; ?>">
         <img src = "./assets/images/<?php echo $row['image']; ?>" alt="">
         <a href="category.php?category=<?php echo $row['category']; ?>" class="cat"><?php echo $row['category']; ?></a>
         <div class="name"><?php echo $row['name']; ?></div>
         <div class="details"><?php echo $row['description']; ?></div>
         <div class="flex">
            <div class="price"><span>$</span><?php echo $row['price']; ?></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="0" maxlength="2">

            <script>
                document.querySelectorAll('input[type="number"]').forEach(numberInput => {numberInput.oninput = () =>{
                    if(numberInput.value.length > numberInput.maxLength) numberInput.value = numberInput.value.slice(0, numberInput.maxLength);
                    };
                }); 
            </script>
         </div>
         <button type="submit" name="add_to_cart" class="btn-add-to-cart">Add to cart</button>
      </form>
      <?php
            }
         }else{
            echo '<p class="empty">no products found!</p>';
         }
    ?>


   <!-- <div class="more-btn">
      <a href="menu.html" class="btn">veiw all</a>
   </div> -->

</section>

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

</body>
</html>