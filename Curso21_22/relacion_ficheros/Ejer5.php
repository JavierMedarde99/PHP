<?php
function escribir_fila_tabla($linea,$n_columnas){
    $fila=explode("\t",$linea);
    echo "<tr aling='center'>";
    for($i=0;$i<$n_columnas;$i++){
if(isset($fila[$i])){
echo "<td>".$fila[$i]."</td>";

    }else{
echo "<td>--</td>";
    }
}
echo "</tr>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ejercicio Fichero 2</title>
    <meta charset="UTF-8"/>
</head>
<body>
<?php
@$fd =fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt","r");
if(!$fd){
die("no se ha abierto");
}

echo "<h1>Resultado:</h1>";
$primera_fila=fgets();
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