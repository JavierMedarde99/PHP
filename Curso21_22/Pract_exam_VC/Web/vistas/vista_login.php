<?php
if(isset($_POST["btnEntrar"])){
    $error_nombre=$_POST["nombre"]=="";
    $error_clave=$_POST["clave"]=="";
    $error_form=$error_nombre||$error_clave;

if(!$error_form){

$url=DIR_SERV."/login";
$datos_login["usuario"]=$_POST["nombre"];
$datos_login["clave"]=md5($_POST["clave"]);

$respuesta=consumir_servicios_REST($url,"POST",$datos_login);
$obj=json_decode($respuesta);
if(!$obj){
    session_destroy();
    die(error_page("ExamenVideoclub","<h1>Video Club</h1><p>Error consumiendo el servicio: ".$url."</p>".$respuesta ));
}
if(isset($obj->error)){
    session_destroy();
    die(error_page("ExamenVideoclub","<h1>Video Club</h1><p>".$obj->error."</p>"));

}
if(isset($obj->mensaje)){
$error_nombre=true;
}
if(isset($obj->usuario)){
    $_SESSION["usuario"]=$datos_login["usuario"];
    $_SESSION["clave"]=$datos_login["clave"];
    $_SESSION["tiempo"]=time();
    if(time()-$_SESSION["tiempo"]>MINUTOS*60)
    {
        session_unset();
        $_SESSION["seguridad"]="Su tiempo de sesión ha caducado. Vuelva a loguearse o registrarse";
        header("Location:index.php");
        exit;
    }
header("Location:index.php");
            exit;
}else
{
    session_unset();
    $_SESSION["seguridad"]="Zona restringida. Vuelva a loguearse o registrarse";
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
    <title>ExamenVideoclub</title>
</head>
<body>
<h1>Video Club</h1>
    <form action="index.php" method="post">
        <label for="nombre">Nombre de usuario:</label>
        <input type="text" name="nombre" id="nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"]?>">
        <?php
        if(isset($_POST["btnEntrar"]) && $error_nombre){
            if($_POST["nombre"]=="")
            echo "*Error campo vacio*";
            else
            echo "Error no se encunetra registrado";
        }
        ?>
        <br/>
        <label for="clave">Contraseña:</label>
        <input type="password" name="clave" id="clave">
        <?php
        if(isset($_POST["btnEntrar"]) && $error_clave){
            echo "*Error campo vacio*";
        }
        ?>
        <br/>
        <input type="submit" value="Entrar" name="btnEntrar">
        <input type="submit" value="Registrarse" name="btnRegistrarse">
    </form>
</body>
</html>