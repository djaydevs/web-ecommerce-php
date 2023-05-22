<?php 
    session_start();
    require 'components/connection.php';
    $message ="";

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
    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>
</head>
<body>
    <section class="form-section">
        <div class ="container">
            <!-- Change password form -->
            <div class="form-grid">
                <div class="main">
                    <div class="content">
                    <h2>Change Password</h2>
                        <?php echo $message; ?>
                        <form action="" method="post">
                            <input type="password" class="password" name="password" placeholder="Enter Your Password" required>
                            <input type="password" class="confirm-password" name="confirm-password" placeholder="Enter Your Confirm Password" required>
                            <button name="change" class="btn" type="submit">Change Password</button>
                        </form>
                        <div class="intent">
                            <p>Back to! <a href="index.php">Login</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of form -->
        </div>
    </section>   
</body>
</html>