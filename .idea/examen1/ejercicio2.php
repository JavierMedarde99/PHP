<?php
if(isset($_POST["btnSubir"]))
    $error_archivo= $_FILES["archivo"]["name"]=="" || $_FILES["archivo"]["error"] || $_FILES["archivo"]["type"]!="text/plain" || $_FILES["archivo"]["size"]>1000000;

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio2</title>
    <style>
        .error{color:red;}
    </style>
</head>
<body>
    
<h1>Ejercicio2</h1>

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
</body>
</html>