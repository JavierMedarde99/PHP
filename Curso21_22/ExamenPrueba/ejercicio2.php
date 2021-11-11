<?php
if(isset($_POST["btnEnviar"])){

    $error_texto= $_POST["texto"]="" ;
}

?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Ejercicio2</title>
        <meta charset="UTF-8" />
    </head>
    <body>
        <form action="ejercicio2.php" method="post">

<label for="texto">Insertar el texto</label>
<input type="text" name="texto" id="texto" value="" />

<br/>
<br/>

<label for="clave">Insertar la clave</label>
<input type="text" name="clave" id="clave" value="" />

<br/>
<br/>

<button type="submit" name="btnEnviar"> Enviar </button>
        </form>
    </body>
</html>