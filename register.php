<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
session_start();
//Load Composer's autoloader
require 'vendor/autoload.php';


require 'components/connection.php';
$message = "";

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));
    $code = mysqli_real_escape_string($conn, md5(rand()));

    // Check if the email or number already exists in the 'users' table
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}' OR number='{$number}'")) > 0) {
        $message = "<div class='alert alert-danger'>Email or Number already exist !</div>";
        echo "<script>
                    setTimeout(function() {
                        var messageElement = document.querySelector('.alert-danger');
                        if (messageElement) {
                            messageElement.style.display = 'none';
                        }
                    }, 10000);
                </script>";
    } else {
        if ($password === $confirm_password) {
            $sqlInsert = "INSERT INTO users (name, email, number, password, code) VALUES ('{$name}', '{$email}', '{$number}', '{$password}', '{$code}')";
            $result = mysqli_query($conn, $sqlInsert);

            if ($result) {
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
                    $mail->Body    = 'Here is the verification link  <b><a href="https://burpger.000webhostapp.com/login.php?verification=' . $code . '">https://burpger.000webhostapp.com/login.php?verification=' . $code . '</a></b>';
                        https://burpger.000webhostapp.com/web-ecommerce-php/login.php
                    $mail->send();
                    echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                echo "</div>";
                //Display a message that a verification link is send in users email
                $name = '';
                $message = "<div class='alert alert-info'>We've send a verification link on your email address ! </div>";
            } else {
                //Display an error message Somethins is wrong with the page
                $message = "<div class='alert alert-danger'>Something went wrong.</div>";
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
            //Display an error message that the passwords do not match
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
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="styles/forms.css" type="text/css" media="all" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
</head>

<body>
    <section class="form-section | padding-block-50">
        <div class="grid-container">
            <!-- Sign up form-->
            <div class="form-logo">
                <a href="./" class="transition logo">
                    <i class="fa-solid fa-burger fa-2xl" style="color: #f1a409;"></i>
                    <span class="fw-black">BURPGER</span>
                </a>
            </div>
            <div class="form-content2 | flow2">
                <h2 class="fs-secondary-heading fw-semi-bold">Sign Up</h2>
                <?php echo $message; ?>
                <form action="" method="post" id="register-form">
                    <div class="inputs2">
                        <label class="fw-medium" for="name">Name</label>
                        <input type="text" class="name" id="name" name="name" placeholder="Name" value="<?php if (isset($_POST['register'])) {
                                                                                                            echo $name;
                                                                                                        } ?>" required>
                    </div>
                    <div class="inputs2">
                        <label class="fw-medium" for="email">Email</label>
                        <input type="email" class="email" id="email" name="email" placeholder="some@example.com" required>
                    </div>
                    <div class="inputs2">
                        <label class="fw-medium" for="number">Number</label>
                        <input type="number" class="number" name="number" placeholder="0999-123-4567" required>
                    </div>
                    <div class="inputs2">
                        <label class="fw-medium" for="password">Password</label>
                        <input type="password" class="password" name="password" placeholder="Enter your password" required>
                        <input type="password" class="confirm-password" name="confirm-password" placeholder="Confirm your password" required>
                    </div>
                    <div class="g-recaptcha" data-sitekey="6LclezUmAAAAAO5miMn6U4o7Lm9vJXQOFpXog050"></div>
                    <button name="register" class="btn transition primary-btn" id="save" type="submit">Register</button>
                </form>
                <p>Already have an account? <a class="transition fw-medium" href="login.php">Login</a></p>
            </div>
            <!-- End of form -->
        </div>
    </section>
    <!-- Script for captcha -->
    <script>
        $(document).on('click', '#save', function() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                alert("Please verify you are not a robot !");
                return false;
            }
        });
    </script>
    <script src="./js/main-container.js"></script>
    <script src="./js/script.js"></script>
</body>

</html>