<?php


?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Ejercicio 6 Fichero</title>
        <meta charset="UTF-8" />
    </head>
    <body>
        <h1>Ejercicio 6 ficheros</h1>
        <form action="Ejer6.php" method="post">
       <select name="pais">
        <?php
           @$fd =fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt","r");
           if(!$fd)
           die("no se ha abierto");
           
           $linea=fgets($fd);
           while($linea=fgets($fd)){
               $datos=explode("\t",$linea);
               $array=explode(",",$datos[0]);
               $pais = end($array);
               if(isset($_POST["pais"]) && $_POST["pais"]==$pais)
               echo "<option value='".$pais."' selected>".$pais."</option>";
          else
          echo "<option value='".$pais."' >".$pais."</option>";
          
            }
        ?>

       </select>

       <input type="submit" value="PIB per Capita" name="btnGenerar"/>
        </form>
        <?php
        if(isset($_POST["btnGenerar"])){
            @$fd =fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt","r");
            if(!$fd)
            die("no se ha abierto");

            $linea=fgets($fd);
$datos=explode("\t",$linea);

            echo "<h1>Resultado:</h1>";

            echo "<table border='1'>";
            echo "<tr>";
            $n_columnas=count($datos);
for($i=0;$i<$n_columnas;$i++){
    echo "<th>".$datos[$i]."</th>";
}
            echo "</tr>";

            while( $linea=fgets($fd)){
                $datos=explode("\t",$linea);
                $array=explode(",",$datos[0]);
                $pais = end($array);
                if($_POST["pais"]==$pais){
                    echo"<tr>";
                    for($i=0;$i<$n_columnas;$i++){
                        if(isset($datos[$i]))
                        echo "<td>".$datos[$i]."</td>";
                        else
                        echo "<td>--</td>"; 
                    }
                        echo "</tr>";
                        break;
                }
            }
            echo "</table>";
            fclose($fd);
        }
        ?>
    </body>
</html>