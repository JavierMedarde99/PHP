<?php 
if(isset($_POST["btnReset"])){


    header("Location:index.php");
    exit;
}


 if(isset($_POST["btnEnviar"]))
 {
  $error_nombre=$_POST["nombre"]=="";
  $error_apellidos=$_POST["apellidos"]=="";
  $error_dni=$_POST["dni"]=="";
  $error_contraseña=$_POST["contraseña"]=="";
  $error_comentarios=$_POST["comentarios"]=="";
  $error_sexo=!isset($_POST["sexo"]);
  $errores=$error_nombre || $error_apellidos ||$error_dni ||   $error_contraseña || $error_comentarios ||  $error_sexo;
 }

if(isset($_POST["btnEnviar"])&& !$errores)
{
require "vistas/vista_recogida.php";
} else
{
    include "vistas/vistas_form.php";
}
    ?> 



