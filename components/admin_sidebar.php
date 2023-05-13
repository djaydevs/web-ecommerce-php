<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/admin_sidebar.css">
</head>
<body>
<div class="sidebar">
  <ul>
    <li><a href="../admin/dashboard.php">Dashbaord</a></li>
    <li><a href="../admin/orders.php">Orders</a></li>
    <li><a href="../admin/products.php">Products</a></li>
    <li><a href="../admin/feedbacks.php">Feedbacks</a></li>
    <li><a href="../admin/user_account.php">User Account</a></li>
  </ul>
  <div class="hamburger-menu">
    <div class="bar"></div>
    <div class="bar"></div>
    <div class="bar"></div>
  </div>
</div>
<script>
    const hamburgerMenu = document.querySelector('.hamburger-menu');
    const sidebar = document.querySelector('.sidebar');

    hamburgerMenu.addEventListener('click', () => {
        sidebar.classList.toggle('show');
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('show');
        }
    });
</script>
</body>
</html>