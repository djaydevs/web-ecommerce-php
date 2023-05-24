<?php
session_start();
require 'components/connection.php';
$message = "";

if (isset($_GET['reset'])) {
    // Check if there is a user with the provided reset code
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE code='{$_GET['reset']}'")) > 0) {

        // Check if the form to change the password has been submitted
        if (isset($_POST['change'])) {
            $password = mysqli_real_escape_string($conn, md5($_POST['password']));
            $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));

            // Check if the new password matches the confirmed password
            if ($password === $confirm_password) {

                // Update the user's password and clear the reset code
                $query = mysqli_query($conn, "UPDATE users SET password='{$password}', code='' WHERE code='{$_GET['reset']}'");

                if ($query) {
                    header("Location: login.php");
                }
            } else {

                // Display an error message if the passwords do not match
                $message = "<div class='alert alert-danger'>Password do not match !</div>";
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
    } else {
        // Display an error message if the reset link does not match any user
        $message = "<div class='alert alert-danger'>Reset Link do not match !</div>";
        echo "<script>
                    setTimeout(function() {
                        var messageElement = document.querySelector('.alert-danger');
                        if (messageElement) {
                            messageElement.style.display = 'none';
                        }
                    }, 10000);
                </script>";
    }
} else {

    // Redirect to the forgot password page if the reset parameter is not set
    header("Location: forgot-password.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="styles/forms.css" type="text/css" media="all" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
</head>

<body>
    <section class="form-section | padding-block-80">
        <div class="grid-container">
            <!-- Change password form -->
            <div class="form-logo">
                <a href="./" class="transition logo">
                    <i class="fa-solid fa-burger fa-2xl" style="color: #f1a409;"></i>
                    <span class="fw-black">BURPGER</span>
                </a>
            </div>
            <div class="form-content | flow">
                <h2 class="fs-third-heading fw-semi-bold">Change Password</h2>
                <?php echo $message; ?>
                <form action="" method="post">
                    <div class="inputs">
                        <label class="fw-medium" for="password">Password</label>
                        <input type="password" class="password" name="password" placeholder="6 or more characters" required>
                    </div>
                    <div class="inputs">
                        <label class="fw-medium" for="confirm-password">Confirm Password</label>
                        <input type="password" class="confirm-password" name="confirm-password" placeholder="Repeat password" required>
                    </div>
                    <button name="change" class="btn transition primary-btn" type="submit">Change Password</button>
                </form>
                <p>Back to <a class="transition fw-medium" href="index.php">Login</a></p>
            </div>
            <!-- End of form -->
        </div>
    </section>
    <script>
        $(document).ready(function() {
            $('[title="Hosted on free web hosting 000webhost.com. Host your own website for FREE."]').hide();
        });
    </script>
</body>

</html>