<?php
if(isset($_POST["btnEnviar"]))
    $error_cuadernos=$_POST["cuadernos"]=="" || !is_numeric($_POST["cuadernos"]);
   if(isset($_POST["btnEnviar"]) && !$error_cuadernos){
   ?>
<!DOCTYPE html>
<html>
<head>
    <title>REsultadoEjer3</title>
    <meta charset="UTC-8"/>
</head>
<body>
    <?php
    if($_POST["cuadernos"]<10){
$resul=$_POST["cuadernos"]*2;
    }elseif($_POST["cuadernos"]>=10 && $_POST["cuadernos"]<=30){
$resul=$_POST["cuadernos"]*1.5;
    }else{
        $resul=$_POST["cuadernos"];
    }
    echo "el precio total de los cuadernos son ".$resul;
    ?>

</body>

</html>

    <?php
}else{

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ejer3</title>
    <meta charset="UTC-8"/>
</head>

<body>

<form action="Ejer3.php" method="POST">
<label for="cuadernos">Cuadernos:</label>
<input type="text" name="cuadernos" id="cuadernos"/>
<br/>
<br/>
<input type="submit" name="btnEnviar" value="enviar"/>
</form>
<?php
}
?>
</body>



</html>