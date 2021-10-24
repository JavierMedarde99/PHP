<?php
if(isset($_POST["btnEnviar"])){
    $error_texto1=$_POST["texto1"]=="";
    $error_texto2=$_POST["texto2"]=="" || strlen($_POST["texto1"])<strlen($_POST["texto2"]);
    $errores = $error_texto1 || $error_texto2;
}
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Ejercicio1</title>
        <meta charset="UTF-8" />
    </head>

    <body>

    <form action="ejercicio1.php" method="post">

        <label for="texto1">Primer texto:</label>
        <input type="text" name="texto1" id="texto1" value="<?php if(isset($_POST["texto1"])) echo $_POST["texto1"]?>" />
        <?php
        if(isset($_POST["btnEnviar"]) && $error_texto1){
            echo "* campo vacio *";
        }
        ?>
<br/>
<br/>
        <label for="texto2">Segundo texto:</label>
        <input type="text" name="texto2" id="texto2" value="<?php if(isset($_POST["texto2"])) echo $_POST["texto2"]?>" />
        <?php
        if(isset($_POST["btnEnviar"]) && $error_texto2){
            if($_POST["texto2"]==""){
                echo "* campo vacio *";
            }else{
                echo "la cadena tiene que ser mayor que la primera";
            }
            
        }
        ?>

<br/>
<br/>
        <button type="submit" name="btnEnviar"> Enviar</button>
    
    </form>

    <?php
    if(isset($_POST["btnEnviar"]) && !$errores){
if(strpos($_POST["texto1"],$_POST["texto2"])==false){
    echo "<p>La subcadena de ".$_POST["texto2"]." en el texto: ".$_POST["texto1"]." no se encuentra </p>";
}else{
    echo "<p>La subcadena de ".$_POST["texto2"]." en el texto: ".$_POST["texto1"]." si se encuentra </p>";
}
    }
    
    ?>
    </body>
</html>