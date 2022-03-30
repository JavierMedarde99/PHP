<?php
define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_teoria");
@$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
if (!$conexion)
    die(error_page("Práctica 9 - CRUD", "<h1>Pŕactica 9</h1><p>Error en la conexión Nº: " . mysqli_connect_errno() . " : " . mysqli_connect_error() . "</p>"));

mysqli_set_charset($conexion, "utf8");

//boton para cambiar la notas
if (isset($_POST["btnNotas"])) {
    $consulta = "UPDATE notas SET notas=".$_POST["notas"]." WHERE cod_alu=".$_POST["cod_alu"]." AND cod_asig=".$_POST["cod_asig"];
    $resultado= mysqli_query($conexion,$consulta);
    if($resultado){
        $accion="nota actualizada";
    }else{
        $error = "<p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p></body></html>";
            mysqli_close($conexion);
            die($error);
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .sin_boton {
            background: transparent;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer
        }

        .centrar {
            text-align: center
        }

        table,
        th,
        td {
            border: 1px solid black
        }

        table {
            border-collapse: collapse;
            width: 30%
        }
    </style>
    <title>PrecticaNueva</title>
</head>

<body>
    <h1>Práctica Nueva de Clase</h1>
    <h3>Listado de los alumnos</h3>
    <?php
    if (isset($accion))
    echo "<p>" . $accion . "</p>";
    //lista
    $consulta = "SELECT * FROM alumnos";
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {
        echo "<ol>";
        while ($datos = mysqli_fetch_assoc($resultado)) {
            echo "<li><form action='index.php' method='post'><button class='sin_boton' name='btnListar' value='" . $datos["cod_alu"] . "'>" . $datos["nombre"] . "</button></form></li>";
        }
        echo "</ol>";
        mysqli_free_result($resultado);
    } else {
        $error = "<p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p></body></html>";
        mysqli_close($conexion);
        die($error);
    }


    // listar los datos
    if (isset($_POST["btnListar"])) {
        $consulta = "SELECT * FROM alumnos WHERE cod_alu =" . $_POST["btnListar"];
        $resultado = mysqli_query($conexion, $consulta);
        if ($resultado) {
            echo "<h1>Detalles del usuario " . $_POST["btnListar"] . "</h1>";
            while ($datos = mysqli_fetch_assoc($resultado)) {
                echo "<p><strong>Nombre:</strong>" . $datos["nombre"] . "</p>";
                echo "<p><strong>Telefono:</strong>" . $datos["telefono"] . "</p>";
                echo "<p><strong>Codigo Postal:</strong>" . $datos["cp"] . "</p>";
                echo "<p><strong>Notas:</strong></p>";
            }
            $consulta = "SELECT asignaturas.denominacion,notas.notas FROM asignaturas,notas WHERE asignaturas.cod_asig=notas.cod_asig AND notas.cod_alu=" . $_POST["btnListar"];
            $resultado = mysqli_query($conexion, $consulta);
            if ($resultado) {
                echo "<table class='centrar'>";
                echo "<tr>";
                echo "<th>Asignatura</th>";
                echo "<th>Notas</th>";
                echo "</tr>";
                while ($datos = mysqli_fetch_assoc($resultado)) {

                    echo "<tr>";
                    echo "<td>" . $datos["denominacion"] . "</td>";
                    echo "<td><form action='index.php' method='post'><select name='notas' id='notas'>";
                    for ($i = 0; $i < 11; $i++) {
                        echo "<option value=" . $i . " ";
                        if ($i == $datos["notas"])
                            echo "selected";
                        echo ">" . $i . "</option>";
                    }
                    echo "</select> 
                    <input type='hidden' name='cod_alu' value='".$datos["cod_alu"]."'/>
                     <input type='hidden' name='cod_asig' value='".$datos["cod_asig"]."'/> 
                     <input type='submit' value='CambiarNota' name='btnNotas'></form></td>";
                    echo "</tr>";
                }
                echo "</table>";
                mysqli_free_result($resultado);
            } else {
                $error = "<p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p></body></html>";
                mysqli_close($conexion);
                die($error);
            }
        } else {
            $error = "<p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p></body></html>";
            mysqli_close($conexion);
            die($error);
        }
    }
    ?>
</body>

</html>