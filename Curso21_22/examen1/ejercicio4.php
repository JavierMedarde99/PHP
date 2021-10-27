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

if(isset($_POST["btnSubir"]))
    $error_archivo= $_FILES["archivo"]["name"]=="" || $_FILES["archivo"]["error"] || $_FILES["archivo"]["type"]!="text/plain" || $_FILES["archivo"]["size"]>1000000;


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio4</title>
</head>
<body>
    <h1>Ejercicio4</h1>
    <?php
     @$file=fopen("Horarios/horarios.txt","r");
     if(!$file){
?>
<form action="ejercicio2.php" method="post" enctype="multipart/form-data">
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
if(isset($_POST["btnSubir"]) && !$error_archivo){
 @$var = move_uploaded_file( $_FILES["archivo"]["rmp_name"],"Ficheros/archivo.txt");
 if(!$var)
 echo "<p>no se ha podido mover el fichero subido a la carpeta destino</p>";
 else
echo "<p>fichero seleccionado ha sido subido correctamente</p>";
}
?>

<?php
     }else{
?>

<?php
     }
    ?>
</body>
</html>