<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejercicio 18</title>
<meta charset="UTF-8"/>
</head>

<body>
    <h1>Ejercicio 18</h1>
    
    <?php
        $deportes=array("futbol","baloncesto","natacion","tenis");
echo "<p>";
        for($i=0;$i< count($deportes);$i++){
echo $deportes[$i]." , ";
        }
echo "</p>";

echo "<p>";
echo "total: ".count($deportes)."</br>";

echo "Primero: ".reset($deportes)."</br>";

echo "Siguente: ".next($deportes)."</br>";

echo "Ultimo: ".end($deportes)."</br>";

echo "Anterior: ".prev($deportes)."</br>";
    ?>
   
   
</body>

</html>