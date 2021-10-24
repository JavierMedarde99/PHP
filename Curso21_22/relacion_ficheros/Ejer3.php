<?php
if(isset($_POST["btnEnviar"])){
    $errorNum=$_POST["num"]=="" || !is_numeric($_POST["num"]) || $_POST["num"]<1 || $_POST["num"]>10;
    $errorNum2=$_POST["num2"]=="" || !is_numeric($_POST["num2"]) || $_POST["num2"]<1 || $_POST["num2"]>10;
    $errores= $errorNum || $errorNum2;
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ejercicio Fichero 3</title>
    <meta charset="UTF-8"/>
</head>
<body>
    <h1>Ejercicio 3 Fichero</h1>
    <form action="Ejer3.php" method="post">

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

    <p>
        <label for="num2">Introduzca otro numero del 1 al 10 (ambos incluidos): </label>
        <input type="text" name="num2" id="num2" value="<?php if(isset($_POST["num2"])) echo$_POST["num2"] ?>" size="5"/>
   
   <?php

if(isset($_POST["btnEnviar"]) && $errorNum2){
    if($_POST["num2"]==""){
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
    if(isset($_POST["btnEnviar"]) && !$errores){
        @$fd=fopen("Tablas/tabla_".$_POST["num"].".txt","r");
    
        if(!$fd)
            die("<p>NO se ha podido leer el fichero <em>'Tablas/tabla_".$_POST["num"].".txt'</em> </p>");
    
            while($line=fgets($fd)){
            if($_POST["num2"] == substr($line,0,1)){
                 echo "<p>".$line."</p>"; 
            }
          
            }
            fseek($fd,0);

            fclose($fd);
            
    
        }
    ?>
</body>
</html>