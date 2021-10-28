<?php
function mi_strlen($texto){
    $resp=0;
    while(isset($texto[$resp]))
    $resp++;
    return $resp;
}

function mi_explode($sep,$texto){
$aux =[];
$long_texto=mi_strlen($texto);
$i=0;
while($i<$long_texto && $texto[$i]==$sep)
$i++;

if($i<$long_texto){
    $j=0;
    $aux[$j]=$texto[$i];
    for($k=$i+1; $k<$long_texto;$k++){
        if($texto[$k]!=$sep){
            $aux[$j].=$texto[$k];
        }else{
            $k++;
            while($k<$long_texto && $texto[$k]==$sep){
                $k++;
            }
            if($k<$long_texto){
$j++;
$aux[$j]=$texto[$k];
            }
        }
    }
}
return $aux;
}

if(isset($_POST["btnSubir"])){
    $error_archivo= $_FILES["archivo"]["name"]=="" || $_FILES["archivo"]["error"] || $_FILES["archivo"]["type"]!="text/plain" || $_FILES["archivo"]["size"]>1000000;

if(!$error_archivo){
 @$var = move_uploaded_file( $_FILES["archivo"]["tmp_name"],"Horario/horarios.txt");
 if(!$var)
 echo "<p>no se ha podido mover el fichero subido a la carpeta destino</p>";
 else
echo "<p>fichero seleccionado ha sido subido correctamente</p>";
}
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    .error {
        color: red;
    }

    .centrar {
        text-align: center;
    }

    table,
    td,
    th {
        border: 1px
    }

    table {
        width: 80%;
        margin: 0;
        border-collapse: collapse;
    }
    </style>
    <title>Ejercicio4</title>
</head>

<body>
    <h1>Ejercicio4</h1>
    <?php
     @$file=fopen("Horarios/horarios.txt","r");
     if(!$file){
?>
    <form action="ejercicio4.php" method="post" enctype="multipart/form-data">
        <h2>No se encuentra el archivo <em>Horario/horarios.txt</em></h2>
        <p><label for="archivo">Seleccione un archivo de texto no superior a 1MB</label></p>
        <input type="file" name="archivo" id="archivo" accept=".txt">
        <?php
if(isset($_POST["btnSubir"]) && $error_archivo){
    if($_FILES["archivo"]["name"]!=""){
        if( $_FILES["archivo"]["error"]){
                echo "<span class='error'> Error en la subida del archivo al servidor</span>";
        }else if ($_FILES["archivo"]["type"]!="text/plain"){
            echo "<span class='error'> Error el archivo seleccionado no es un .txt</span>";
        }else{
            echo "<span class='error'> Error el archivo es superiror a 1 MB</span>";
        }
    }
}
?>

        <p><input type="submit" value="Subir" name="btnSubir"></p>
    </form>



    <?php
     }else{
?>
    <h1>Ejercicio4</h1>
    <h2>Horario de los Profesores</h2>
    <form action="ejercicio4.php" method="post">
        <p><label for="profesor">Horario del profesor:</label></p>
        <select name="profesor" id="profesor">
            <?php
while($fila=fgets($file)){
$valores=mi_explode("\t",$fila);
if(isset($_POST["profesor"]) && $_POST["profesor"]==$valores[0])
echo "<option selected value='".$valores[0]."'>".$valores[0]."</option>";
else
echo "<option value='".$valores[0]."'>".$valores[0]."</option>";

for($i=1;$i<count($valores);$i++){
    if(isset($horario[$valores[0]][$valores[$i]][$valores[$i+1]]))
    $horario[$valores[0]][$valores[$i]][$valores[$i+1]].="/". $valores[$i+2];
    else
$horario[$valores[0]][$valores[$i]][$valores[$i+1]]= $valores[$i+2];
$i=$i+2;
}
}
fclose($file);
?>
        </select>
        <input type="submit" value="Ver Horario" name="btnVerHorario">
    </form>
    <?php
if(isset($_POST["btnVerHorario"])){
    
    $hora[1]="8:15 - 9:15";
    $hora[2]="9:15 - 10:15";
    $hora[3]="10:15 - 11:15";
    $hora[4]="11:15 - 11:45";
    $hora[5]="11:45 - 12:45";
    $hora[6]="12:45 - 13:45";
    $hora[7]="13:45 - 14:45";
 echo "<h3>Horario del Profesor:".$_POST["profesor"]." </h3>";

echo "<table>";
echo "<tr>";
echo "<th></th><th>Lunes</th><th>martes</th><th>Miercoles</th><th>Jueves</th><th>Viernes</th>";
echo "</tr>";
for($j=1;$j<=7;$j++){
    echo "<tr class='centrar'><td>".$hora[$j]."</td>";
    if($j==4){
echo "<td colspan='5'>Recreo</td>";
    }else{
for($i=1;$i<=5;$i++){
    if(isset($horario[$_POST["profesor"]][$i][$j])){
        echo "<td>".$horario[$_POST["profesor"]][$i][$j]."</td>";
    }else{
echo "<td>..</td>";
}
    }
    }

    
    echo "</tr>";
   
}
echo "</table>";


}
fclose($file);
     }
    ?>
</body>

</html>