<?php 
    include '../components/connection.php';

    // DELETE  
    if(isset($_GET['deleteid'])){
        $id = $_GET['deleteid'];

        $query = "DELETE FROM users WHERE id='$id'";
        $query_run = mysqli_query($conn, $query);

        if($query_run){
            $message = 'Account successfully deleted!';
            header('location: home.php?display=customer_account&message=' . urlencode($message));
        }else{
            echo '<script> alert("Data Not Deleted"); </script>';
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
    <link rel="stylesheet" type="text/css" href="../styles/admin_customaccount.css?v=<?php echo time(); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
                    <tbody id="customerTableBody">
                        <?php
                        // Function to fetch user accounts from the database
                       
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
<script>
    // Function to refresh the table using AJAX
    function refreshTable() {
        $.ajax({
            url: 'fetch_user_accounts.php',
            type: 'GET',
            success: function(response) {
                // Refresh the table with updated data
                $('#customerTableBody').html(response);
            },
            error: function() {
                alert('Error occurred while refreshing the table.');
            }
        });
    }

    // Refresh the table every 5 seconds
    setInterval(refreshTable, 5000);
</script>
</body>
</html>