<?php
if(isset($_POST["btnLogin"])){
    $error_usuario=$_POST["usuario"]=="";
    $error_clave=$_POST["clave"]=="";
    
    $error_form= $error_usuario || $error_clave;
    if(!$error_form){
        $url =DIR_SERV."/login";
        $datos_login["usuario"]=$_POST["usuario"];
        $datos_login["clave"]=md5($_POST["clave"]);
        $respuesta=consumir_servicios_REST($url,"POST",$datos_login);
        $obj=json_decode($respuesta);
        if(!$obj)
        {
            session_destroy();
            die(error_page("Actividad Examen","<h1>Actividad Examen</h1><p>Error consumiendo el servicio: ".$url."</p>".$respuesta ));
        }
        if(isset($obj->error))
        {
            session_destroy();
            die(error_page("Actividad Examen","<h1>Actividad Examen</h1><p>".$obj->error."</p>"));
        }
        if(isset($obj->mensaje))
        {
            $error_usuario=true;
        }
        else
        {
            //Comienzo sesiones y salto a index;
            $_SESSION["usuario"]=$datos_login["usuario"];
            $_SESSION["clave"]=$datos_login["clave"];
            $_SESSION["ultimo_acceso"]=time();
         header("Location:index.php");
         exit;
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
    <title>Gestion de Guardias</title>
</head>
<body>
<h1>Gestioon de Guardias</h1>
    <form action="index.php" method="post">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"]?>">
        <?php
        if(isset($_POST["btnLogin"]) && $error_usuario){
            if($_POST["usuario"]=="")
            echo "*Campo vacio*";
            else
            echo "Usuario/contraseña erroneo";
        }
        ?>
        <br>
        <label for="clave">Contraseña:</label>
        <input type="password" name="clave" id="clave" value="<?php if(isset($_POST["clave"])) echo $_POST["clave"]?>">
        <?php
        if(isset($_POST["btnLogin"]) && $error_clave){
            echo "*Campo vacio*";
        }
        ?>
        <br>
        <input type="submit" value="Entrar" name="btnLogin">
    </form>
    </body>
</html>
    