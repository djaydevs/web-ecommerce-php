<header class="header">
    <div class="nav-wrapper">
        <a href="./" class="logo">
            <i class="fa-solid fa-burger fa-2xl" style="color: #f1a409;"></i>
            <span>BURPGER</span>
        </a>
        <nav class="primary-navigation">
            <ul class="nav-list">
                <li><span class="btn transition icons | material-icons-outlined md-40" id="close-btn">highlight_off</span></li>
                <li><a class="transition" href="./">Home</a></li>
                <li><a class="transition" href="">About</a></li>
                <li><a class="transition" href="./#menu">Menu</a></li>
                <li><a class="transition" href="./user_orders.php">Orders</a></li>
                <li><a class="transition" href="./#contacts">Contacts</a></li>
            </ul>
        </nav>
        <div class="icons-container">
            <!-- Get the number of products added in cart -->
            <?php
            $count_cart_items = mysqli_prepare($conn, "SELECT * FROM `cart` WHERE user_id = ?");
            mysqli_stmt_bind_param($count_cart_items, "s", $user_id);
            mysqli_stmt_execute($count_cart_items);
            mysqli_stmt_store_result($count_cart_items);
            $total_cart_items = mysqli_stmt_num_rows($count_cart_items);
            ?>
            <ul class="nav-list-icons">
                <li>
                    <a class="transition" href="search_products.php">
                        <span class="icons | material-icons-outlined md-30">search</span>
                    </a>
                </li>
                <li>
                    <a class="transition" href="cart.php">
                        <span class="icons | material-icons-outlined md-30">shopping_cart</span>
                        <span id="cart-counter">(<?= $total_cart_items; ?>)</span>
                    </a>
                </li>
                <li><span class="btn transition icons | material-icons-outlined md-30" id="btn-account">account_circle</span></li>
                <li><span class="btn transition icons | material-icons-outlined md-30" id="menu-btn">menu</span></li>
            </ul>
        </div>
        <!-- <button class="button">Log In</button> -->
    </div>
</header>
<!-- Condition for profile -->
<div class="profile" id="profile">
    <?php
    $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
    $select_profile->bind_param("i", $user_id);
    $select_profile->execute();
    $result = $select_profile->get_result();
    if ($result->num_rows > 0) {
        $fetch_profile = $result->fetch_assoc();
    ?>
        <p class="name"><?= $fetch_profile['name']; ?></p>
        <div class="flex">
            <a href="user_profile.php" class="btn-profile">Profile</a>
            <a href="user_logout.php" onclick="return confirm('Are you sure you want to logout ?');" class="delete-btn">Logout</a>
        </div>
    <?php
    } else {
    ?>
        <button id="login" class="btn transition primary-btn">Login</button>
        <p>or</p>
        <button id="signup" class="btn transition secondary-btn">Sign Up</button>
    <?php
    }
    $select_profile->close();
    ?>
</div>