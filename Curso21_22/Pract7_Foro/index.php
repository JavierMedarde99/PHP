<?php
    require "src/config.php";
    if(isset($_POST["insertado"]))
        $accion="Usuario insertado con éxito";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer CRUD - Index</title>
    <style>
        .centrar{text-align:center}
        .form_nuevo, .mensaje,.resultado{width:60%;margin:1.5em auto;}
        table,th,td{border:1px solid black}
        table{border-collapse:collapse; width:60%;margin:0 auto}
        .sin_boton{background:transparent;border:none;color:blue;text-decoration:underline;cursor:pointer}
    </style>
</head>
<body>
    <h1 class="centrar">Listado de los Usuarios</h1>
    
    <?php
    @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
    if(!$conexion)
        die("<p>Error en la conexión Nº: ".mysqli_connect_errno(). " : ".mysqli_connect_error()."</p></body></html>");
    mysqli_set_charset($conexion,"utf8");

    $consulta="select * from usuarios";

    $resultado=mysqli_query($conexion,$consulta);
    if($resultado)
    {
        echo "<table class='centrar'><tr><th>Nombre de Usuario</th><th>Borrar</th><th>Editar</th></tr>";

        while($datos=mysqli_fetch_assoc($resultado))
        {
            echo "<tr>";
            echo "<td><form action='index.php' method='post'><button class='sin_boton' name='btnListar' value='".$datos["id_usuario"]."'>".$datos["nombre"]."</button></form></td>";
            echo "<td><form action='index.php' method='post'><button class='sin_boton' name='btnBorrar' value='".$datos["id_usuario"]."'><img src='images/borrar.png' title='Borrar Usuario' alt='Borrar' /></button></form></td>";
            echo "<td><img src='images/editar.png' title='Editar Usuario' alt='Editar'/></td>";
            echo "</tr>";
        }
        echo "</table>";
        mysqli_free_result($resultado);
        mysqli_close($conexion);

        if(isset($accion))
            echo "<p class='mensaje'>".$accion."</p>";
        
            if(isset($_POST["btnBorrar"])){

        }


        if(isset($_POST["btnListar"]))
        {
            echo "<div class='resultado'";
            echo "<h2>Detalles del usuario".$_POST["btnListar"]."</h2>";
            $consulta = "SELECT * FROM usuarios WHERE id_usuario=".$_POST["btnListar"];
            $resultado=mysqli_query($conexion,$consulta);
            if($resultado){

                if($datos=mysqli_fetch_assoc($resultado)){
                     
                echo "<p><strong>Nombre :</strong>".$datos["nombre"]."</p>";
                echo "<p><strong>Nombre :</strong>".$datos["usuario"]."</p>";
                echo "<p><strong>Nombre :</strong>".$datos["email"]."</p>";
                
                }else{
                    echo "<p>El usuario seleccionado ya no se encuentra en la base de daros</p>";
                }
                mysqli_free_result($resultado);
               echo "<form action='index.php' method='post'><input type='submit' values='volver' /></form>";
                echo "</div>";
            }else{
                $error="<p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p></body></html>";
                mysqli_close($conexion);
                die($error);
            }
          
        }
        else 
        {    
        
        ?>
        <form class="form_nuevo" action="usuario_nuevo.php" method="post">
            <input type="submit" name="btnNuevo" value="Insertar nuevo Usuario"/>
        </form>
        <?php
        }
    }
    else
    {
        $error="<p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p></body></html>";
        mysqli_close($conexion);
        die($error);
    }

    ?>
  
</body>
</html>