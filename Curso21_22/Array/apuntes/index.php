<!DOCTYPE html>
<html lang="es">

<head>
<title> Mi primera pagina </title>
<meta charset="UTF-8"/>
</head>

<body>
    <?php
     $valor[1]= 18;
     $valor[2]= "hola";
     $valor[3]=false;
     $valor[4]=3.4;
     
     echo "<h1> Recorrido con for</h1>";

     for($i=0;$i<count($valor);$i++){
            echo "<p> En el indice" .$i. "se encuentra el valor :".$valor[$i]. "</p>";
     }
    
    var_dump($valor);
echo "<br/>  <br/>";
    unset($valor[2]);
    unset($valor[3]);
    $valor[6]=false;
    $valor[9]=3.4;
    $valor[]="Pepe";
    var_dump($valor);

        echo "<h1> Recorrido con foreach</h1>";

    foreach($valor as $i=>$item){
        echo "<p> En el indice" .$i. "se encuentra el valor :".$item. "</p>";
    }

    $poblacion["España"]["Palencia"]=800000;
    $poblacion["España"]["Valladolif"]=350000;
    $poblacion["España"]["Oviedo"]=120000;
    $poblacion["Francia"]["Pars"]=7000000;
    $poblacion["Francia"]["Lyon"]=210000;

    foreach($poblacion as $pais=>$ciudades){
        echo"<h2> Poblaciones de ".$pais. ": </h2>";
        echo "<ol>";
        foreach($ciudades as $poblaciones=> $habitantes){
echo "<li>".$poblaciones. ": " .$habitantes. "habitantes </li>";
        }
        echo "</ol>";
    }

    $capital=array( "Castilla y León"=>"Valladolid","Asturias"=>"Oviedo","Aragón"=>"Zaragoza"); 
   
   echo current($capital);
    next($capital);
    echo key($capital);
    echo end($capital);
    echo reset($capital);


   ?>
  
</body>

</html>