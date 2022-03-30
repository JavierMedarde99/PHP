<?php
session_name("ejer3");
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ejer1-3</title>
</head>
<body>
    <h1>SUBIR Y BAJAR NÚMEROS</h1>
    <form action="sesiones02_3" method="post">
       <br> <input type="submit" value="+" name="btnContador">
       <input type="submit" value="-" name="btnContador">
       <br> <input type="submit" value="Poner a cero" name="btnContador">
       

    </form>


</body>
</html>