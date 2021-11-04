<?php
    require "src/config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer CRUD</title>
    <style>
        .centrar{text-align: center;}
        table,th,td{border:1px solid black}
        table{border-collapse: collapse;width: 60%;margin: 0 auto;}
        .form_nuevo{width: 60%; margin: 1.5px auto; }
   </style>
</head>
<body>
    <h1 class="centrar">Listado de usuarios </h1>
    
       
            
           
            
        
<?php
 @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NAME_BD);
 if(!$conexion)
     die("Imposible conectar. Error Numero: ".mysqli_connect_errno()." : ".mysqli_connect_error());

     mysqli_set_charset($conexion,"utf8");

     $consulta="SELECT * FROM usuarios";
     $resultado=mysqli_query($conexion,$consulta);

     if($resultado){
echo "<table>";
echo " <tr>";
echo "<th>Nombre de Usuario</th>";
echo " <th>borar</th>";
echo "<th>editar</th>";
echo "</tr>";
        while($datos=mysqli_fetch_assoc($resultado)){
             echo "<tr>";
        echo "<td>".$datos["nombre"]."</td>";
        echo "<td><img src='imagenes/borrar.png' title='Borrar usuario' alt='Borrar'></td>";
        echo "<td><img src='imagenes/editar.png' title='Editar usuario' alt='Borrar'></td>";
        echo "</tr>";
        }
        echo "</table>";

        mysqli_free_result($resultado); 
        mysqli_close($conexion);

    }else{

        $error ="<p>Imposible realizar la consulta. Error Numero: ".mysqli_errno($conexion)." : ".mysqli_error($conexion)."</p>";
        mysqli_close($conexion);
        die($error);

    }   
?>

<form clas="form_nuevo" action="usuario_nuevo.php" method="post">
<input type="submit" value="Insertar nuevo Usuario" name="btnNuevo">

</form>
</table>
</body>
</html>