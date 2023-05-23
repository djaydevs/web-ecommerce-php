<?php
session_start();
require 'components/connection.php';
$message = "";

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

if (isset($_GET['verification'])) {
    // Check if the code exists in the 'users' table
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE code='{$_GET['verification']}'")) > 0) {

        // Update the 'code' column in the 'users' table
        $query = mysqli_query($conn, "UPDATE users SET code='' WHERE code='{$_GET['verification']}'");

        if ($query) {
            $message = "<div class='alert alert-success'>Account verification has been successfully completed!</div>";
            echo "<script>
                    setTimeout(function() {
                        var messageElement = document.querySelector('.alert-success');
                        if (messageElement) {
                            messageElement.style.display = 'none';
                        }
                    }, 10000);
                  </script>";
        }
    } else {
        // Redirect to the login page if the code does not exist
        header("Location: login.php");
    }
}

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    $sqlSelect = "SELECT * FROM users WHERE email='{$email}' AND password='{$password}'";
    $result = mysqli_query($conn, $sqlSelect);

    // Check if the user exists and the account is verified
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // Set the session variable and redirect to the home page
        if (empty($row['code'])) {
            $_SESSION['user_id'] = $row['id'];
            header("Location: index.php");
        } else {
            // Display an error message if the account is not verified
            $message = "<div class='alert alert-info'>Verifiy your account first !</div>";
            echo "<script>
                    setTimeout(function() {
                        var messageElement = document.querySelector('.alert-info');
                        if (messageElement) {
                            messageElement.style.display = 'none';
                        }
                    }, 10000);
                  </script>";
        }
    } else {
        // Display an error message if the Email and password do not match
        $message = "<div class='alert alert-danger'>Email or password do not match !</div>";
        echo "<script>
                setTimeout(function() {
                    var messageElement = document.querySelector('.alert-danger');
                    if (messageElement) {
                        messageElement.style.display = 'none';
                    }
                }, 10000);
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles/forms.css" type="text/css" media="all" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</head>

<body>
    <section class="form-section | padding-block-80">
        <div class="grid-container">
            <!-- Login form -->
            <div class="form-logo">
                <a href="./" class="transition logo">
                    <i class="fa-solid fa-burger fa-2xl" style="color: #f1a409;"></i>
                    <span class="fw-black">BURPGER</span>
                </a>
            </div>
            <div class="form-content | flow">
                <h2 class="fs-secondary-heading fw-semi-bold">Login</h2>
                <?php echo $message; ?>
                <form action="" method="post">
                    <div class="inputs">
                        <label class="fw-medium" for="email">Email</label>
                        <input type="email" class="email" name="email" placeholder="some@example.com" required>
                    </div>
                    <div class="inputs">
                        <label class="fw-medium" for="password">Password</label>
                        <input type="password" class="password" name="password" placeholder="6 characters or more" required>
                        <p><a class="transition fw-medium" href="forgot-password.php">Forgot Password?</a></p>
                    </div>
                    <button name="login" class="btn transition primary-btn" type="submit">Login</button>
                </form>
                <p>No account yet? <a class="transition fw-medium" href="register.php">Sign up</a></p>
            </div>
            <!-- End of form -->
        </div>
    </section>
    <script src="./js/main-container.js"></script>
    <script src="./js/script.js"></script>
</body>

</html>