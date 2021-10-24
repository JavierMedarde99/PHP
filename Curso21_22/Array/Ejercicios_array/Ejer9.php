
<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejercicio 9</title>
<meta charset="UTF-8"/>
</head>

<body>
    <h1>Ejercicio 9</h1>
    
    <?php
        $lenguajes_clientes=array("LC1"=>"JS","LC2"=>"HTML","LC3"=>"java");
        $lenguajes_servidor=array("LS1"=>"PHP","LS2"=>"Apache","LS3"=>"MySQL");

    
$lenguajes=$lenguajes_clientes;

foreach($lenguajes_servidor as $i=>$valor){
$lenguajes[$i]=$valor;
}
echo "<table>";
echo "<tr><th>Lenguajes</th></tr>";
foreach($lenguajes as $i=>$valor){
echo "<tr><td>".$valor."</td> </tr>";

}
 echo "</table>";
    ?>
   
</body>

</html>