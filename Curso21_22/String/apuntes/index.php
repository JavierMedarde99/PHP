<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejercicio 16</title>
<meta charset="UTF-8"/>
</head>

<body>
    <h1>Ejercicio 4</h1>
    
    <?php
    function mi_strlen($texto){
        $long=0;
        while(isset($texto[$long])){
            $long++;
            return $long;
        }
    }



 $hola='Esto es un saludo';

 $adios="esto es una despedida";

 $adios=$adios." mas texto";

 echo $adios."<br/>";

 echo $adios[5]."<br/>";

 echo strlen($adios)."<br/>";
 echo mi_strlen($adios)."<br/>";

 echo strtoupper($adios)."<br/>";

 echo strtolower($adios)."<br/>";

 $s="soy una frase, con unas, cuentas, comas";
 $a=explode(",",$s);
 var_dump($a);
    ?>
   
   
</body>

</html>