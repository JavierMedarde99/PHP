<?php
session_name("ejer1");
session_start();
if (isset($_POST["btnEnviar"])) {
    if ($_POST["nombre"] == "") {
        $_SESSION["error"] = "* Campo vacio *";
        header("Location:sesiones01_1.php");
        exit;
    } else {
        $_SESSION["nombre"] = $_POST["nombre"];
    }
}

if (isset($_POST["btnBorrar"])) {
    session_destroy();
    header("Location:sesiones01_1.php");
    exit;
}
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
        echo   "<p>Su nombres es: <strong>" . $_SESSION["nombre"] . "</strong></p>"
    ?>

    <p><a href="sesiones01_1.php">Volver a la primera pagina</a></p>


</body>

</html>