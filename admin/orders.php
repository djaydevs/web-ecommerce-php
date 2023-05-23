<?php

    require '../components/connection.php';
    // Check if session is already active before staring new session
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $admin_id = $_SESSION['admin_id'];
    if (!isset($admin_id)) {
        header('location: admin_login.php');
    };
    //Update orders payment status
    if (isset($_POST['update_payment'])) {

        $order_id = $_POST['order_id'];
        $payment_status = $_POST['payment_status'];
        $update_status = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
        $update_status->execute([$payment_status, $order_id]);
        $message[] = 'Payment status updated!';
    }
    //Delete orders
    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
        $delete_order->execute([$delete_id]);
        $message = 'Order successfully deleted!';
        header('location: home.php?display=orders&message=' . urlencode($message));
        exit();
    }
    // Alert message
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
            <div class="message">
                <span>' . $message . '</span>
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
    //Bring the alert message after redirecting page
    if (isset($_GET['message'])) {
        $message = $_GET['message'];
        echo '
        <div class="message">
            <span>' . $message . '</span>
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/admin_orders.css ?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <p id="p-order">Orders</p>
    <section class="placed-orders">
        <div class="box-container">
            <!-- Get data to database orders to display in admin -->
            <?php
            $select_orders = $conn->prepare("SELECT * FROM `orders`");
            $select_orders->execute();
            $result = $select_orders->get_result();

            if ($result->num_rows > 0) {
                while ($fetch_orders = $result->fetch_assoc()) {
            ?>
                    <div class="box">
                        <p> User id: <span><?= $fetch_orders['user_id']; ?></span> </p>
                        <p> Placed on: <span><?= $fetch_orders['placed_on']; ?></span> </p>
                        <p> Name: <span><?= $fetch_orders['name']; ?></span> </p>
                        <p> Email: <span><?= $fetch_orders['email']; ?></span> </p>
                        <p> Number: <span><?= $fetch_orders['number']; ?></span> </p>
                        <p> Address: <span><?= $fetch_orders['address']; ?></span> </p>
                        <p> Total products: <span><?= $fetch_orders['total_products']; ?></span> </p>
                        <p> Total price: <span>&#8369;<?= $fetch_orders['total_price']; ?>/-</span> </p>
                        <p> Payment method: <span><?= $fetch_orders['method']; ?></span> </p>
                        <form action="" method="POST">
                            <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                            <select name="payment_status" class="drop-down">
                            <option value="" selected disabled><?= $fetch_orders['payment_status']; ?></option>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                            </select>
                            <div class="flex-btn">
                                <input type="submit" value="update" class="btnn" name="update_payment">
                                <a href="orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Delete this order?');">delete</a>
                            </div>
                        </form>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">No orders placed yet!</p>';
            }
            $conn->close();
            ?>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            // Function to fetch new orders and update the DOM
            function fetchOrders() {
                $.ajax({
                    // Path to a new PHP file for fetching orders
                    url: 'fetch_orders.php',
                    method: 'POST',
                    success: function(response) {
                        $('.box-container').html(response);
                    }
                });
            }
            // Load orders every 5 seconds
            setInterval(fetchOrders, 5000);
        });
    </script>
</body>

</html>