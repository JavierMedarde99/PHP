<?php
session_name("pag_pract8_21_22");
session_start();

require "src/ctes_funciones.php";

@$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
if (!$conexion) {
    session_destroy();
    die(error_page("Práctica 8 - CRUD", "<h1>Pŕactica 8</h1><p>Error en la conexión Nº: " . mysqli_connect_errno() . " : " . mysqli_connect_error() . "</p>"));
}
mysqli_set_charset($conexion, "utf8");

if (isset($_POST["btnContBorrar"])) {
    $consulta = "delete from usuarios where id_usuario=" . $_POST["btnContBorrar"];
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {
        if ($_POST["foto"] != IMAGEN_DEFECTO)
            unlink("Img/" . $_POST["foto"]);
        $_SESSION["pagina"] = 1;
        $_SESSION["accion"] = "Usuario insertado con éxito";
        header("Location:index.php");
        exit;
    } else {
        $body = "<h1>Práctica 8</h1><p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p>";
        session_destroy();
        mysqli_close($conexion);
        die(error_page("Práctica 8 - CRUD", $body));
    }
}

if (isset($_POST["btnContEditar"])) {
    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    if (!$error_usuario) {
        $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"], "id_usuario", $_POST["id_usuario"]);
        if (is_array($error_usuario)) {
            session_destroy();
            mysqli_close($conexion);
            die(error_page("Práctica 8 - CRUD", "<p>" . $error_usuario["error"] . "</p>"));
        }
    }
    $error_dni = $_POST["dni"] == "" || !dni_bien_escrito($_POST["dni"]) || !dni_valido($_POST["dni"]);

    if (!$error_dni) {
        $error_dni = repetido($conexion, "usuarios", "dni", strtoupper($_POST["dni"]), "id_usuario", $_POST["id_usuario"]);
        if (is_array($error_dni)) {
            session_destroy();
            mysqli_close($conexion);
            die(error_page("Práctica 8 - CRUD", "<p>" . $error_dni["error"] . "</p>"));
        }
    }

    $error_sexo = !isset($_POST["sexo"]);

    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1000);

    $errores_form_editar = $error_nombre || $error_usuario || $error_dni || $error_sexo || $error_foto;

    if (!$errores_form_editar) {
        if ($_POST["clave"] == "")
            $consulta = "update usuarios set usuario='" . $_POST["usuario"] . "', nombre='" . $_POST["nombre"] . "', dni='" . strtoupper($_POST["dni"]) . "', sexo='" . $_POST["sexo"] . "' where id_usuario=" . $_POST["id_usuario"];
        else
            $consulta = "update usuarios set usuario='" . $_POST["usuario"] . "', nombre='" . $_POST["nombre"] . "', clave='" . md5($_POST["clave"]) . "', dni='" . strtoupper($_POST["dni"]) . "', sexo='" . $_POST["sexo"] . "' where id_usuario=" . $_POST["id_usuario"];

        $resultado = mysqli_query($conexion, $consulta);
        if ($resultado) {
            $_SESSION["accion"] = "Usuario editado con éxito";
            header("Location:index.php");
            exit;
            if ($_FILES["foto"]["name"] != "") {
                $array_aux = explode(".", $_FILES["foto"]["name"]);
                if (count($array_aux) == 1)
                    $extension = "";
                else
                    $extension = "." . end($array_aux);

                $nombre_img_nuevo = "img" . $_POST["id_usuario"] . $extension;

                @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "Img/" . $nombre_img_nuevo);
                if ($var) {
                    if ($_POST["foto_ant"] != $nombre_img_nuevo) {
                        $consulta = "update usuarios set foto='" . $nombre_img_nuevo . "' where id_usuario=" . $_POST["id_usuario"];
                        $resultado = mysqli_query($conexion, $consulta);
                        if ($resultado) {
                            if ($_POST["foto_ant"] != IMAGEN_DEFECTO)
                                unlink("Img/" . $_POST["foto_ant"]);
                        } else {
                            $body = "<h1>Práctica 8</h1><p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p>";
                            session_destroy();
                            mysqli_close($conexion);
                            die(error_page("Práctica 8 - CRUD", $body));
                        }
                    }
                } else {
                    $_SESSION["accion"] = "Se actualizado el usuario dejando la foto anterior, ya que la nueva foto no se ha podido mover a la carpeta destino en el Servidor";
                    header("Location:index.php");
                    exit;
                }
            }
        } else {
            $body = "<h1>Práctica 8</h1><p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p>";
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Práctica 8 - CRUD", $body));
        }
    }
}

if (isset($_POST["btnContBorrarFoto"])) {
    $consulta = "update usuarios set foto='" . IMAGEN_DEFECTO . "' where id_usuario=" . $_POST["id_usuario"];
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {
        unlink("Img/" . $_POST["foto_ant"]);
        $_POST["foto_ant"] = IMAGEN_DEFECTO;
    } else {
        $body = "<h1>Práctica 8</h1><p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p>";
        session_destroy();
        mysqli_close($conexion);
        die(error_page("Práctica 8 - CRUD", $body));
    }
}



