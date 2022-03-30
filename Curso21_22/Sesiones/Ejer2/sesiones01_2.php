<?php
session_name("ejer2");
session_start();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejer1-2</title>
</head>

<body>
    <?php
    if (isset($_SESSION["nombre"]))
        echo "<p>Su nombre es: <strong>" . $_SESSION["nombre"] . "</strong></p>"
    ?>
    <h1>Escriba su nombre</h1>
    <form action="sesiones02_2.php" method="post">
        <p><label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre">
            <?php
            if (isset($_SESSION["error"])) {
                echo $_SESSION["error"];
                unset($_SESSION["error"]);
            }

            ?>
        </p>

        <p> <input type="submit" value="Enviar" name="btnEnviar">
            <input type="submit" value="Borrar" name="btnBorrar">
        </p>

    </form>
</body>

</html>