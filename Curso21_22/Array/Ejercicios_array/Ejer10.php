<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejercicio 10</title>
<meta charset="UTF-8"/>
</head>

<body>
    <h1>Ejercicio 10</h1>
    
    <?php
    
    $cont;
$n=0;
    for($i=1;$i<=10;$i++)
        $enteros[$i-1]=$i;
       
        for($i=0;$i<count($enteros) ;$i+=2){
        $n+=$enteros[$i];
            
        }
        $media = $n/count($enteros);
        echo "<p>La media es: " .$media. "</p>";

        for($i=1;$i<count($enteros) ;$i+=2){
            
                echo "<p>".$enteros[$i]."</p>";
            }

    ?>
   
</body>

</html>