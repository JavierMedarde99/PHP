

<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejercicio 7</title>
<meta charset="UTF-8"/>
</head>

<body>
    <h1>Ejercicio 7</h1>
    
    <?php
        $ciudades[]="Madrid";
        $ciudades[]="Barcelona";
        $ciudades[]="Londres";
        $ciudades[]="New York";
        $ciudades[]="Los Angeles";
        $ciudades[]="Chicago";

        echo "<p>";
        foreach($ciudades as $i=>$valor){
            echo "La ciudad con el indice ".$i. " tiene el nombre ".$valor. "<br/>";
        }
        echo "</p>"
    ?>
   
</body>

</html>