<?php
session_start();
require '../components/connection.php';
$message = "";

if (isset($_POST['login'])) {

    //Validate the data
    function validate($data)
    {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_POST['username']);
    $password = validate($_POST['password']);

    $sqlSelect = "SELECT * FROM admin WHERE username='{$username}' AND password='{$password}'";
    $result = mysqli_query($conn, $sqlSelect);

    //Check if the inputed username and password exist
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['admin_id'] = $row['id'];
        $_SESSION['cafe_db'] = 'true';
        header("Location: home.php");
        exit();
    } else {
        // Display an error message if the username or password is incorrect
        $message = "<div class='alert alert-danger'>Incorrect Username or Password !</div>";
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
    <title>Admin Login</title>
    <link rel="stylesheet" href="../styles/forms.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
</head>

<body>
    <section class="form-section | padding-block-80">
        <div class="grid-container">
            <!-- Admin login form -->
            <div class="adminform-logo">
                <a href="./" class="transition logo">
                    <i class="fa-solid fa-burger fa-2xl" style="color: #f1a409;"></i>
                    <span class="fw-black">BURPGER</span><span style="color: #e74d3c">Admin</span>
                </a>
            </div>
            <div class="form-content | flow">
                <h2 class="fs-secondary-heading fw-semi-bold">Login</h2>
                <?php echo $message; ?>
                <form action="" method="post">
                    <div class="inputs">
                        <label class="fw-medium" for="username">Username</label>
                        <input type="text" class="username" name="username" placeholder="username" required>
                    </div>
                    <div class="inputs">
                        <label class="fw-medium" for="password">Password</label>
                        <input type="password" class="password" name="password" placeholder="6 or more characters" required>
                    </div>
                    <button name="login" class="btn transition primary-btn" type="submit">Login</button>
                </form>
            </div>
        </div>
        <!-- End of form -->
        </div>
    </section>
</body>

</html>