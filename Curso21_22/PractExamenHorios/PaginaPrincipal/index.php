<?php
session_name("examen_horaris_ahora");
session_start();
require "src/ctes_funciones.php";

if(isset($_POST["btnCerrarSesion"]))
{
    session_destroy();
    header("Location:index.php");
    exit;
}

    if(isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["ultimo_acceso"])){
      
        require "vistas/vista_usuario.php";
        
    }else{

        require "vistas/vista_login.php";

    }
       
?>
