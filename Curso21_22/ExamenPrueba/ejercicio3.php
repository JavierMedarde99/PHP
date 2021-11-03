<?php
function subcadena($texto2){

}

function codifica(){

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
        
        for($i=0;$i<=ord("Z")-ord("A");$i++){
            $texto_cod=codifica($texto,$i);
            if(subcadena("FELIX",strlen("FELIX"),$texto_cod,strlen($texto_cod))){
 $fd2=fopen("descodificado.txt","w");
 $ultima_linea="este archivo fue codificado el dia: ".date("d/m/Y")."a las ".date("h:i:s");
fputs($fd2,$texto_cod);
fclose($fd2);
break;
           }
        }
        ?>
    </body>
</html>