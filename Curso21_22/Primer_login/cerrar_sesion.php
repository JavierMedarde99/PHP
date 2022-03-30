<?php
session_name("primer_login_21_22");
session_start();
session_destroy();
header("Location:index.php");
?>