
<?php
    if (isset($_POST["btnLogin"])) {
        $error_usuario = $_POST["usuario"] == "";
        $error_contrasena = $_POST["contrasena"] == "";
        $error_form = $error_usuario || $error_contrasena;
        if (!$error_form) {
            @$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            if (!$conexion)
                die(error_page("Primer login - Form Acceso", "<h1>Primer Login</h1><p>Error en la conexión Nº: " . mysqli_connect_errno() . " : " . mysqli_connect_error() . "</p>"));

            mysqli_set_charset($conexion, "utf8");
            $consulta = "SELECT * FROM usuarios WHERE usuario='" . $_POST["usuario"] . "' AND clave='" . md5($_POST["contrasena"]) . "'";
            $resultado = mysqli_query($conexion, $consulta);
            if ($resultado) {
                if (mysqli_num_rows($resultado) > 0) {

                    $_SESSION["usuario"] = $_POST["usuario"];
                    $_SESSION["contrasena"] = md5($_POST["contrasena"]);
                    $_SESSION["ultimo_aceso"] = time();
                    mysqli_free_result($resultado);
                    mysqli_close($conexion);
                    header("Location:index.php");
                } else {
                    $error_usuario = true;
                }
            } else {
                $body = "<h1>Primer Login</h1><p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p>";
                mysqli_close($conexion);
                die(error_page("Primer login - Form Acceso", $body));
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
        <title>Primer login - Form Acceso</title>
    </head>

    <body>
        <h1>Primer Login</h1>
        <?php
        if(isset($_SESSION["restringida"])){
            echo "<p>".$_SESSION["restringida"]."</p>";
            session_destroy();
        }

        if(isset($_SESSION["tiempo"])){
            echo "<p>".$_SESSION["tiempo"]."</p>";
            session_destroy();
        }
        ?>    
        <form action="index.php" method="post">
            <p>
                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>" />
                <?php
                if (isset($_POST["btnLogin"]) && $error_usuario) {
                    if ($_POST["usuario"] == "")
                        echo "<span class='error'> * Campo Vacio * </span>";
                    else
                        echo "<span class='error'>Usuario/Contraseña no correcta</span>";
                }
                ?>

            </p>
            <p>
                <label for="contrasena">Constraseña: </label>
                <input type="password" name="contrasena" id="contrasena">
                <?php
                if (isset($_POST["btnLogin"]) && $error_contrasena) {
                    echo "<span class='error'> * Campo Vacio * </span>";
                }
                ?>
            </p>
            <p>
                <input type="submit" value="Login" name="btnLogin">
                <input type="submit" value="registro" name="btnRegistro">
            </p>
        </form>

    </body>

    </html>