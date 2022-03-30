<?php
session_name("ejer2");
session_start();
if (isset($_POST["btnEnviar"])) {

    if ($_POST["nombre"] == "") {
        $_SESSION["error"] = "* Campo vacio *";
      
    } else {
        $_SESSION["nombre"] = $_POST["nombre"];
    }
}

if (isset($_POST["btnBorrar"])) {
    session_destroy();
} 

header("Location:sesiones01_2.php");
    exit;
?>
