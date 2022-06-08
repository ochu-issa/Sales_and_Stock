<?php 	
unset($_SESSION['uname']);
session_unset();
session_destroy();
header("location:index.php");

 ?>