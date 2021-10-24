<?php
if(isset($_POST["btnEnviar"])){
    $error_numero1=$_POST["numero1"]=="" || !is_numeric($_POST["numero1"]);
    $error_numero2=$_POST["numero2"]=="" || !is_numeric($_POST["numero2"]);
    $errores= $error_numero1 || $error_numero2;
}
if(isset($_POST["btnEnviar"]) && !$errores){
?>
<!DOCTYPE html>
<html>
    <head>
        <title>SolucionEjer4</title>
        <meta charset="UTC-8"/>
    </head>
    <body>
        <?php
        echo "<p>El primer numero es ".$_POST["numero1"]. " y el segundo es ".$_POST["numero2"]."</p>";
        echo "<p>La suma de los dos numero es ".$_POST["numero1"]+$_POST["numero2"]."</p>";
        echo "<p>La resta de los dos numero es ".$_POST["numero1"]-$_POST["numero2"]."</p>";
        echo "<p>La producto de los dos numero es ".$_POST["numero1"]*$_POST["numero2"]."</p>";
        echo "<p>La cociente de los dos numero es ".$_POST["numero1"]/$_POST["numero2"]."</p>";
        echo "<p>La modulo de los dos numero es ".$_POST["numero1"]%$_POST["numero2"]."</p>";
        ?>
    </body>
</html>
<?php
}else{
?>


<!DOCTYPE html>
<html>
<head>
<title>Ejer4</title>
<meta cahrset="UTC-8"/>
</head>

<body>
 <form action="Ejer4.php" method="post">
 <label for="numero1">Introducir primer numero:</label>
<input type="text" name="numero1" id="numero1"/>

<br/>
<br/>

<label for="numero2">Introducir primer numero:</label>
<input type="text" name="numero2" id="numero2"/>

<br/>
<br/>

<input type="submit" name="btnEnviar" value="enviar" />

 </form>
<?php
}
?>
</body>

</html>