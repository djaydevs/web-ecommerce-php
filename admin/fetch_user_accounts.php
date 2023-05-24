<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../components/connection.php';


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
                <button class="btn transition | delete-btn-account">
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