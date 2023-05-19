<?php
    $conn = mysqli_connect("localhost", "root", "", "cafe_db");

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