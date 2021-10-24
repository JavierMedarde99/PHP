<?php
if(isset($_POST["btnEnviar"]))
    $error_cantidad=$_POST["cantidad"]=="" || !is_numeric($_POST["cantidad"]);

if(isset($_POST["btnEnviar"])&& !$error_cantidad){


?>
<!DOCTYPE html>
<html lang="es"> 
<head>
<title>Recogida Ejer2</title>
<meta charset="UTF-8"/>
</head>

<body>
<?php
$resul=$_POST["bebidas"]*$_POST["cantidad"];
echo "<p>Has pedido ".$_POST["cantidad"]." unidades de ".$_POST["bebidas"]."</p>";
echo "<p>el precio total ".$resul."€</p>";
?>

</body>

</html>
<?php
}else{
?>

<!DOCTYPE html>
<html lang="es">
<head>
<title> Ejer2 </title>
<meta charset="UTF-8"/>

</head>

<body>

<form action="Ejer2.php" method="post">
    <label for="bebidas">Bebidas:</label>
<select name="bebidas">
    <option value="1">Coca Cola</option>
    <option value="0.8">Pepsi Cola</option>
    <option value="0.9">Fanta Naranja</option>
    <option value="1.20">Trina Manzana</option>
</select>
<br/>
<br/>
<label for="cantidad">Cantidad</label>
<input type="text" name="cantidad" id="cantidad"/>
<?php
if(isset($_POST["btnEnviar"]) && $error_cantidad){
    echo "ponga una cantidad";
}
?>
<br/>
<br/>
<input type="submit" name="btnEnviar" value="enviar"/>
</form>



</body>
<?php
}
?>
</html>