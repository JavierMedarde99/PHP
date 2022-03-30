<?php
require "src/ctes_funciones.php";
session_name("examenPrueba2");
session_start();
if (isset($_POST["btnVolver"])) {
    header("Location: index.php");
}

if (isset($_POST["btnContinuar"])) {
    $error_usuario = $_POST["usuario"] == "";

    if (!$error_usuario) {
        @$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        if (!$conexion)
            die(error_page("Primer Login - Registro", "<h1>Primer Login</h1><p>Error en la conexión Nº: " . mysqli_connect_errno() . " : " . mysqli_connect_error() . "</p>"));
        mysqli_set_charset($conexion, "utf8");

        $error_usuario = repetido($conexion, "clientes", "usuario", $_POST["usuario"]);
        if (is_array($error_usuario)) {
            mysqli_close($conexion);
            die(error_page("Primer Login - Registro", "<p>" . $error_usuario["error"] . "</p>"));
        }
    }
    $error_clave = $_POST["clave"] == "" || $_POST["clave"] != $_POST["claveRep"];
    $error_claveRep = $_POST["claveRep"] == "";
    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1000);
    $error_form_nuevo = $error_usuario || $error_clave || $error_claveRep || $error_foto;

    if (!$error_form_nuevo) {
        $consulta = "INSERT INTO clientes (usuario,clave) VALUES ('" . $_POST["usuario"] . "','" . md5($_POST["clave"]) . "')";
        $resultado = mysqli_query($conexion, $consulta);
        if ($resultado) {
            $_SESSION["accion"] = "Usuario registrado con éxito";
            if ($_FILES["foto"]["name"] != "") {
                $ult_id = mysqli_insert_id($conexion);

                $array_aux = explode(".", $_FILES["foto"]["name"]);
                if (count($array_aux) == 1)
                    $extension = "";
                else
                    $extension = "." . end($array_aux);

                $nombre_img = "img" . $ult_id . $extension;
                @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "Img/" . $nombre_img);
                if ($var) {
                    $consulta = "UPDATE clientes SET foto='" . $nombre_img . "' where id_cliente=" . $ult_id;
                    $resultado = mysqli_query($conexion, $consulta);
                    if (!$resultado) {
                        $body = "<h1>Video Club</h1><p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p>";
                        mysqli_close($conexion);
                        session_destroy();
                        die(error_page("VideoClub", $body));
                    }
                }
                else {
                    $_SESSION["accion"] = "Usuario registrado con la foto por defecto, debido a que no ha podido moverse a la carpeta destino";
                }
            }
            $_SESSION["usuario"] = $_POST["usuario"];
            $_SESSION["clave"] = md5($_POST["clave"]);
            $_SESSION["ultimo_acceso"] = time();
            header("Location:clientes.php");
            exit;
        }
        else {
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
    <title>Registro</title>
</head>

<body>
    <h1>Video Club</h1>
    <form action="registro_usuario.php" method="post">
        <label for="usuario">Nombre de usuario:</label>
        <input type="text" name="usuario" id="usuario">
        <?php
if (isset($_POST["btnContinuar"]) && $error_usuario) {
    if ($_POST["usuario"] == "")
        echo "<span class='error'>* Campo vacío *</span>";
    else
        echo "<span class='error'>* Usuario repetido *</span>";
}
?>
        <br>
        <br>
        <label for="clave">Contraseña:</label>
        <input type="password" name="clave" id="clave">
        <?php
if (isset($_POST["btnContinuar"]) && $error_clave) {
    if ($_POST["clave"] == "")
        echo "<span class='error'>* Campo vacío *</span>";
    else
        echo "<span class='error'>* la contraseñas no coinciden *</span>";
}
?>
        <br>
        <br>
        <label for="claveRep">Repita la contraseña:</label>
        <input type="password" name="claveRep" id="claveRep">
        <?php
if (isset($_POST["btnContinuar"]) && $error_claveRep) {
    echo "<span class='error'>* Campo vacío *</span>";
}
?>
        <br>
        <br>
        <label for="foto"></label>
        <input type="file" name="foto" accept="image/*" />
        <?php
if (isset($_POST["btnContinuar"]) && $error_foto) {
    if ($_FILES["foto"]["error"])
        echo "<span class='error'>* Error en la subida del archivo al servidor *</span>";
    elseif (!getimagesize($_FILES["foto"]["tmp_name"]))
        echo "<span class='error'>* Error: no has seleccionado un archivo imagen *</span>";
    else
        echo "<span class='error'>* Error: el tamaño del archico seleccionado supera los 500 KB *</span>";
}

?>
        <br>
        <br>
        <input type="submit" value="volver" name="btnVolver">
        <input type="submit" value="continuar" name="btnContinuar">
    </form>
</body>

</html>