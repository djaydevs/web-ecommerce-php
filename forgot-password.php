<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

session_start();
require 'components/connection.php';
$message = "";

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

if (isset($_POST['send'])) {
    $email = $email = mysqli_real_escape_string($conn, $_POST['email']);
    $code = mysqli_real_escape_string($conn, md5(rand()));

    // Check if the email exists in the 'users' table
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'")) > 0) {
        $query = mysqli_query($conn, "UPDATE users SET code='{$code}' WHERE email='{$email}'");

        if ($query) {
            echo "<div style='display: none;'>";
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'ecommerceproj123@gmail.com';                     //SMTP username
                $mail->Password   = 'fqeaonapepmnwpjp';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('ecommerceproj123@gmail.com');
                $mail->addAddress($email);

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'no reply';
                $mail->Body    = 'Here is the verification link  <b><a href="http://localhost/web-ecommerce-php/change-password.php?reset=' . $code . '">http://localhost/web-ecommerce-php/change-password.php??reset=' . $code . '</a></b>';

                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            // Display a message that verification link is sent
            echo "</div>";
            $message = "<div class='alert alert-info'>We've send a verification link on your email address.</div>";
        }
    } else {
        // Display an error message that the email address is not registered
        $message = "<div class='alert alert-danger'>$email - This email address is not registered !</div>";
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
    <title>Forgot Password</title>
    <link rel="stylesheet" href="styles/forms.css" type="text/css" media="all" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
</head>

<body>
    <section class="form-section } padding-block-80">
        <div class="grid-container">
            <!-- Forgot password form -->
            <div class="form-logo">
                <a href="./" class="transition logo">
                    <i class="fa-solid fa-burger fa-2xl" style="color: #f1a409;"></i>
                    <span class="fw-black">BURPGER</span>
                </a>
            </div>
            <div class="form-content | flow">
                <h2 class="fs-secondary-heading fw-semi-bold">Forgot Password</h2>
                <?php echo $message; ?>
                <form action="" method="post">
                    <div class="inputs">
                        <label class="fw-medium" for="email">Email</label>
                        <input type="email" class="email" name="email" placeholder="some@example.com" required>
                    </div>
                    <button name="send" class="btn transition primary-btn" type="submit">Send Reset Link</button>
                </form>
                <p>Back to <a class="transition fw-medium" href="login.php">Login</a></p>
            </div>
            <!-- End of form -->
        </div>
    </section>
    </script>
</body>

</html>