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
    if(isset($_POST["btnVer"])){
        echo "<h3>horario del profesor ".$_POST["profesor"]."</h3>";

        $hora[1]="8:15-9:15";
        $hora[2]="9:15-10:15";
        $hora[3]= "10:15-11:15";
        $hora[4]="11:15-11:45";
        $hora[5]= "11:45-12:45";
        $hora[6]= "12:45-13:45";
        $hora[7]= "13:45-14:45";
        echo "<table border='black'>";
echo "<tr>";
echo "<th></th><th>Lunes</th><th>martes</th><th>Miercoles</th><th>Jueves</th><th>Viernes</th>";
echo "</tr>";
for($i=1;$i<=7;$i++){
    echo "<tr><td>".$hora[$i]."</td>";
    if($i==4){
echo "<td colspan='5'>Recreo</td>";
    }

    }
}
    
    ?>
</body>
</html>