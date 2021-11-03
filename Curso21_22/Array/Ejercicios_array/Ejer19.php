<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejercicio 19</title>
<meta charset="UTF-8"/>
</head>

<body>
    <h1>Ejercicio 19</h1>
    
    <?php
  $pedro=array("edad"=>32,"Tlf"=>"91-9999999");
  $antonio=array("edad"=>32,"Tlf"=>"00-9999999");
  $manu=array("edad"=>32,"Tlf"=>"91.9999999");
  $madrid=array("Pedro"=>$pedro,"Antonio"=>$antonio,"manu"=>$manu);
  $susana=array("edad"=>34,"Tlf"=>"93.000000");
  $barcelona=array("Susana"=>$susana);
  $pepe=array("edad"=>42,"Tlf"=>"95259548");
  $angie=array("edad"=>43,"Tlf"=>"95123448");
  $pablo=array("edad"=>41,"Tlf"=>"9525004548");
  $toledo=array("Pepe"=>$pepe, "Angie"=>$angie, "Pablo"=>$pablo);
  $array=array("Madrid"=>$madrid,"Barcelona"=>$barcelona,"Toledo"=>$toledo);

  foreach($array as $num=>$ciudades){
    echo "<p>Amigos en ".$num.":</p><ol>";
    foreach($ciudades as $ciudades=>$valor){
echo "<li><strong>Nombre: </strong>".$ciudades."<strong>Edad: </strong>".$valor["edad"]."
<strong>Telefono: </strong>".$valor["Tlf"]."</li>";
    }
    echo "</ol>";
  }
    ?>
   
   
</body>

</html>