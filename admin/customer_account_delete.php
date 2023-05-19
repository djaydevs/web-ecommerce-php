<?php
    $conn = mysqli_connect("localhost", "root", "", "cafe_db");

    if(isset($_POST['delete'])){
        $id = $_POST['id'];

        $query = "DELETE FROM customer WHERE customer_id='$id'";
        $query_run = mysqli_query($conn, $query);

        if($query_run){
            echo '<script> alert("Data Deleted"); </script>';
        }else{
            echo '<script> alert("Data Not Deleted"); </script>';
        }
    }
?>