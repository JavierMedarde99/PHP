<?php
// usuario normal
if (isset($_POST["btnBorrarFoto"])) {
    $consulta = "UPDATE clientes SET foto='" . IMAGEN_DEFECTO . "' WHERE usuario='" . $_SESSION["usuario"] . "' AND clave='" . $_SESSION["clave"] . "'";
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {
        unlink("Images/" . $_POST["fotoAnt"]);
        $_POST["fotoAnt"] = IMAGEN_DEFECTO;
    }
}

if (isset($_POST["btnCambiarFoto"])) {
    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1000);

    if (!$error_foto) {
        $ult_id = mysqli_insert_id($conexion);

        $array_aux = explode(".", $_FILES["foto"]["name"]);
        if (count($array_aux) == 1)
            $extension = "";
        else
            $extension = "." . end($array_aux);

        $nombre_img = "img" . $ult_id . $extension;
        @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "Images/" . $nombre_img);
        if ($var) {
            $consulta = "UPDATE clientes SET foto='" . $nombre_img . "' WHERE usuario='" . $_SESSION["usuario"] . "' AND clave='" . $_SESSION["clave"] . "'";
            $resultado = mysqli_query($conexion, $consulta);
            if (!$resultado) {
                unlink("Images/" . $nombre_img);
                $body = "<h1>Primer Login</h1><p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p>";
                mysqli_close($conexion);
                session_destroy();
                die(error_page("Primer Login - Registro", $body));
            }
        } else
            $_SESSION["accion"] = "Usuario registrado con la foto por defecto, debido a que no ha podido moverse a la carpeta destino";
    }
}

//usuario admin

//nuevo cliente
if (isset($_POST["btnNuevoCliente"])) {
    $error_usuario = $_POST["usuario"] == "";

    if (!$error_usuario) {
        $error_usuario = repetido($conexion, "clientes", "usuario", $_POST["usuario"]);
        if (is_array($error_usuario)) {
            mysqli_close($conexion);
            die(error_page("Práctica Examen 3", "<p>" . $error_usuario["error"] . "</p>"));
        }
    }
    $error_clave = $_POST["clave"] == "";

    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1000);

    $errores_form_nuevo = $error_usuario || $error_clave || $error_foto;

    if (!$errores_form_nuevo) {
        $consulta = "insert into clientes (usuario,clave) values ('" . $_POST["usuario"] . "','" . md5($_POST["clave"]) . "')";
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
                @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "Images/" . $nombre_img);
                if ($var) {
                    $consulta = "UPDATE clientes SET foto='" . $nombre_img . "'  where id_cliente=".$ult_id;
                      $resultado = mysqli_query($conexion, $consulta);
                    if (!$resultado) {
                        unlink("Images/" . $nombre_img);
                        $body = "<h1>Primer Login</h1><p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p>";
                        mysqli_close($conexion);
                        session_destroy();
                        die(error_page("Primer Login - Registro", $body));
                    }
                } else
                    $_SESSION["accion"] = "Usuario registrado con la foto por defecto, debido a que no ha podido moverse a la carpeta destino"; }
        }
    }
}


//borrar cliente
if(isset($_POST["btnBorrar"])){
    $consulta="DELETE FROM clientes where id_cliente=".$_POST["btnBorrar"];
    $resultado=mysqli_query($conexion,$consulta);
    if($resultado)
    {
        $_SESSION["accion"]="Usuario borrado con éxito";
        if($_POST["foto"]!=IMAGEN_DEFECTO)
            unlink("Images/".$_POST["foto"]);
    }
    else
    {
        $body = "<h1>Primer Login</h1><p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p>";
        mysqli_close($conexion);
        die(error_page("Primer Login - Registro", $body));
    }
}


