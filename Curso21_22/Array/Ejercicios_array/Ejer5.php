

<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejercicio 5</title>
<meta charset="UTF-8"/>
</head>

<body>
    <h1>Ejercicio 5</h1>
    
    <?php
        $persona['nombre']="Pedro Torres";
        $persona['direccion']="C/Mayor, 37";
        $persona['telefono']="123456789";
       
        echo "<p>";
        foreach($persona as $i=>$valor){
            echo $i. ":".$valor. "<br/>";
        }
        echo "</p>"
    ?>
   
</body>

</html>