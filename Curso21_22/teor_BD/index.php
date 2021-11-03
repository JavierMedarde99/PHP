<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoria BD PHP</title>
</head>
<body>
    <?php
    
    @$conexion=mysqli_connect("localhost","jose","josefa","bd_teoria");
    if(!$conexion)
        die("Imposible conectar. Error Numero: ".mysqli_connect_errno()." : ".mysqli_connect_error());

    mysqli_set_charset($conexion,"utf8");











    mysqli_close($conexion);
    ?>
</body>
</html>