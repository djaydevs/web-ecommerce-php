<?php

include 'components/connection.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
 
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
 
    if(!empty($name)){
       $update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
       $update_name->execute([$name, $user_id]);
    }
 
    if (!empty($email)) {
        $select_email = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
        $select_email->bind_param("s", $email); // Bind the parameter
        $select_email->execute();
        $result_email = $select_email->get_result(); // Get the result set
        if ($result_email->num_rows > 0) {
           $message[] = 'email already taken!';
        } else {
           $update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
           $update_email->bind_param("si", $email, $user_id); // Bind the parameters
           $update_email->execute();
        }
        $select_email->close(); // Close the statement
    }
     
    if (!empty($number)) {
        $select_number = $conn->prepare("SELECT * FROM `users` WHERE number = ?");
        $select_number->bind_param("s", $number); // Bind the parameter
        $select_number->execute();
        $result_number = $select_number->get_result(); // Get the result set
        if ($result_number->num_rows > 0) {
           $message[] = 'number already taken!';
        } else {
           $update_number = $conn->prepare("UPDATE `users` SET number = ? WHERE id = ?");
           $update_number->bind_param("si", $number, $user_id); // Bind the parameters
           $update_number->execute();
        }
        $select_number->close(); // Close the statement
    }

    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';

    $select_prev_pass = $conn->prepare("SELECT password FROM `users` WHERE id = ?");
    $select_prev_pass->bind_param("i", $user_id);
    $select_prev_pass->execute();
    $result_prev_pass = $select_prev_pass->get_result();
    $fetch_prev_pass = $result_prev_pass->fetch_assoc();
    $prev_pass = $fetch_prev_pass['password'];

    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];

    if (!empty($old_pass)) {
        if (md5($old_pass) === $prev_pass) {
            if ($new_pass === $confirm_pass) {
                if (!empty($new_pass)) {
                    $hashed_pass = md5($new_pass); // Hash the new password
                    $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
                    $update_pass->bind_param("si", $hashed_pass, $user_id);
                    $update_pass->execute();
                    $message[] = 'Password updated successfully!';
                } else {
                    $message[] = 'Please enter a new password!';
                }
            } else {
                $message[] = 'Confirm password does not match!';
            }
        } else {
            $message[] = 'Old password does not match!';
        }
    }

    $select_prev_pass->close();
    
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

    <section class="form-container update-form">
        <form action="" method="post">
            <h3>update profile</h3>
            <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" class="box" maxlength="50">
            <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="number" name="number" placeholder="<?= $fetch_profile['number']; ?>"" class="box" min="0" max="9999999999" maxlength="10">
            <input type="password" name="old_pass" placeholder="enter your old password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="new_pass" placeholder="enter your new password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="confirm_pass" placeholder="confirm your new password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="update now" name="submit" class="btn-profile">
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