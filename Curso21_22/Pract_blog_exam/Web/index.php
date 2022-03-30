<?php
session_name("web_exam");
session_start();
require "src/funciones_servicios.php";
if(isset($_POST["btnLoging"])){
    $error_usuario=$_POST["usuario"]=="";
    $error_clave=$_POST["clave"]=="";

    $error_form=$error_usuario || $error_clave;

    if(!$error_form){
        $datos_login["usuario"]=$_POST["usuario"];
        $datos_login["clave"]=md5($_POST["clave"]);
        $url=DIR_SERV."/login";
        $respuesta=consumir_servicios_REST($url,"POST",$datos_login);
        $obj=json_decode($respuesta);
        if(!$obj){
            session_destroy();
            die(error_page("Login","<p>Error consumiendo el servicio: ".$url."</p>".$respuesta));
        }

        if(isset($obj->error)){
            session_destroy();
            die(error_page("Login","<p>".$obj->error."</p>"));
        }

        if(isset($obj->mensaje)){
            $error_usuario=true;
        }else{
           
            $_SESSION["usuarioId"]=$obj->usuario->idUsuario;
            $_SESSION["usuario"]=$_POST["usuario"];
            $_SESSION["clave"]=$_POST["clave"];
            $_SESSION["tipo"]=$obj->usuario->tipo;
            $_SESSION["ultimo_acceso"]=time();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php
    if(isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["tipo"])){
   
        if($_SESSION["tipo"]=="comun"){
            header("Location:principal.php");
            exit;
        }else{
            header("Location:admin.php");
            exit;
        }
    }else{
        ?>
        <form action="index.php" method="post">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario">
<?php
if(isset($_POST["btnLoging"]) && $error_usuario){
    if($_POST["usuario"]=="")
    echo "*Campo vacio*";
    else
    echo "No se encuentra en la bd";
}
?>
        <br/>
        <label for="clave">Contraseña:</label>
        <input type="password" name="clave" id="clave">
<?php
if(isset($_POST["btnLoging"]) && $error_clave){
    echo "*Campo vacio*";
}
?>
        <br/>
        <input type="submit" value="Entrar" name="btnLoging">
    </form>
    <?php
    }
    ?>
  
</body>
</html>