<?php 
    include 'components/connection.php';

    # IF BUTTON IS CLICKED
    if(isset($_POST['send'])) {

        $message[] = "Message Sent! Thank you for contacting us.";
    }

    # ALERT MESSAGE

    if (isset($message)) {
        foreach ($message as $message) {
        echo '
            <div class="message">
                <span class="fw-medium">' . $message . '</span>
            </div>
            <script>
            setTimeout(function() {
                var messages = document.getElementsByClassName("message");
                while (messages[0]) {
                    messages[0].remove();
                }
            }, 5000); // 5 seconds
            </script>
            ';
        }
    }
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
        <main>
            <section class="contact">
                <div class="row">
                    <div class="image">
                        <img src="./assets/images/contact.jpg" alt="">
                        <div class="info">
                            <div class="information">
                            <img src="./assets/images/location.png" class="icon" alt="" />
                            <p>124 Bikini Bottom,  Cronch St.</p>
                            </div>
                            <div class="information">
                            <img src="./assets/images/mail.png" class="icon" alt="" />
                            <p>lorem@ipsum.com</p>
                            </div>
                            <div class="information">
                            <img src="./assets/images/phone.png" class="icon" alt="" />
                            <p>123-456-789</p>
                            </div>
                        </div>
                    </div>

                    <form action="" method="POST">
                        <h3>Contact Us</h3>
                        <input type="text" name="name" maxlength="50" class="box" placeholder="Your name" required>
                        <input type="email" name="email" maxlength="50" class="box" placeholder="Your email" required>
                        <textarea name="msg" class="box" required placeholder="Your message" maxlength="500" cols="30" rows="10"></textarea>
                        <input type="submit" value="send message" name="send" class="btn">
                    </form>
                </div>
            </section>
        </main>
    </div>
</body>
</html>