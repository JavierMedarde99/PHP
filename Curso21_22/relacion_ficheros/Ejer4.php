<?php
if(isset($_POST["btnEnviar"])){
$errorFichero = $_FILES["fichero"]["name"]!="" && ($_FILES["fichero"]["error"] || !gettext($_FILES["fichero"]["tmp_name"]) || $_FILES["fichero"]["size"]>2500000);

}  

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
        if(isset($_POST["btnEnviar"]) && !$errorFichero){
            @$fd=fopen("Tablas/".$_FILES["fichero"]["name"],"r");
        if(!$fd)
        die("<p>NO se ha podido leer el fichero <em>'Tablas/".$_FILES["fichero"]["name"].".txt'</em> </p>");

        $cont=0;
        while($line=fgets($fd)){
            for($i=0; $i<strlen($line);$i++){
                if($line[$i]==" ")
                $cont++;
            } 
        } 

        fseek($fd,0);

            fclose($fd);
            echo "el numero de palabras son :".$cont;
    }
        ?>
        
    </body>
</html>