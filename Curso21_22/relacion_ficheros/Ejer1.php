<?php
if(isset($_POST["btnEnviar"])){
    $errorNum=$_POST["num"]=="" || !is_numeric($_POST["num"]) || $_POST["num"]<1 || $_POST["num"]>10;
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ejercicio Fichero 1</title>
    <meta charset="UTF-8"/>
</head>
<body>
    <h1>Ejercicio 1 Fichero</h1>
    <form action="Ejer1.php" method="post">

    <p>
        <label for="num">Introduzca un numero del 1 al 10 (ambos incluidos): </label>
        <input type="text" name="num" id="num" value="<?php if(isset($_POST["num"])) echo$_POST["num"] ?>" size="5"/>
   
   <?php

if(isset($_POST["btnEnviar"]) && $errorNum){
    if($_POST["num"]==""){
        echo "*campo vacio";
    }else{
      echo "el numero no es correcto";  
    }
    
}
?>

    
    </p>


    <p><button type="submit" name="btnEnviar">Crear</button></p>
    </form>
    <?php
    if(isset($_POST["btnEnviar"]) && !$errorNum){
        @$fd=fopen("Tablas/tabla_".$_POST["num"].".txt","w");
    
        if(!$fd)
            die("<p>NO se ha podido crear/abrir el fichero <em>'Tablas/tabla_".$_POST["num"].".txt'</em> </p>");
    
            for($i=1;$i<=10;$i++){
                $line = $i." X ".$_POST["num"]." = ".($i*$_POST["num"].PHP_EOL);
                fputs($fd,$line);
            }
            fclose($fd);
            echo "<h2>Archivo generado con exito: <a href='"."Tablas/tabla_".$_POST["num"].".txt"."'>"."tabla_".$_POST["num"].".txt"."</a></h2>";
    
        }
    ?>
</body>
</html>