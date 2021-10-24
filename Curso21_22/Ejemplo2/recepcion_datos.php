<?php 
 if(isset($_POST["nombre"])){

    $nombre=$_POST["nombre"];
    $apellidos=$_POST["apellidos"];
    $contraseña=$_POST["contraseña"];
    $dni=$_POST["dni"];
} else{
    header("Location:Index.php");

}

?>


<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejemplo de Formulario</title>
<meta charset="UTF-8"/>
</head>

<body>
    <h2>Recibiendo datos...</h2>
    
    <?php
    
    /*
    //array asociativo (por nombre)
     //esto es para el metodo GET

        $nombre=$_GET["nombre"];
        $apellidos=$_GET["apellidos"];
        $contraseña=$_GET["contraseña"];
        $dni=$_GET["dni"];

        echo "<p><strong>Nombre:  </strong>".$nombre."</p>";
        echo "<p><strong>Apellidos:  </strong>".$apellidos."</p>";
        echo "<p><strong>Contraseña:  </strong>".$contraseña."</p>";
        echo "<p><strong>DNI:  </strong>".$dni."</p>";

*/

        //para el metodo post 

       

        echo "<p><strong>Nombre:  </strong>".$nombre."</p>";
        echo "<p><strong>Apellidos:  </strong>".$apellidos."</p>";
        echo "<p><strong>Contraseña:  </strong>".$contraseña."</p>";
        echo "<p><strong>DNI:  </strong>".$dni."</p>";
        
    ?>
   
   
</body>

</html>