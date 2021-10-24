<!DOCTYPE html>
<html lang="es" >

<head>
<title> Ejemplo de Formulario</title>
<meta charset="UTF-8"/>
</head>

<body>
    <h2>Recibiendo datos...</h2>
    
    <?php
    
   

       

        echo "<p><strong>Nombre:  </strong>".$_POST["nombre"]."</p>";
        echo "<p><strong>Apellidos:  </strong>".$_POST["apellidos"]."</p>";
        echo "<p><strong>Contraseña:  </strong>".$_POST["contraseña"]."</p>";
        echo "<p><strong>DNI:  </strong>".$_POST["dni"]."</p>";
        if(isset($_POST["sexo"])){
        echo "<p><strong>Sexo:  </strong>".$_POST["sexo"]."</p>";
        }
        echo "<p><strong>Subcrito al boletin:  </strong>";
        if($_POST["subs"]){
        echo "si";
        }else{
        echo "no";
        }
        echo "</p>";
        echo "<p><strong>Comentarios:  </strong>".$_POST["comentarios"]."</p>";
        echo "<p><strong>Nacido:  </strong>".$_POST["nacido"]."</p>";
    ?>
</html>


