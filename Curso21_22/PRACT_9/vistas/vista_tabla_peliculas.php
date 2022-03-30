<?php
if (isset($accion))
        echo "<p>" . $accion . "</p>";

    $consulta = "SELECT * FROM peliculas";
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {
        echo '<table class="centrar">
            <tr>
            <th>id</th>
            <th>titulo</th>
                <th>Carátula</th>
                <th><form action="index.php" method="post"><input class="sin_boton" type="submit" name="btnNuevo" value="Peliculas+"/></form></th>
                </tr>';
        while ($datos = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>" . $datos["idPeliculas"] . "</td>";
            echo "<td><form method='post' action='index.php'><button class='sin_boton' name='btnListar' value='" . $datos["idPeliculas"] . "'>" . $datos["titulo"] . "</button></form></td>";
            echo "<td><img src='Img/" . $datos["caratula"] . "' alt='Foto pelicula " . $datos["idPeliculas"] . "' title='Foto pelicula " . $datos["idPeliculas"] . "'/></td>";
            echo "<td><form class='enlinea' action='index.php' method='post'><button class='sin_boton' name='btnBorrar' value='" . $datos["idPeliculas"] . "'>Borrar</button><input type='hidden' name='foto' value='" . $datos["caratula"] . "'/></form> - <form class='enlinea' action='index.php' method='post'><button class='sin_boton' name='btnEditar' value='" . $datos["idPeliculas"] . "'>Editar</button></form></td>";
            echo "</tr>";
        }
        echo "</table>";
        mysqli_free_result($resultado);
    } else {
        $error = "<p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p></body></html>";
        mysqli_close($conexion);
        die($error);
    }
    ?>