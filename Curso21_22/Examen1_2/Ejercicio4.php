<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio4 version 2</title>
</head>
<body>
    <h1>Ejercicio4</h1>
    <form action="Ejercicio4.php" method="post">
    <p><label for="">Seleccione un profesor</label>
    <?php
     @$file=fopen("horarios.txt","r");
     if(!$file)
      die("no se ha podido abrir");
      ?>

    <select name="profesor" id="profesor">

    <?php
   
while($fila=fgets($file)){
$valores=explode("\t",$fila);
if(isset($_POST["profesor"]) && $_POST["profesor"]==$valores[0])
echo "<option selected value='".$valores[0]."'>".$valores[0]."</option>";
else
echo "<option value='".$valores[0]."'>".$valores[0]."</option>";

}
fclose($file);
?>
    </select>
    <input type="submit" value="Ver Horario" name="btnVer">
    
</p>
</form>
<?php
    if(isset($_POST["btnVer"]))
    echo "<h3>horario del profesor ".$_POST["profesor"]."</h3>"
    
    ?>
</body>
</html>