//editar cliente
if(isset($_POST["btnEditarCliente"])){
    $error_usuario = $_POST["usuario"] == "";

    if (!$error_usuario) {
        $error_usuario = repetido($conexion, "clientes", "usuario", $_POST["usuario"]);
        if (is_array($error_usuario)) {
            mysqli_close($conexion);
            die(error_page("Práctica Examen 3", "<p>" . $error_usuario["error"] . "</p>"));
        }
    }
    $error_clave = $_POST["clave"] == "";

    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1000);

    $errores_form_nuevo = $error_usuario || $error_clave || $error_foto;

    if(!$errores_form_nuevo){
        $consulta = "UPDATE clientes SET usuario='" .$_POST["usuario"]. "', clave = '". md5($_POST["clave"])."' WHERE id_cliente = '".$_POST["id_cliente"]."'";
        $resultado = mysqli_query($conexion, $consulta);
        if($resultado){
            $_SESSION["accion"] = "Usuario editado con éxito";
            if ($_FILES["foto"]["name"] != "") {
               
                $ult_id = $_POST["id_cliente"];

                $array_aux = explode(".", $_FILES["foto"]["name"]);
                if (count($array_aux) == 1)
                    $extension = "";
                else
                    $extension = "." . end($array_aux);
        
                $nombre_img = "img" . $ult_id . $extension;
                @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "Images/" . $nombre_img);
                if ($var) {
                    $consulta = "UPDATE clientes SET foto='" . $nombre_img . "'  where id_cliente=".$ult_id;
                      $resultado = mysqli_query($conexion, $consulta);
                    if (!$resultado) {
                        unlink("Images/" . $nombre_img);
                        $body = "<h1>Primer Login</h1><p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p>";
                        mysqli_close($conexion);
                        session_destroy();
                        die(error_page("Primer Login - Registro", $body));
                    }
                } else
                    $_SESSION["accion"] = "Usuario registrado con la foto por defecto, debido a que no ha podido moverse a la carpeta destino"; }
        }
    }

}

