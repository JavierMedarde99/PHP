<!DOCTYPE html>
<html>
<head>
<title>Teoria Fichero de Texto</title>
<meta cahrset="UTC-8"/>
</head>
<body>

<?php
/*
@$fd=fopen("prueba.txt","r");//"w" y "a"

if(!$fd){
    die("<p>No se ha encontrado el fichero de prueba.txt </p>");
}
*/

/*
$line=fgets($fd);
echo "<p>".$line."</p>";
*/


/*
//forma principal de recorrer un fichero
while($line=fgets($fd))
echo "<p>".$line."</p>";

fseek($fd,0);

echo "<h2>recorremos el fichero de nuevo</h2>";
//forma dos de recorrer un fichero
while (!feof($fd)){
$line=fgets($fd);
echo "<p>".$line."</p>";
}
fclose($fd);*/

$fd=fopen("prueba1.txt","w");
if(!$fd){
    die("<p>No se ha encontrado el fichero de prueba1.txt </p>");
}
fputs($fd,"Escribe una nueva linea".PHP_EOL);
fwrite($fd,"Escribe otra linea".PHP_EOL);
fclose($fd);


$fd=fopen("prueba1.txt","a");
if(!$fd){
    die("<p>No se ha encontrado el fichero de prueba1.txt </p>");
}

fputs($fd,"Escribe una nueva linea".PHP_EOL);
fwrite($fd,"Escribe otra linea".PHP_EOL);
fclose($fd);

echo "<h2>Escribimos el fichero de tiron</h2>";
$texto=file_get_contents("prueba1.txt");
echo nl2br($texto);

echo "<h2>Escribimos la web de Google</h2>";
$texto=file_get_contents("https://www.youtube.com");
echo nl2br($texto);

?>
    
</body>

</html>