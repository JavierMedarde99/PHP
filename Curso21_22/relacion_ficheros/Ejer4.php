<?php
if($_POST["btnEnviar"])
$error_fichero=$_FILES["fichero"]["name"]!="" && ($_FILES["fichero"]["error"] || !gettext($_FILES["fichero"]["tmp_name"]) || $_FILES["fichero"]["size"]>2500000);

?>


<!DOCTYPE html>
<html>
    <head>
        <title>Ejercicio 4</title>
        <meta charset="UTF-8"/>
    </head>
    <body>
        <form action="Ejer4.php" method="post" enctype="multipart/form-data">

            <label for="fichero">Fichero de texto</label>
            <input type="file" name="fichero" id="fichero" accept=".txt">
<?php
            if(isset($_POST["bntSubir"]) && $error_fichero){
           if($_FILES["fichero"]["error"]){
               echo "ha habido un error en la subida del archivo";
                }elseif(!getimagesize($_FILES["fichero"]["tmp_name"])){
               echo"no has selecionado un archivo imagen";
                }else{
               echo "El archivo seleccionado es mayor de 500 KB";
                }    
           
        }
?>
            <p><button type="submit" name="btnEnviar">Crear</button></p>
        </form>

        <?php
        if(isset($_POST["btnEnviar"]) && !$error_fichero){
            $array_nombre=explode(".",$_FILES["foto"]["name"]);
        $exten=end($array_nombre);
        
        
        if(count($array_nombre)==1){
              $exten="";
        }else{
            $exten=".".end($array_nombre);  
        }
        $nombre_unico=md5(uniqid(uniqid(),true)); 
            @$var =move_uploaded_file($_FILES["foto"]["tmp_name"],"Tablas/".$nombre_unico.$exten);
 
        if($var){
            echo "<h3>La imagen ha sido subida con exito</h3>";
            echo"<p><img src='imagenes/".$nombre_unico."'/></p>";
        }else{
            echo"<p>Error no tiene permiso para moverse en la carpeta destino </p>";
        }
        }
        ?>
    </body>
</html>