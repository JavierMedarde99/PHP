<?php
session_name("videoClub_examen");
session_start();

require "src/funciones_servicios.php";

if(isset($_POST["btnvolverPrincipal"])){
    session_destroy();
    header("Location:index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExamenVideoclub</title>
</head>
<body>
    <?php
    if(isset($_POST["btnRegistrarse"]) || isset($_POST["btnNuevo"])){
        require "vistas/vista_nuevo.php";
    }else if(isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["tiempo"])){
        require "vistas/vista_pelis.php";
    }else{
    require "vistas/vista_login.php";
    }

    
    ?>
    