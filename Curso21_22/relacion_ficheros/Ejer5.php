<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ejercicio Fichero 2</title>
    <meta charset="UTF-8"/>
</head>
<body>
<?php
$texto=file_get_contents("http://dwese.icarosproject.com/PHP/datos_ficheros.txt");

$textoEntero= nl2br($texto);
echo"<table border='1' solid>" ;
echo "<tr>";
for($i=0; $i<strlen($textoEntero);$i++){
    echo "<td>".$textoEntero[$i]."</td>";
    }
    echo "</tr>";
echo "</table>";
?>
</body>
</html>