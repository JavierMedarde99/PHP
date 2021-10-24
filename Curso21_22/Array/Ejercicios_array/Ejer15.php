<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejercicio 15</title>
<meta charset="UTF-8"/>
</head>

<body>
    <h1>Ejercicio 15</h1>
    
    <?php
     $numeros= array("uno"=>3,"dos"=>2,"tres"=>8,"cuatro"=>123,
    "cinco"=>5,"seis"=>1);

    asort($numeros);

    echo "<table>";
foreach($numeros as $i=>$valor){
echo "<tr><td>".$i."</td> <td>".$valor."</td></tr>";

}
 echo "</table>";
    ?>
   
</body>

</html>