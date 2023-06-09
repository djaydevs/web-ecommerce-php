<?php
session_start();

if (!isset($_SESSION['cafe_db'])) {
  //If user is not logged in, redirect to login page
  header("Location: admin_login.php");
  exit; // Terminate the current script
}

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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../styles/admin_styles.css ?v=<?php echo time(); ?>">
  <script src="https://kit.fontawesome.com/8eb0534a39.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <title>BURPGER - Admin</title>
</head>

<body>
  <!-- GRID CONTAINER -->
  <div class="admin-container">
    <?php include '../components/admin_sidebar.php'; // sidebar links 
    ?>
    <main>
      <div class="top">
        <h3 class="fs-third-heading fw-semi-bold">Welcome back, Admin!</h3>
        <button class="btn transition">
          <span id="btn-menu" class="material-icons-sharp md-35">menu</span>
        </button>
      </div>
      <?php
      // switch between sidebar links and display contents to this main section
      if (isset($_GET['display'])) {
        $display = $_GET['display'];

        switch ($display) {
          case 'dashboard':
            include 'dashboard.php';
            // header("Location: " . $_SERVER['PHP_SELF']); //refresh the page
            // exit();
            break;
          case 'orders':
            include 'orders.php';
            break;
          case 'products':
            include 'products.php';
            break;
          case 'feedbacks':
            include 'feedbacks.php';
            break;
          case 'customer_account':
            include 'customer_account.php';
            break;
          default:
            echo "Invalid display value";
        }
      } else {
        include 'dashboard.php';
      }
      ?>
    </main>
  </div>

  <script>
    const sideMenu = document.querySelector('#sidebar');
    const btnMenu = document.querySelector('#btn-menu');
    const btnClose = document.querySelector('#btn-close');

    btnMenu.addEventListener('click', () => {
      sideMenu.style.display = 'block';
    });

    btnClose.addEventListener('click', () => {
      sideMenu.style.display = 'none';
    });
  </script>
</body>

</html>