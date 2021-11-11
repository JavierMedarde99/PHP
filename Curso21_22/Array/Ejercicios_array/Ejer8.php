

<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejercicio 8</title>
<meta charset="UTF-8"/>
</head>

<body>
    <h1>Ejercicio 8</h1>
    
    <?php
        $nombres[]="Pedro";
        $nombres[]="Ismael";
        $nombres[]="Sonia";
        $nombres[]="Clara";
        $nombres[]="Susana";
        $nombres[]="Alfonso";
        $nombres[]="Teresa";

echo "<p> El total de elementos son : ".count($nombres)."</p>";

        echo "<ul>";
        foreach($nombres as $i=>$valor){
            echo "<li>" .$valor."</li>";
        }
        echo "</ul>"
    ?>
   
</body>

</html>