if (isset($_POST["btnBorrarFotoCliente"])) {
    $consulta = "UPDATE clientes SET foto='" . IMAGEN_DEFECTO . "' WHERE id_cliente = '".$_POST["id_cliente"]."'";
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {
        unlink("Images/" . $_POST["fotoAnt"]);
        $_POST["fotoAnt"] = IMAGEN_DEFECTO;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica Examen 3</title>
    <style>
        .enlinea {
            display: inline
        }

        .sin_boton {
            background-color: transparent;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer
        }

        img {
            width: 35px;
            height: 35px;
        }
    </style>
</head>

<body>

    <h1>Práctica Examen 3</h1>
    <div>Bienvenido <strong><?php echo $_SESSION["usuario"]; ?></strong> -
        <form class="enlinea" method="post" action="clientes.php">
            <button class="sin_boton" type="submit" name="btnCerrarSesion">Salir</button>
        </form>
    </div>
    <?php
    if ($datos_usuario["tipo"] == "normal") {



        echo "<p><strong>Foto de perfil</strong><img src='Images/" . $datos_usuario["foto"] . "'></p>";

        if ($datos_usuario["foto"] != IMAGEN_DEFECTO) {
            echo "<form action='clientes.php' method='post'>";
            echo "<input type='hidden' value='" . $datos_usuario["foto"] . "' name='fotoAnt'>";
            echo "<input type='submit' value='borrar foto' name='btnBorrarFoto'>";
            echo "</form>";
        }
        echo "<form action='clientes.php' method='post' enctype='multipart/form-data'>";
        echo "<label for='foto'>Inserte una nueva foto</label>";
        echo "<input type='file' name='foto' accept='image/*' />";
        if (isset($_POST["btnContRegistro"]) && $error_foto) {
            if ($_FILES["foto"]["error"])
                echo "<span class='error'>* Error en la subida del archivo al servidor *</span>";
            elseif (!getimagesize($_FILES["foto"]["tmp_name"]))
                echo "<span class='error'>* Error: no has seleccionado un archivo imagen *</span>";
            else
                echo "<span class='error'>* Error: el tamaño del archico seleccionado supera los 500 KB *</span>";
        }
        echo "<br><br>";
        echo "<input type='submit' value='Cambiar foto' name='btnCambiarFoto'>";
        echo "</form>";
    } else {
        echo "<h1>Clientes</h1>";
        if (isset($_SESSION["accion"])) {
            echo "<p class='mensaje'>" . $_SESSION["accion"] . "</p>";
            unset($_SESSION["accion"]);
        }
        echo "<p class='mensaje'>" . $_SESSION["accion"] . "</p>";
        echo "<h2>Listado de clientes (no 'Admin')</h2>";
        $consulta = "SELECT * FROM clientes WHERE tipo='normal'";
        $resultado = mysqli_query($conexion, $consulta);
        if ($resultado) {
            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>usuario</th>";
            echo "<th>foto</th>";
            echo "<th></th>";
            echo "</tr>";
            while ($datos = mysqli_fetch_assoc($resultado)) {
                echo "<tr>";
                echo "<td>" . $datos["usuario"] . "</td>";
                echo "<td><img src='Images/" . $datos["foto"] . "'</tr>";
                echo "<td> <form class='enlinea' method='post' action='clientes.php'><button class='sin_boton' type='submit' name='btnEditar' value='".$datos["id_cliente"]."'>Editar</button><input type='hidden' name='foto' value='" . $datos["foto"] . "'/>-";
                echo "<br><button class='sin_boton' type='submit' name='btnBorrar' value='".$datos["id_cliente"]."'>Borrar</button><input type='hidden' name='foto' value='" . $datos["foto"] . "'/></form></td>";
                echo "</tr>";
            }
            echo "</table>";
        }

        echo "<h1>Agregar Usuario</h1>";
        echo "<form  method='post' action='clientes.php' enctype='multipart/form-data'>";
        echo "<label for='usuario'>Nombre del Usuario</label><br>";
        echo "<input type='text' name='usuario' id='usuario'>";
        if (isset($_POST["btnNuevoCliente"]) && $error_usuario) {
            if ($_POST["usuario"] == "")
                echo "<span class='error'> * Campo Vacío * </span>";
            else
                echo "<span class='error'> * Usuario repetido * </span>";
        }
        echo "<br>";
        echo "<label for='clave'>Clave del Usuario</label><br>";
        echo "<input type='password' name='clave' id='clave'>";
        if (isset($_POST["btnNuevoCliente"]) && $error_clave) {
            echo "<span class='error'> * Campo Vacío * </span>";
        }
        echo "<br>";
        echo "<label for='foto'>Foto:</label>";
        echo "<input type='file' name='foto' accept='image/*' />";
        if (isset($_POST["btnNuevoCliente"]) && $error_foto) {
            if ($_FILES["foto"]["error"])
                echo "<span class='error'>* Error en la subida del archivo al servidor *</span>";
            elseif (!getimagesize($_FILES["foto"]["tmp_name"]))
                echo "<span class='error'>* Error: no has seleccionado un archivo imagen *</span>";
            else
                echo "<span class='error'>* Error: el tamaño del archico seleccionado supera los 500 KB *</span>";
        }
        echo "<br>";
        echo "<input type='submit' value='Agregar Cliente' name='btnNuevoCliente'>";
        echo "</form>";

        if(isset($_POST["btnEditar"])){
            echo "<h1>Editar usuario</h1>";
            echo "<form  method='post' action='clientes.php' enctype='multipart/form-data'>";
            echo "<label for='usuario'>Nombre del Usuario</label><br>";
            echo "<input type='text' name='usuario' id='usuario'>";
            if (isset($_POST["btnEditarCliente"]) && $error_usuario) {
                if ($_POST["usuario"] == "")
                    echo "<span class='error'> * Campo Vacío * </span>";
                else
                    echo "<span class='error'> * Usuario repetido * </span>";
            }
            echo "<br>";
            echo "<label for='clave'>Clave del Usuario</label><br>";
            echo "<input type='password' name='clave' id='clave'>";
            if (isset($_POST["btnEditarCliente"]) && $error_clave) {
                echo "<span class='error'> * Campo Vacío * </span>";
            }
            echo "<br>";
            echo "<label for='foto'>Foto:</label>";
            echo "<input type='file' name='foto' accept='image/*' />";
            if (isset($_POST["btnEditarCliente"]) && $error_foto) {
                if ($_FILES["foto"]["error"])
                    echo "<span class='error'>* Error en la subida del archivo al servidor *</span>";
                elseif (!getimagesize($_FILES["foto"]["tmp_name"]))
                    echo "<span class='error'>* Error: no has seleccionado un archivo imagen *</span>";
                else
                    echo "<span class='error'>* Error: el tamaño del archico seleccionado supera los 500 KB *</span>";
            }
            echo "<br>";
            echo "<input type='hidden' name='id_cliente' value='" . $_POST["btnEditar"] . "'/>";
            echo "<input type='submit' value='Editar Cliente' name='btnEditarCliente'>";
            echo "</form>";
            if($_POST["foto"]!=IMAGEN_DEFECTO){
                 echo "<img src='Images/".$_POST["foto"]."'>";
            echo "<form  method='post' action='clientes.php' >";
            echo "<input type='hidden' name='id_cliente' value='" . $_POST["btnEditar"] . "'/>";
            echo "<input type='submit' value='Borrarfoto' name='btnBorrarFotoCliente'>";
            echo "</form>";
            }
           
        }
    }
    ?>

</body>

</html>