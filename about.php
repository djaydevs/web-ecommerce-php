<?php

include 'components/connection.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
};

if(isset($_POST['delete_review'])){

    $delete_id = $_POST['delete_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_delete = $conn->prepare("SELECT * FROM `reviews` WHERE id = ?");
    $verify_delete->bind_param("s", $delete_id);
    $verify_delete->execute();
    $verify_delete_result = $verify_delete->get_result();
    
    if($verify_delete_result->num_rows > 0){
        $delete_review = $conn->prepare("DELETE FROM `reviews` WHERE id = ?");
        $delete_review->bind_param("s", $delete_id);
        $delete_review->execute();
        $success_msg[] = 'Review deleted!';
    }else{  
        $warning_msg[] = 'Review already deleted!';
    }
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
    <link rel="stylesheet" type="text/css" href="./styles/styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://kit.fontawesome.com/8eb0534a39.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js" integrity="sha512-gmwBmiTVER57N3jYS3LinA9eb8aHrJua5iQD7yqYCKa5x6Jjc7VDVaEA0je0Lu0bP9j7tEjV3+1qUm6loO99Kw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>BURGER</title>
</head>

<body>
    <?php include 'components/loading.php'; ?>
    <div class="main-container">
        <?php include 'components/main_header.php'; ?>

        <section class="view-post">
            <?php
            $select_post = $conn->prepare("SELECT * FROM `posts` WHERE id = ? LIMIT 1");
            $select_post->bind_param("i", $get_id);
            $select_post->execute();
            $result_post = $select_post->get_result();

            $average = 0;
            $total_reviews = 0;
            $rating_1 = 0;
            $rating_2 = 0;
            $rating_3 = 0;
            $rating_4 = 0;
            $rating_5 = 0;

            if ($result_post->num_rows > 0) {
                while ($fetch_post = $result_post->fetch_assoc()) {
                    $total_ratings = 0;
                    $rating_1 = 0;
                    $rating_2 = 0;
                    $rating_3 = 0;
                    $rating_4 = 0;
                    $rating_5 = 0;

                    $select_ratings = $conn->prepare("SELECT * FROM `reviews` WHERE post_id = ?");
                    $select_ratings->bind_param("i", $fetch_post['id']);
                    $select_ratings->execute();
                    $result_ratings = $select_ratings->get_result();
                    $total_reviews = $result_ratings->num_rows;

                    while ($fetch_rating = $result_ratings->fetch_assoc()) {
                        $total_ratings += $fetch_rating['rating'];

                        switch ($fetch_rating['rating']) {
                            case 1:
                                $rating_1 += $fetch_rating['rating'];
                                break;
                            case 2:
                                $rating_2 += $fetch_rating['rating'];
                                break;
                            case 3:
                                $rating_3 += $fetch_rating['rating'];
                                break;
                            case 4:
                                $rating_4 += $fetch_rating['rating'];
                                break;
                            case 5:
                                $rating_5 += $fetch_rating['rating'];
                                break;
                        };
                    };

                    if ($total_reviews != 0) {
                        $average = round($total_ratings / $total_reviews, 1);
                    } else {
                        $average = 0;
                    }
                };
            }
            ?>

            <div class="row">
                <div class="col">
                    <img src="assets/images/cat-combo.png" alt="" class="image">
                    <h3 class="title">BURPGER</h3>
                </div>
                <div class="col">
                    <div class="flex">
                        <div class="total-reviews">
                            <h3><?= $average; ?><i class="fas fa-star"></i></h3>
                            <p><?= $total_reviews; ?> reviews</p>
                        </div>
                        <div class="total-ratings">
                            <p>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span><?= $rating_5; ?></span>
                            </p>
                            <p>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span><?= $rating_4; ?></span>
                            </p>
                            <p>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span><?= $rating_3; ?></span>
                            </p>
                            <p>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span><?= $rating_2; ?></span>
                            </p>
                            <p>
                                <i class="fas fa-star"></i>
                                <span><?= $rating_1; ?></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="reviews-container">

            <div class="heading">
                <h1>user's reviews</h1>
                <a href="about_add_review.php?get_id=<?= $get_id; ?>" class="btn-profile" style="margin-top: 0;">add review</a>
            </div>

            <div class="box-container">

            <?php
                $select_reviews = $conn->prepare("SELECT * FROM `reviews` WHERE post_id = ?");
                $select_reviews->bind_param("i", $get_id);
                $select_reviews->execute();
                $result_reviews = $select_reviews->get_result();
                
                if($result_reviews->num_rows > 0){
                    while($fetch_review = $result_reviews->fetch_assoc()){
            ?>
            <div class="box" <?php if($fetch_review['user_id'] == $user_id){echo 'style="order: -1;"';}; ?>>
                <?php
                    $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                    $select_user->bind_param("i", $fetch_review['user_id']);
                    $select_user->execute();
                    $result_user = $select_user->get_result();
                    
                    while($fetch_user = $result_user->fetch_assoc()){
                ?>
                <div class="user">
                    <?php if(isset($fetch_user['image']) && $fetch_user['image'] != ''){ ?>
                        <img src="uploaded_files/<?= $fetch_user['image']; ?>" alt="">
                    <?php }else{ ?>   
                        <h3><?= substr($fetch_user['name'], 0, 1); ?></h3>
                    <?php }; ?>   
                    <div>
                        <p><?= $fetch_user['name']; ?></p>
                        <span><?= $fetch_review['date']; ?></span>
                    </div>
                </div>
                <?php }; ?>
                <div class="ratings">
                    <?php if($fetch_review['rating'] == 1){ ?>
                        <p style="background:var(--red);"><i class="fas fa-star"></i> <span><?= $fetch_review['rating']; ?></span></p>
                    <?php }; ?> 
                    <?php if($fetch_review['rating'] == 2){ ?>
                        <p style="background:var(--orange);"><i class="fas fa-star"></i> <span><?= $fetch_review['rating']; ?></span></p>
                    <?php }; ?>
                    <?php if($fetch_review['rating'] == 3){ ?>
                        <p style="background:var(--orange);"><i class="fas fa-star"></i> <span><?= $fetch_review['rating']; ?></span></p>
                    <?php }; ?>   
                    <?php if($fetch_review['rating'] == 4){ ?>
                        <p style="background:var(--main-color);"><i class="fas fa-star"></i> <span><?= $fetch_review['rating']; ?></span></p>
                    <?php }; ?>
                    <?php if($fetch_review['rating'] == 5){ ?>
                        <p style="background:var(--main-color);"><i class="fas fa-star"></i> <span><?= $fetch_review['rating']; ?></span></p>
                    <?php }; ?>
                </div>
                <h2 class="title-review"><?= $fetch_review['title']; ?></h2>
                <?php if($fetch_review['description'] != ''){ ?>
                    <p class="description"><?= $fetch_review['description']; ?></p>
                <?php }; ?>  
                <?php if($fetch_review['user_id'] == $user_id){ ?>
                    <form action="" method="post" class="flex-btn">
                        <input type="hidden" name="delete_id" value="<?= $fetch_review['id']; ?>">
                        <a href="about_update_review.php?get_id=<?= $fetch_review['id']; ?>" class="btn-profile">edit review</a>
                        <input type="submit" value="delete review" class="delete-btn" name="delete_review" onclick="return confirm('delete this review?');">
                    </form>
                <?php }; ?>   
            </div>
            <?php
                    }
                }else{
                    echo '<p class="empty">no reviews added yet!</p>';
                }
            ?>

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
    </div>
</body>

</html>
