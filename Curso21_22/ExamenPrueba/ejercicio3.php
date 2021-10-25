<?php
function subcadena($texto2){

}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Ejercicio3</title>
        <meta charset="UTF-8" />
    </head>
    <body>
        <h1>Ejercicio3</h1>
        <?php
        @$fd=fopen("codificado.txt","r");
if(!$fd)
die("No se ha podido abrir codificado.txt");
        $texto= file_get_contents("codificado.txt");
        echo $texto;
        ?>
    </body>
</html>