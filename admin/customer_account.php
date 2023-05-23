<?php 
    include '../components/connection.php';

    // DELETE  
    if(isset($_GET['deleteid'])){
        $id = $_GET['deleteid'];

        $query = "DELETE FROM users WHERE id='$id'";
        $query_run = mysqli_query($conn, $query);

        if($query_run){
            echo '<script> alert("Data Deleted"); </script>';
        }else{
            echo '<script> alert("Data Not Deleted"); </script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/admin_customaccount.css?v=<?php echo time(); ?>">
    <style>
        .container-body {
            padding: 10px;
        }

        .content-table {
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 0.9em;
            width: 1000px;
        }

        .content-table thead tr {
            text-align: left;
            font-weight: bold;
        }

        .content-table th,
        .content-table td {
            padding: 12px 15px;
        }

        .content-table tbody tr {
            border-bottom: 1px solid #ddd;
        }

        .content-table tbody tr:nth-of-type(even) {
            background-color: #d7d7d7;
        }

        .delete-btn {
            color: white;
            width: 70px;
            height: 35px;
            border: none;
            border-radius: 3px;
            background-color: orange;  
        }
        .delete-btn a {
        color: white;
        text-decoration: none;
        }
        .delete-btn:hover{
            background-color: red;  
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="container-body">
            <div class="header">
                <h4>Registered Customers</h4>
            </div>
            <div class="body">
                <table class="content-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fullname</th>
                            <th>Email</th>
                            <th>Mobile Number</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // query 
                        $query = "SELECT * FROM users";
                        $query_run = mysqli_query($conn, $query);

                        if (mysqli_num_rows($query_run) > 0) {
                            foreach ($query_run as $row) {
                        ?>
                                <tr>
                                    <td><?= $row['id']; ?></td>
                                    <td><?= $row['name']; ?></td>
                                    <td><?= $row['email']; ?></td>
                                    <td><?= $row['number']; ?></td>
                                    <td>
                                        <button class="delete-btn">
                                            <a href="customer_account.php?deleteid=<?php echo $row['id']; ?>" onclick="return confirm('Delete this account?');">Delete</a>
                                        </button>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="7">No Record Found</td>
                            </tr>
                        <?php
                        }

                        // Close the database connection
                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>