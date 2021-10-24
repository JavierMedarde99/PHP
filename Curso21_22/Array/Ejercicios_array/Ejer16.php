<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejercicio 16</title>
<meta charset="UTF-8"/>
</head>

<body>
    <h1>Ejercicio 16</h1>
    
    <?php
    $numeros=array(5=>1, 12=>2,13=>56,"x"=>42);

    foreach($numeros as $valor){
echo "<p>".$valor."</p>";
    }

    echo "<p>".count($numeros)."</p>";

unset($numeros[5]);

    foreach($numeros as $valor){
echo "<p>".$valor."</p>";
    }

    foreach($numeros as $i=>$valor){
        unset($valor[$i]);
            }
            ?>
   
   
</body>

</html>