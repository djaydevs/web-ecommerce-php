<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../styles/admin_home.css ?v=<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Admin - Dashboard</title>
</head>
<body>
<div id="sidebar-container">
  <nav id="sidebar">
  <i class="material-icons back-btn" style="font-size:2rem;">arrow_back</i>
    <ul>
      <li><a href="../admin/home.php" id="link1">Dashbaord</a></li>
      <li><a href="../admin/orders.php" id="link2">Orders</a></li>
      <li><a href="../admin/products.php" id="link3">Products</a></li>
      <li><a href="../admin/feedbacks.php" id="link4">Feedbacks</a></li>
      <li><a href="../admin/customer_account.php" id="link5">Customer Account</a></li>
    </ul>
  </nav>
</div>
<section>
  <header>
    <i class="material-icons menu-btn" style="font-size:2rem;">menu</i>
    <div class="account-container">
      <!-- <a href="#">Account</a> -->
    </div>
  </header>
  <div class="cv">
    <div id="content">
      <h1>Dashboard - Home</h1>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa error numquam qui aspernatur doloribus, vel vero nisi dolores cumque, voluptate laudantium consequatur commodi molestiae! Distinctio qui veritatis est nostrum obcaecati.</p>
    </div>
  </div>
</section>

<script>
  //for sidebar menu and back button
  const menuBtn = document.querySelector(".menu-btn");
  backBtn = document.querySelector(".back-btn");
  menu = document.querySelector("nav");
  link2 = document.getElementById("link2");
  link3 = document.getElementById("link3");
  link4 = document.getElementById("link4");
  link5 = document.getElementById("link5");

  menuBtn.addEventListener("click", () => {
    menu.style.transform = "translateX(0)";
  });

  backBtn.addEventListener("click", () => {
    menu.style.transform = "translateX(-100%)";
  });

  link2.addEventListener("click", () => {
    menu.style.transform = "translateX(-100%)";
  });

  link3.addEventListener("click", () => {
    menu.style.transform = "translateX(-100%)";
  });

  link4.addEventListener("click", () => {
    menu.style.transform = "translateX(-100%)";
  });

  link5.addEventListener("click", () => {
    menu.style.transform = "translateX(-100%)";
  });

  //for ajax
  $(document).ready(function() {
    // set up click event listeners on the links in the sidebar
    $("#link2, #link3, #link4, #link5").click(function(event) {
      // prevent the default behavior of the link
      event.preventDefault();
      
      // get the URL of the link that was clicked
      var linkUrl = $(this).attr("href");
      
      // send an AJAX request to the URL of the link
      $.ajax({
        url: linkUrl,
        type: "GET",
        success: function(response) {
          // update the content of the content container
          $("#content").html(response);
          
          // update the URL using the HTML5 History API
          history.pushState(null, null, linkUrl);

          // add an "active" class to the clicked link
          $("nav#sidebar a").removeClass("active");
          $(this).addClass("active");
        },
        error: function(xhr, status, error) {
          // handle the error if necessary
          console.log("Error: " + error);
        }
      });
    });
    
    // set up a popstate event listener to handle back/forward navigation
    $(window).on("popstate", function(event) {
      // get the URL of the current page
      var currentUrl = window.location.pathname;
      
      // send an AJAX request to the URL of the page
      $.ajax({
        url: currentUrl,
        type: "GET",
        success: function(response) {
          // update the content of the content container
          $("#content").html(response);

          // mark the appropriate link as active
          $("nav#sidebar a").removeClass("active");
          $("nav#sidebar a[href='" + currentUrl + "']").addClass("active");
        },
        error: function(xhr, status, error) {
          // handle the error if necessary
          console.log("Error: " + error);
        }
      });
    });
  });
</script>

</body>
</html>