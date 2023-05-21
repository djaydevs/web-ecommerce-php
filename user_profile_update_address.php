<?php

include 'components/connection.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
 }else{
    $user_id = '';
    header('location:home.php');
 };
 
 if(isset($_POST['submit'])){
 
    $address = $_POST['house_no'] .', '.$_POST['street'].', '.$_POST['barangay'].', '.$_POST['city'] .' - '. $_POST['zip_code'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
 
    $update_address = $conn->prepare("UPDATE `users` set address = ? WHERE id = ?");
    $update_address->execute([$address, $user_id]);
 
    $message[] = 'address saved!';
 
 }

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

    <section class="form-container">

        <form action="" method="post">
            <h3>your address</h3>
            <input type="text" class="box" placeholder="house no." required maxlength="50" name="house_no">
            <input type="text" class="box" placeholder="street" required maxlength="50" name="street">
            <input type="text" class="box" placeholder="barangay" required maxlength="50" name="barangay">
            <input type="text" class="box" placeholder="city name" required maxlength="50" name="city">
            <input type="text" class="box" placeholder="province" required maxlength="50" name="province">
            <input type="number" class="box" placeholder="zip code" required max="999999" min="0" maxlength="6" name="zip_code">
            <input type="submit" value="save address" name="submit" class="btn-profile">
        </form>
    </section>

    <script>
        gsap.fromTo(
            ".main-container", {
                opacity: 0,
                display: "none"
            }, {
                opacity: 1,
                duration: 1,
                delay: 1.3,
                display: "block"
            }
        );
    </script>
    <script src="./js/script.js"></script>
</body>

</html>