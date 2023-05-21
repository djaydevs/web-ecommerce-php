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

    <section class="user-profile">
        <div class="box">
            <img src="assets/images/profile.png" alt="" width="100">
            <p><i class=""><img src="assets/images/user.png" alt="" width="15"><span><?=$fetch_profile['name']?></span></i></p>
            <p><i class=""><img src="assets/images/email.png" alt="" width="15"><span><?=$fetch_profile['email']?></span></i></p>
            <p><i class=""><img src="assets/images/phone-call.png" alt="" width="15"><span><?=$fetch_profile['number']?></span></i></p>
            <a href="user_profile_update_profile.php" class="btn-profile">update info</a>
            <p><i class=""><img src="assets/images/pin.png" alt="" width="15"><span><?php if($fetch_profile['address'] == ''){echo 'please enter your address..';}else{echo $fetch_profile['address'];}?></span></i></p>
            <a href="user_profile_update_address.php" class="btn-profile">update address</a>
        </div>
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