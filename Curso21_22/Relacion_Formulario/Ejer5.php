<?php
if(isset($_POST["btnEnviar"])){
    $error_Nombre=$_POST["nombre"]=="";
    $error_Apellido=$_POST["apellido"]=="";
    $error_Calle=$_POST["calle"]=="";
    $error_CP=$_POST["cp"]=="" || !is_numeric($_POST["cp"]) || strlen($_POST["cp"])==4;
    $error_Localidad=$_POST["localidad"]=="";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ejer5</title>
    <meta charset="UTC-8"/>

</head>

<body>
<form action="Ejer5.php" method="post">

<label for="nombre">Nombre:</label>
<input type="text" name="nombre" id="nombre"/>

<br/>
<br/>

<label for="apellido">Apellido:</label>
<input type="text" name="apellido" id="apellido"/>

<br/>
<br/>

<label for="calle">Calle:</label>
<input type="text" name="calle" id="calle"/>

<br/>
<br/>

<label for="cp">CP:</label>
<input type="text" name="cp" id="cp"/>

<br/>
<br/>

<label for="localidad">Localidad:</label>
<input type="text" name="localidad" id="localidad"/>

<br/>
<br/>

<input type="submit" name="btnEnviar" value="Enviar"/>
</form>

</body>

</html>