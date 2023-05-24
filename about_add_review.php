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
    
        if($user_id != ''){
    
        $id = create_unique_id();
        $title = $_POST['title'];
        $title = filter_var($title, FILTER_SANITIZE_STRING);
        $description = $_POST['description'];
        $description = filter_var($description, FILTER_SANITIZE_STRING);
        $rating = $_POST['rating'];
        $rating = filter_var($rating, FILTER_SANITIZE_STRING);
    
        $verify_review = $conn->prepare("SELECT * FROM `reviews` WHERE post_id = ? AND user_id = ?");
        $verify_review->bind_param("ii", $get_id, $user_id);
        $verify_review->execute();
        $verify_review_result = $verify_review->get_result();
    
        if($verify_review_result->num_rows > 0){
            $warning_msg[] = 'Your review already added!';
        }else{
            $add_review = $conn->prepare("INSERT INTO `reviews`(id, post_id, user_id, rating, title, description) VALUES(?,?,?,?,?,?)");
            $add_review->bind_param("siisss", $id, $get_id, $user_id, $rating, $title, $description);
            $add_review->execute();
            $success_msg[] = 'Review added!';
        }
    
        }else{
        $warning_msg[] = 'Please login first!';
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
            <form action="" method="post">
                <h3>post your review</h3>
                <p class="placeholder">review title <span>*</span></p>
                <input type="text" name="title" required maxlength="50" placeholder="enter review title" class="box">
                <p class="placeholder">review description</p>
                <textarea name="description" class="box" placeholder="enter review description" maxlength="1000" cols="30" rows="10"></textarea>
                <p class="placeholder">review rating <span>*</span></p>
                <select name="rating" class="box" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                    <?php
                    if ($user_id == '') {
                        echo '<script>showAlert();</script>';
                        
                    } else {
                        echo '<input type="submit" value="submit review" name="submit" class="btn-submit">';
                    }
                    ?>
                <a href="about.php?get_id=<?= $get_id; ?>" class="btn-back">go back</a>
            </form>
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