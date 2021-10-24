<?php
if(isset($_GET["btnEnviar"])){
$error_nombre=$_GET["nombre"]=="";
$error_apellidos=$_GET["apellidos"]=="";
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejer1 </title>
<meta charset="UTF-8"/>

</head>

<body>


<form action="Ejer1.php" method="get">
    <form>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" />

<?php
if(isset($_GET["btnEnviar"]) && $error_nombre){
echo "Faltan valores";
}
?>
<br/>
<br/>
        <label for="apellidos">apellidos:</label>
        <input type="text" name="apellidos" id="apellidos" />

<?php
if(isset($_GET["btnEnviar"]) && $error_apellidos){
echo "Faltan valores";
}
?>
<br/>
<br/>
        <input type="submit" name="btnEnviar" value="enviar"/>
    </form>

</body>
</html>