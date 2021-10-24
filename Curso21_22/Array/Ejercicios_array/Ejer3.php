
<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejercicio 3</title>
<meta charset="UTF-8"/>
</head>

<body>
    <h1>Ejercicio 3</h1>
    
    <?php
        $pelis['enero']=9;
        $pelis['febrero']=12;
        $pelis['marzo']=0;
        $pelis['abril']=17;

        echo "<p>";
        foreach($pelis as $i=>$valor){
            if($valor==0){
                echo "";
            }else{
                echo "El mes de ".$i." ha visto ".$valor. "<br/>";
        }
            
        }
        echo "</p>";
    ?>
    
   
</body>

</html>