<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejercicio 1</title>
<meta charset="UTF-8"/>
</head>

<body>
    <h1>Ejercicio 1</h1>
    
    <?php
        $pares = array(1,2,3,4,5,6,7,8,9,10);
        echo "<p>";
        for($i=0;$i<count($pares);$i++){
            echo $pares[$i]."<br/>";
        }
        echo "</p>";
    ?>
   
</body>

</html>