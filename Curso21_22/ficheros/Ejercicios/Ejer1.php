<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejer1 ficheros</title>
<meta charset="UTF-8"/>
</head>

<body>
    <?php
       function escribirNumerosMod($nums,$modo){

        if($modo =="sobreescribir")
        $modo="w";
        else
        $modo="a";

        @$fd=fopen("datosEjercicio.txt",$modo);
        
        if(!$fd)
        die("no se ha podido abrir datosEjercicio.txt");
        
        for($i=0;$i<count($nums);$i++)
            fputs($fd,$nums[$i].PHP_EOL);    
        
        fclose($fd);
       }

       function leerContenidoFichero($ruta){
        @$fd=fopen($ruta,"r");
        
        if(!$fd)
        die("no se ha podido abrir".$ruta);

        echo "<p>";
        while($linea=fgets($fd))
        echo $linea."</br>";

        echo "</p>";
        fclose($fd);
        
       }

       $arraynum=[2,8,14];

       escribirNumerosMod($arraynum,"sobreescribir");

       leerContenidoFichero("datosEjercicio.txt");

       escribirNumerosMod([33,11,16],"ampliar");

       leerContenidoFichero("datosEjercicio.txt");

       escribirNumerosMod([4,99,12],"sobreescribir");

       leerContenidoFichero("datosEjercicio.txt");

       echo "<p>Ahora os toca hacer la relacion de 6 ejercicios</p>";
      
    ?>
   
</body>

</html>