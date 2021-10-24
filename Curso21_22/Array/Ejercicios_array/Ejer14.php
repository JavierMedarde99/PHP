<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejercicio 14</title>
<meta charset="UTF-8"/>
</head>

<body>
    <h1>Ejercicio 14</h1>
    
    <?php
      $stadios_futbol=array("Barcelona"=>"CampNou", "Real Madrid"=>"Santiago Bernabeu",
      "Valencia"=>"Mestalla","Real Sociedad"=>"Anoeta");

echo "<table>";
foreach($stadios_futbol as $i=>$valor){
echo "<tr><td>".$i."</td> <td>".$valor."</td></tr>";

}
 echo "</table>";

 unset($stadios_futbol["Real Madrid"]);

 echo "<ol>";
 foreach($stadios_futbol as $i=>$valor){
    echo "<li>".$valor."</li>";
    }
 echo"</ol>";
    ?>
   
</body>

</html>