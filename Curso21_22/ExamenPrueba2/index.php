<?php
require "src/ctes_funciones.php";
session_name("examenPrueba2");
session_start();

if (isset($_POST["btnRegistrarse"])) {
    header("Location: registro_usuario.php");
}

if (isset($_POST["btnEntrar"])) {

    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_form = $error_usuario || $error_clave;
    if (!$error_form) {
        @$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        if (!$conexion)
            die(error_page("VideoClub", "<h1>Video Club</h1><p>Error en la conexión Nº: " . mysqli_connect_errno() . " : " . mysqli_connect_error() . "</p>"));
        mysqli_set_charset($conexion, "utf8");

        $consulta = "SELECT * FROM clientes WHERE usuario ='" . $_POST["usuario"] . "' AND clave ='" . md5($_POST["clave"]) . "'";
        $resultado = mysqli_query($conexion, $consulta);
        if ($resultado) {
            if (mysqli_num_rows($resultado) > 0) {
                $_SESSION["usuario"] = $_POST["usuario"];
                $_SESSION["clave"] = md5($_POST["clave"]);
                $_SESSION["ultimo_acceso"] = time();
                mysqli_free_result($resultado);
                mysqli_close($conexion);
                header("Location:clientes.php");
            } else {
                $error_usuario = true;
            }
        } else {
            $body = "<h1>Video Club</h1><p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p>";
            mysqli_close($conexion);
            die(error_page("VideoClub", $body));
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
    <title>VideoClub</title>
</head>

<body>
    <h1>Video Club</h1>
    <?php
    if (isset($_SESSION["tiempo"])) {
        echo "<p>" . $_SESSION["tiempo"] . "</p>";
        session_destroy();
    }
    ?>
    <form action="index.php" method="post">
        <label for="usuario">Nombre de usuario:</label>
        <input type="text" name="usuario" id="usuario">
        <?php
        if (isset($_POST["btnEntrar"]) && $error_usuario) {
            if ($_POST["usuario"] == "")
                echo "<span class='error'> * Campo Vacío * </span>";
            else
                echo "<span class='error'> * Usuario/Contraseña no válidos * </span>";
        }
        ?>
        <br>
        <br>
        <label for="clave">Contraseña</label>
        <input type="password" name="clave" id="clave">
        <?php
            if(isset($_POST["btnEntrar"])&& $error_clave)
                echo "<span class='error'> * Campo Vacío * </span>";
            ?>
        <br>
        <br>
        <input type="submit" value="Entrar" name="btnEntrar">
        <input type="submit" value="Registrarse" name="btnRegistrarse">
    </form>
</body>

</html>