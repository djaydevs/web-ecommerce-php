<?php

require '../components/connection.php';

session_start();
session_unset();
session_destroy();

header("location:../admin/admin_login.php");

?>