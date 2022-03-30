<?php
    session_start();
    if(!isset($_SESSION["nombre"]))
    $_SESSION["nombre"]= "Javier";
    session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primera pagina</title>
</head>
<body>
    <?php
    
     echo "<p>".$_SESSION["nombre"]."</p>";
    ?>
     
</body>
</html>