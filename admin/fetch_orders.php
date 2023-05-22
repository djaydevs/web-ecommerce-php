<?php

require '../components/connection.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Fetch new orders from the database
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
                        <p> Total price: <span>$<?= $fetch_orders['total_price']; ?>/-</span> </p>
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