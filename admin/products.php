<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/admin_products.css ?v=<?php echo time(); ?>">
    <title>Admin - Products</title>
</head>
<body>
<p>Products</p>

<section class ="add-products">

    <h1 class="title">Add New Products</h1>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="flex">
            <div class="input-box">
                <input type="text" name="product-name" class="box" required placeholder="Enter product name">
                <select name="product-category" class="box" required>
                    <option value="" selected disabled>Select Category</option>
                    <option value="Donuts">Donuts</option>
                    <option value="Cakes">Cakes</option>
                    <option value="Drinks">Drinks</option>
                </select>
                <input type="text" name="product-details" class="box" required placeholder="Enter product details">
                <input type="number" min="0" name="product-price" class="box" required placeholder="Enter product price">
                <input type="file" class="box" required accept="image/jpg, image/jpeg, image/png>            
            </div>
        </div>    
    </form>
</section>
</body>
</html>