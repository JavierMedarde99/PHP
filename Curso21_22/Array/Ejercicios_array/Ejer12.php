<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejercicio 12</title>
<meta charset="UTF-8"/>
</head>

<body>
    <h1>Ejercicio 12</h1>
    
    <?php
    
    $arr1=["Lagartija","Araña", "Perro","Gato","Raton"];
    $arr2=["12","34", "45","52","12"];
    $arr3=["Sauce","Pino", "Naranjo","Chopo","Perro", "34"];
    array_push($arr1,$arr2);
    array_push($arr1,$arr3);
    print_r($arr1);



    ?>
   
</body>

</html>