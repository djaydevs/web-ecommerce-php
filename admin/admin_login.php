<?php
    session_start();
    require '../components/connection.php';
    $message ="";

    if(isset($_POST['login'] )){
        
        //Validate the data
        function validate($data){
            $data = trim($data);
            $data = stripcslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $username = validate($_POST['username']);
        $password = validate($_POST['password']);

        $sqlSelect = "SELECT * FROM admin WHERE username='{$username }' AND password='{$password}'";
        $result = mysqli_query($conn, $sqlSelect);

        //Check if the inputed username and password exist
        if(mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
                header("Location: home.php");
                exit();
            } else{
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
    <link rel="stylesheet" href="../styles/forms.css"/>
    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <style>
        .form-section button {
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <section class="form-section">
        <div class ="container">
            <!-- Admin login form -->
            <div class="form-grid">
                <div class="main">
                    <div class="content">
                        <h2>Admin Login</h2>
                        <?php echo $message; ?>
                        <form action="" method="post">
                        <input type="text" class="username" name="username" placeholder="Enter Your Username" required>
                        <input type="password" class="password" name="password" placeholder="Enter Your Password" style="margin-bottom: 2px;" required>
                        <button name="login" class="btn" type="submit">Login</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End of form -->
        </div>
    </section>    
</body>
</html>