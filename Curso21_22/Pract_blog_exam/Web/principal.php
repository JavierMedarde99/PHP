<?php
session_name("web_exam");
session_start();
if(isset($_POST["btnSalir"])){
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
    <title>Panel de usuario</title>
</head>
<body>
    <p>Bienvenido: <strong><?php echo $_SESSION["usuario"]?></strong>-
    <form action="principal.php" method="post">
        <input type="submit" value="Salir" name="btnSalir">
    </form>
</p>
</body>
</html>