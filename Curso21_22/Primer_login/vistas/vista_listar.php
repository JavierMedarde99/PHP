<?php
echo "<h2>Detalles del usuario ".$_POST["btnListar"]."</h2>";
        $consulta="select * from usuarios where id_usuario=".$_POST["btnListar"];
        $resultado=mysqli_query($conexion,$consulta);
        if($resultado)
        {
            if($datos=mysqli_fetch_assoc($resultado))
            {
                echo "<div id='listar'><div><p><strong>Nombre: </strong>".$datos["nombre"]."</p>";
                echo "<p><strong>Usuario: </strong>".$datos["usuario"]."</p>";
                echo "<p><strong>Contraseña: </strong></p>";
                echo "<p><strong>DNI: </strong>".$datos["dni"]."</p>";
                echo "<p><strong>Sexo: </strong>".$datos["sexo"]."</p></div>";
                echo "<div><img src='Img/".$datos["foto"]."' alt='Foto del Usuario ".$datos["id_usuario"]."' title='Foto del Usuario ".$datos["id_usuario"]."'/></div></div>";
            }
            else
            {
                echo "<p>El usuario seleccionado ya no se encuentra registrado en la BD</p>";
            }
            echo "<form action='index.php' method='post'><input type='submit' value='Atrás'/></form>";
        }
        else
        {
            $error="<p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p></body></html>";
            mysqli_close($conexion);
            die($error);
        }
        ?>