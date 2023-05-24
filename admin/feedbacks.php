<?php

require '../components/connection.php';

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
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/admin_feedbacks.css ?v=<?php echo time(); ?>">
    <title>Admin - Feedbacks</title>
</head>
<body>
<section class="reviews-container">

    <div class="heading">
        <h1>Feedbacks</h1>
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
        <?php { ?>
            <form action="" method="post" class="flex-btn">
                <input type="hidden" name="delete_id" value="<?= $fetch_review['id']; ?>">
                <input type="submit" value="Delete Review" class="delete-btn" name="delete_review" onclick="return confirm('Delete this review?');">
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
</body>
</html>