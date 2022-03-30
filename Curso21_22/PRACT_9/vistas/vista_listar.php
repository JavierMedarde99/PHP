<?php
echo "<h2>Detalles de la pelicula " . $_POST["btnListar"] . "</h2>";
        $consulta = "SELECT * FROM peliculas WHERE idPeliculas=" . $_POST["btnListar"];
        $resultado = mysqli_query($conexion, $consulta);
        if ($resultado) {
            if ($datos = mysqli_fetch_assoc($resultado)) {
                echo "<div id='listar'><div><p><strong>Titulo: </strong>" . $datos["titulo"] . "</p>";
                echo "<p><strong>Director: </strong>" . $datos["director"] . "</p>";
                echo "<p><strong>Sinopsis: </strong>" . $datos["sinopsis"] . "</p>";
                echo "<p><strong>Tematica: </strong>" . $datos["tematica"] . "</p></div>";
                echo "<div><img src='Img/" . $datos["caratula"] . "' alt='Foto de la pelicula " . $datos["idPeliculas"] . "' title='Foto de la pelicula " . $datos["idPeliculas"] . "'/></div></div>";
            } else {
                echo "<p>El usuario seleccionado ya no se encuentra registrado en la BD</p>";
            }
            echo "<form action='index.php' method='post'><input type='submit' value='Atrás'/></form>";
        } else {
            $error = "<p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p></body></html>";
            mysqli_close($conexion);
            die($error);
        }
        ?>