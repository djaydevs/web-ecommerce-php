<?php 

     if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include '../components/connection.php';

    $admin_id = $_SESSION['admin_id'];
    if (!isset($admin_id)) {
    header('location:admin_login.php');
    };
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/admin_dashboard.css ?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <section class="dashboard">
    <h1 class="heading">dashboard</h1>

    <div class="box-container">
        <!-- PENDING ORDER -->
        <div class="box">
            <?php
                $total_pendings = 0;
                $select_pendings = "SELECT * FROM `orders` WHERE payment_status = 'pending'";
                $pending = mysqli_query($conn, $select_pendings);
                while($fetch_pendings = $pending->fetch_assoc()){
                    $total_pendings += $fetch_pendings['total_price'];
                }
            ?>
            <h3><span>$</span><?= $total_pendings; ?><span>/-</span></h3>
            <p>total pendings</p>
            <a href="orders.php" class="btn">see orders</a>
        </div>

        <!-- COMPLETED ORDER -->
        <div class="box">
            <?php
                $total_completes = 0;
                $select_completes = "SELECT * FROM `orders` WHERE payment_status = 'completed'";
                $complete = mysqli_query($conn, $select_completes);
                while($fetch_completes = $complete->fetch_assoc()){
                    $total_completes += $fetch_completes['total_price'];
                }
            ?>
            <h3><span>$</span><?= $total_completes; ?><span>/-</span></h3>
            <p>total completes</p>
            <a href="orders.php" class="btn">see orders</a>
        </div>

        <!-- NO. OF ORDER -->
        <div class="box">
            <?php
                $select_orders = "SELECT * FROM `orders`";
                $orders = mysqli_query($conn, $select_orders);
                $numbers_of_orders = mysqli_num_rows($orders);
            ?>
            <h3><?= $numbers_of_orders; ?></h3>
            <p>total orders</p>
            <a href="orders.php" class="btn">see orders</a>
        </div>

        <!-- NO. OF PRODUCTS -->
        <div class="box">
            <?php
                $select_products = "SELECT * FROM `products`";
                $products = mysqli_query($conn, $select_products);
                $numbers_of_products = mysqli_num_rows($products);
            ?>
            <h3><?= $numbers_of_products; ?></h3>
            <p>products added</p>
            <a href="products.php" class="btn">see products</a>
        </div>

        <!-- NO. OF CUSTOMER ACCOUNT -->
        <div class="box">
            <?php
                $select_users = "SELECT * FROM `users`";
                $users = mysqli_query($conn, $select_users);
                $numbers_of_users = mysqli_num_rows($users);
            ?>
            <h3><?= $numbers_of_users; ?></h3>
            <p>users accounts</p>
            <a href="customer_account.php" class="btn">see users</a>
        </div>
    </div>
    </section>
</body>
</html>