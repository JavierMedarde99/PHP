<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoria BD PHP</title>
</head>
<body>
    <?php
    
    @$conexion=mysqli_connect("localhost","jose","josefa","bd_teoria");
    if(!$conexion)
        die("Imposible conectar. Error Numero: ".mysqli_connect_errno()." : ".mysqli_connect_error());

    mysqli_set_charset($conexion,"utf8");

    $consulta="SELECT * FROM alumnos";
    $resultado=mysqli_query($conexion,$consulta);
    if($resultado){

        $n_tuplas=mysqli_num_rows($resultado);

        echo "<p>El numero de alumnos en la BD es: ".$n_tuplas." </p>";
        
        $datos=mysqli_fetch_row($resultado);
        echo "<p>".$datos[2]."</p>";
       
        $datos=mysqli_fetch_assoc($resultado);
        echo "<p>".$datos["telefono"]."</p>";

        $datos=mysqli_fetch_array($resultado);
        var_dump($datos);

        mysqli_data_seek($resultado,0);

        //Proximamente: $datos=mysqli_fetch_object($resultado);
        // echo "<p>".$datos->telefono."</p>";

        mysqli_free_result($resultado); 
        mysqli_close($conexion);
    }else{

        $error ="<p>Imposible realizar la consulta. Error Numero: ".mysqli_errno($conexion)." : ".mysqli_error($conexion)."</p>";
        mysqli_close($conexion);
        die($error);

    }



  
    ?>
</body>
</html>