if (isset($_POST["btnContNuevo"])) {

    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    if (!$error_usuario) {
        $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"]);
        if (is_array($error_usuario)) {
            session_destroy();
            mysqli_close($conexion);
            die(error_page("Práctica 8 - CRUD", "<p>" . $error_usuario["error"] . "</p>"));
        }
    }
    $error_dni = $_POST["dni"] == "" || !dni_bien_escrito($_POST["dni"]) || !dni_valido($_POST["dni"]);

    if (!$error_dni) {
        $error_dni = repetido($conexion, "usuarios", "dni", strtoupper($_POST["dni"]));
        if (is_array($error_dni)) {
            session_destroy();
            mysqli_close($conexion);
            die(error_page("Práctica 8 - CRUD", "<p>" . $error_dni["error"] . "</p>"));
        }
    }

    $error_clave = $_POST["clave"] == "";

    $error_sexo = !isset($_POST["sexo"]);

    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1000);

    $errores_form_nuevo = $error_nombre || $error_usuario || $error_clave || $error_dni || $error_sexo || $error_foto;

    if (!$errores_form_nuevo) {
        $consulta = "insert into usuarios (nombre,usuario,clave,dni,sexo) values ('" . $_POST["nombre"] . "','" . $_POST["usuario"] . "','" . md5($_POST["clave"]) . "','" . strtoupper($_POST["dni"]) . "','" . $_POST["sexo"] . "')";
        $resultado = mysqli_query($conexion, $consulta);
        if ($resultado) {
            $_SESSION["accion"] = "Usuario insertado con éxito";
            header("Location:index.php");
            exit;
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
                    $consulta = "update usuarios set foto='" . $nombre_img . "' where id_usuario=" . $ult_id;
                    $resultado = mysqli_query($conexion, $consulta);
                    if (!$resultado) {
                        $body = "<h1>Práctica 8</h1><p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p>";
                        session_destroy();
                        mysqli_close($conexion);
                        die(error_page("Práctica 8 - CRUD", $body));
                    }
                } else
                    $_SESSION["accion"] = "Usuario insertado con la foto por defecto, debido a que no ha podido moverse a la carpeta destino";
                header("Location:index.php");
                exit;
            }
        } else {
            $body = "<h1>Práctica 8</h1><p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p>";
            session_destroy();
            mysqli_close($conexion);
            die(error_page("Práctica 8 - CRUD", $body));
        }
    }
}

if (!isset($_SESSION["registros"])) {
    $_SESSION["registros"] = 3;
    $_SESSION["buscar"] = "";
}

if (isset($_POST["registros"])) {
    $_SESSION["registros"] = $_POST["registros"];
    $_SESSION["buscar"] = $_POST["buscar"];
    $_SESSION["pagina"] = 1;
}

if (!isset($_SESSION["pagina"]))
    $_SESSION["pagina"] = 1;

if (isset($_POST["pagina"]))
    $_SESSION["pagina"] = $_POST["pagina"];


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 8 - CRUD</title>
    <style>
        .error {
            color: red
        }

       

        td img {
            width: 100px;
        }

        

        

        #form_editar,
        #listar {
            display: flex;
            justify-content: space-evenly;
            align-items: center
        }

        #form_editar div,
        #listar div {
            width: 50%;
        }

        #form_editar div img,
        #listar div img {
            height: 250px
        }
        .enlinea{display:inline;float:right}
        .centrar{text-align:center}
        .form_nuevo, .mensaje,.resultado {width:60%;margin:1.5em auto;}
        table,th,td{border:1px solid black}
        table{border-collapse:collapse; width:60%;margin:0 auto}
        .sin_boton{background:transparent;border:none;color:blue;text-decoration:underline;cursor:pointer}
        #form_pags{width:60%;margin:0 auto;text-align:center;margin-top:0.5em}
        #form_pags button{margin:0 0.25em}
        #form_reg_bus{width:60%;margin:0 auto;display:flex;justify-content:space-between}
    </style>
</head>

<body>
    <h1>Práctica 8</h1>
    <?php
    if (isset($accion))
        echo "<p>" . $accion . "</p>";


    if (isset($_POST["btnEditar"]) || (isset($_POST["btnContEditar"]) && $errores_form_editar) || isset($_POST["btnBorrarFoto"]) || isset($_POST["btnContBorrarFoto"]) || isset($_POST["btnNoContBorrarFoto"])) {
        require "vistas/vista_editar.php";
    }

    if (isset($_POST["btnNuevo"]) || (isset($_POST["btnContNuevo"]) && $errores_form_nuevo)) {
        require "vistas/vista_nuevo.php";
    }
    if (isset($_POST["btnBorrar"])) {
        require "vistas/vista_borrar.php";
    }

    if (isset($_POST["btnListar"])) {
        require "vistas/vista_listar.php";
    }

    require "vistas/vistas_tabla_usuario.php";

    ?>
</body>

</html>