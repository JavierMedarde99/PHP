<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer Login - Principal</title>
</head>
<body>
    <h1>primer login</h1>
    <p>Bienvenido <strong><?php echo $_SESSION["usuario"]?></strong> - <a href="cerrar_sesion.php">Salir</a></p>
</body>
</html>