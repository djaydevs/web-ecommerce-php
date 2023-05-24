<?php

    session_start();
    include 'components/connection.php';

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        $user_id = '';
    };

    function create_unique_id() {
        // Generate a unique ID using a preferred method, such as UUID or timestamp-based ID
        // Here's an example using a timestamp-based ID
        $id = uniqid();
        return $id;
    }

    if(isset($_GET['get_id'])){
        $get_id = $_GET['get_id'];
    }else{
        $get_id = '';
    }
    
    if(isset($_POST['submit'])){

        $title = $_POST['title'];
        $title = filter_var($title, FILTER_SANITIZE_STRING);
        $description = $_POST['description'];
        $description = filter_var($description, FILTER_SANITIZE_STRING);
        $rating = $_POST['rating'];
        $rating = filter_var($rating, FILTER_SANITIZE_STRING);
    
        $update_review = $conn->prepare("UPDATE `reviews` SET rating = ?, title = ?, description = ? WHERE id = ?");
        $update_review->bind_param("ssss", $rating, $title, $description, $get_id);
        $update_review->execute();

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/8eb0534a39.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js" integrity="sha512-gmwBmiTVER57N3jYS3LinA9eb8aHrJua5iQD7yqYCKa5x6Jjc7VDVaEA0je0Lu0bP9j7tEjV3+1qUm6loO99Kw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>BURPGER</title>
</head>

<body>
    <?php include 'components/loading.php'; ?>
    <div class="main-container">
        <?php include 'components/main_header.php'; ?>

        <section class="account-form">

            <?php
                $select_review = $conn->prepare("SELECT * FROM `reviews` WHERE id = ? LIMIT 1");
                $select_review->bind_param("s", $get_id);
                $select_review->execute();
                $select_review_result = $select_review->get_result();
                
                if($select_review_result->num_rows > 0){
                    while($fetch_review = $select_review_result->fetch_assoc()){
            ?>
            <form action="" method="post">
                <h3>edit your review</h3>
                <p class="placeholder">review title <span>*</span></p>
                <input type="text" name="title" required maxlength="50" placeholder="enter review title" class="box" value="<?= $fetch_review['title']; ?>">
                <p class="placeholder">review description</p>
                <textarea name="description" class="box" placeholder="enter review description" maxlength="1000" cols="30" rows="10"><?= $fetch_review['description']; ?></textarea>
                <p class="placeholder">review rating <span>*</span></p>
                <select name="rating" class="box" required>
                    <option value="<?= $fetch_review['rating']; ?>"><?= $fetch_review['rating']; ?></option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <input type="submit" value="update review" name="submit" class="btn-submit" onclick="showAlert()">
                <a href="about.php?get_id=<?= $fetch_review['post_id']; ?>" class="btn-back">go back</a>
            </form>
            <?php
                    }
                }else{
                    echo '<p class="empty">something went wrong!</p>';
                }
            ?>

        </section>


    </div>

    <script src="./js/main-container.js"></script>
    <script src="./js/script.js"></script>
    <script>
        function showAlert() {
        alert('Review updated!');
        }
    </script>
</body>
</html>