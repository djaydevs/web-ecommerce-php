<header class="header">
    <div class="nav-wrapper">
        <a href="" class="logo">
            <i class="fa-solid fa-burger fa-2xl" style="color: #f1a409;"></i>
            <!-- <img src="../assets/icons/burger-solid.png" alt=""> -->
            <span>BURPGER</span>
        </a>
        <nav class="primary-navigation">
            <ul class="nav-list">
                <li><a href="index.php">Home</a></li>
                <li><a href="">About</a></li>
                <li><a href="">Menu</a></li>
                <li><a href="cart.php">Orders</a></li>
                <li><a href="">Contacts</a></li>
            </ul>
        </nav>
        <div class="icons-container">
            <?php
            $count_cart_items = mysqli_prepare($conn, "SELECT * FROM `cart` WHERE user_id = ?");
            mysqli_stmt_bind_param($count_cart_items, "s", $user_id);
            mysqli_stmt_execute($count_cart_items);
            mysqli_stmt_store_result($count_cart_items);
            $total_cart_items = mysqli_stmt_num_rows($count_cart_items);
            ?>
            <ul class="nav-list-icons">
                <li>
                    <a href="">
                        <span class="icons | material-icons-outlined md-30">search</span>
                    </a>
                </li>
                <li>
                    <a href="cart.php">
                        <span class="icons | material-icons-outlined md-30">shopping_cart</span>
                        <span id="cart-counter">(<?= $total_cart_items; ?>)</span>
                    </a>
                </li>
                <li>
                    <button class="btn" id="btn-account">
                        <span class="icons | material-icons-outlined md-30">account_circle</span>
                    </button>
                </li>
            </ul>
        </div>
        <!-- <button class="button">Log In</button> -->
    </div>
</header>

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
            <a href="user_profile" class="btn-profile">Profile</a>
            <a href="user_logout.php" onclick="return confirm('Are you sure you want to logout ?');" class="delete-btn">Logout</a>
        </div>
    <?php
    } else {
    ?>
        <button id="login" class="button">Login</button>
        <p>or</p>
        <button id="signup" class="button">Sign Up</button>
    <?php
    }
    $select_profile->close();
    ?>
</div>