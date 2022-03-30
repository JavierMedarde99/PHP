<?php
echo "<h3>Listado de los usuarios</h3>";
$consulta = "select * from usuarios";
$resultado = mysqli_query($conexion, $consulta);
if ($resultado) {
    echo '<table class="centrar"><tr>
        <th>#</th>
        <th>Foto</th>
            <th>Nombre</th>
            <th><form action="index.php" method="post"><input class="sin_boton" type="submit" name="btnNuevo" value="Usuario+"/></form></th>
            </tr>';
    while ($datos = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        echo "<td>" . $datos["id_usuario"] . "</td>";
        echo "<td><img src='Img/" . $datos["foto"] . "' alt='Foto usuario " . $datos["id_usuario"] . "' title='Foto usuario " . $datos["id_usuario"] . "'/></td>";
        echo "<td><form method='post' action='index.php'><button class='sin_boton' name='btnListar' value='" . $datos["id_usuario"] . "'>" . $datos["nombre"] . "</button></form></td>";
        echo "<td><form class='enlinea' action='index.php' method='post'><button class='sin_boton' name='btnBorrar' value='" . $datos["id_usuario"] . "'>Borrar</button><input type='hidden' name='foto' value='" . $datos["foto"] . "'/></form> - <form class='enlinea' action='index.php' method='post'><button class='sin_boton' name='btnEditar' value='" . $datos["id_usuario"] . "'>Editar</button></form></td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($resultado);
    mysqli_close($conexion);
} else {
    $error = "<p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p></body></html>";
    mysqli_close($conexion);
    die($error);
}
