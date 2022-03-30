<?php
if (isset($_POST["btnNuevoUsu"])) {
    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_email = $_POST["email"] == "" || !filter_var($_POST["email"],FILTER_VALIDATE_EMAIL);;

    $error_form = $error_nombre || $error_usuario || $error_clave || $error_email;
    if(!$error_form){
        $url = DIR_SERV . "/crearUsuario";
    $respuesta = consumir_servicios_REST($url, "POST");
    $obj = json_decode($respuesta);
    if (!$obj) {
        session_destroy();
        die("<p>Error xonsumiendo el servicio: " . $url . "</p>" . $respuesta);
    }
    if (isset($obj->error)) {
        session_destroy();
        die("<p>" . $obj->error . "</p></body></html>");
    }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SW</title>
    <style>
        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }

        .enlinea {
            display: inline
        }


        .centrar {
            text-align: center
        }

        .form_nuevo,
        .mensaje,
        .resultado {
            width: 60%;
            margin: 1.5em auto;
        }

        table,
        th,
        td {
            border: 1px solid black
        }

        table {
            border-collapse: collapse;
            width: 60%;
            margin: 0 auto
        }

        .sin_boton {
            background: transparent;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer
        }

        #form_pags {
            width: 60%;
            margin: 0 auto;
            text-align: center;
            margin-top: 0.5em
        }

        #form_pags button {
            margin: 0 0.25em
        }

        #form_reg_bus {
            width: 60%;
            margin: 0 auto;
            display: flex;
            justify-content: space-between
        }
    </style>

</head>

<body>
    <h1>Login SW</h1>
    <div>
        Bienvenido <strong><?php echo $_SESSION["usuario"]; ?></strong> - <form class="enlinea" method="post" action="index.php"><button class="enlace" name="btnCerrarSesion">Salir</button></form>
    </div>
    <?php
    $url = DIR_SERV . "/usuarios";
    $respuesta = consumir_servicios_REST($url, "GET");
    $obj = json_decode($respuesta);
    if (!$obj) {
        session_destroy();
        die("<p>Error xonsumiendo el servicio: " . $url . "</p>" . $respuesta);
    }
    if (isset($obj->error)) {
        session_destroy();
        die("<p>" . $obj->error . "</p></body></html>");
    }
    ?>
    <h2>Listado de usuarios (no admin)</h2>
    <table>
        <tr>
            <div>
                <th>Nombre del usuarios:
                    <form action="index.php" method="post">
                        <button name="btnNuevo">+</button>
                    </form>
            </div>
            </th>
            <th>Borrar</th>
            <th>Editar</th>
        </tr>
        <?php
        foreach ($obj->usuarios as $fila) {
            if ($fila->tipo == "normal") {
                echo "<tr><td><form action='index.php' method='post'><button name='btnListar' value='" . $fila->id_usuario . "'>" . $fila->nombre . "</button></form></td>
                <td><form action='index.php' method='post'><button name='btnBorrar' value='" . $fila->id_usuario . "'><img src='images/borrar.png' /></button></form></td>
                <td><form action='index.php' method='post'><button name='btnEditar' value='" . $fila->id_usuario . "'><img src='images/editar.png' /></button></form></td>";
            }
        }

        echo " </table>";

        if (isset($_POST["btnListar"])) {
            echo "<h2>Detalles del usuario " . $_POST["btnListar"] . "</h2>";
            foreach ($obj->usuarios as $fila) {
                if ($fila->id_usuario == $_POST["btnListar"]) {
                    echo "<p><strong>Nombre: </strong>" . $fila->nombre . "</p>";
                    echo "<p><strong>Usuario: </strong>" . $fila->usuario . "</p>";
                    echo "<p><strong>Email: </strong>" . $fila->email . "</p>";
                }
            }
            echo "<form action='index.php' method='post'><button >volver</button></form>";
        }

        if (isset($_POST["btnNuevo"]) || isset($_POST["btnNuevoUsu"]) && $error_form) {
            echo "<h2>Añadir usuario nuevo</h2>";
            echo "<form action='index.php' method='post'>";
            echo "<label for='nombre'>Nombre:</label>";
            if(isset($_POST["nombre"]))
             echo "<input type='text' id='nombre' name='nombre' value'".$_POST["nombre"]."'/>";
            else
           echo "<input type='text' id='nombre' name='nombre' />";
            if (isset($_POST["btnNuevoUsu"]) && $error_nombre) {
                echo "*Campo vacio*";
            }
            echo "<br/>";
            echo "<label for='usuario'>Usuario:</label>";
            if(isset($_POST["usuario"]))
            echo "<input type='text' id='usuario' name='usuario' value='".$_POST["usuario"]."' />";
            else
            echo "<input type='text' id='usuario' name='usuario' />";
            if (isset($_POST["btnNuevoUsu"]) && $error_usuario) {
                echo "*Campo vacio*";
            }
            echo "<br/>";
            echo "<label for='clave'>Contraseña:</label>";
            echo "<input type='text' id='clave' name='clave' />";
            if (isset($_POST["btnNuevoUsu"]) && $error_clave) {
                echo "*Campo vacio*";
            }
            echo "<br/>";
            echo "<label for='email'>Email:</label>";
            if(isset($_POST["email"]))
            echo "<input type='text' id='email' name='email' value='".$_POST["email"]."'/>";
            else
            echo "<input type='text' id='email' name='email' />";
            if (isset($_POST["btnNuevoUsu"]) && $error_email) {
                if($_POST["email"]==""){
                    echo "*Campo vacio*";
                }else{
                    echo "*No es un email*";
                }
                
            }
            echo "<br/>";
            echo "<input type='submit' value='Volver'/> <input type='submit' name='btnNuevoUsu' value='Enviar'/>";
            echo "</form>";
        }
        ?>
</body>

</html>