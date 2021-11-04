<?php
if(isset($_POST["btnVolver"]))
header('Location: index.php');

if(isset($_POST["btnContinuar"])){
    $error_Nombre= $_POST["nombre"]=="";
    $error_Usuario=$_POST["usuario"]=="" || repetido($_POST["usuario"]);
    $error_Contraseña= $_POST["contraseña"]=="";
    $error_Email=$_POST["email"]=="";
    $errores=$error_Nombre|| $error_Usuario || $error_Contraseña || $error_Email;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Usuario</title>
</head>
<body>
    <h1>Nuevo Usuario</h1>

    <form action="usuario_nuevo.php" method="post">

    <br/>
    <br/>
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre">

    <br/>
    <br/>
    <label for="usuario">Usuario</label>
    <input type="text" name="usuario" id="usuario">

    <br/>
    <br/>
    <label for="contraseña">Contraseña</label>
    <input type="password" name="contraseña" id="contraseña">

    <br/>
    <br/>
    <label for="email">Email</label>
    <input type="email" name="email" id="email">

    <br/>
    <br/>
    <input type="submit" value="Continuar" name="btnContinuar">
    <input type="submit" value="Volver" name="btnVolver">
    </form>
</body>
</html>