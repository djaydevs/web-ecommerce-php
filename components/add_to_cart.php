<?php 

    if(isset($_POST['add_to_cart'])) {

        if($user_id == '') {
            header('location:login.php');
        } else {

            $prodID = mysqli_real_escape_string($conn, $_POST['pid']);
            $prodName = mysqli_real_escape_string($conn, $_POST['name']);
            $price = mysqli_real_escape_string($conn, $_POST['price']);
            $image = mysqli_real_escape_string($conn, $_POST['image']);
            $qty = mysqli_real_escape_string($conn, $_POST['qty']);

            $check = "SELECT * FROM cart WHERE user_id = '$user_id' AND name = '$prodName'";
            $result = mysqli_query($conn, $check);

            if(mysqli_num_rows($result) > 0) {
                $message[] = 'already added to cart!';
            } else {

                $add = "INSERT INTO cart (user_id, pid, name, price, quantity, image) VALUES ('$user_id', '$prodID', '$prodName', '$price', '$qty', '$image')";
                $insertQuery = mysqli_query($conn, $add);
                $message[] = "Already add to cart!";
            }
        }
    }

    # ALERT MESSAGE ON THE HEADER

    if(isset($message)){
        foreach($message as $message){
        echo '
        <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
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

