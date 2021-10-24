<?php

    if(isset($_POST["btnSubir"])){
        /*
        $_FILES["foto"]["name"];
        $_FILES["foto"]["tmp_name"];
        $_FILES["foto"]["size"];
        $_FILES["foto"]["type"];
        $_FILES["foto"]["error"];
        */

$error_foto=$_FILES["foto"]["name"]=="" || 
$_FILES["foto"]["error"] || 
!getimagesize($_FILES["foto"]["tmp_name"]) || 
$_FILES["foto"]["size"]>500000;
        
    }

?>
<!DOCTYPE html>
<html lang="es">

<head>
<title> Subir Ficheros al Servidor </title>
<meta charset="UTF-8"/>
<style>
    .oculta {display: none}
    .boton{background: lightgrey; border: 1px solid black; border-radius: 0.2em;padding: 0.25em;}
    .boton:hover{background: #ccc;}
    </style>
</head>

<body>
    
    <h1>Formulario - Subir Imágenes</h1>
   <form action="index.php" method="post" enctype="multipart/form-data">
   <p><label for="foto">Selecione una imagen no superior a 500KB</label>
   <label class="boton" for="foto">Buscar</label> 
   <input type="file" class="oculta"id="foto" name="foto" onchange="document.getElementById('error_foto').innerHTML=this.files[0].name;" accept="image/*"/></p>
<span id="error_foto"></span>
    <?php
        if(isset($_POST["bntSubir"]) && $error_foto){
           if($_FILES["foto"]["name"]==""){
               echo "no has seleccionado una imagen";
           }elseif($_FILES["foto"]["error"]){
               echo "ha habido un error en la subida del archivo";
                }elseif(!getimagesize($_FILES["foto"]["tmp_name"])){
               echo"no has selecionado un archivo imagen";
                }else{
               echo "El archivo seleccionado es mayor de 500 KB";
                }    
           
        }
    
    ?>
<p><input type="submit" name="btnSubir" value="Subir Imagen"/></p>

   </form>
<?php
if(isset($_POST["btnSubir"]) && !$error_foto){
echo"<h1>Informacion de la imagen Subida</h1>";


echo"<p><strong>Nombre de la imagen: </strong>".$_FILES["foto"]["name"]."</p>";
echo"<p><strong>Error en la subida: </strong>".$_FILES["foto"]["error"]."</p>";
echo"<p><strong>Dirección del archivo: </strong>".$_FILES["foto"]["tmp_name"]."</p>";
echo"<p><strong>Tamaño del archivo: </strong>".$_FILES["foto"]["size"]."</p>";
echo"<p><strong>Tipo del archivo: </strong>".$_FILES["foto"]["type"]."</p>";

$array_nombre=explode(".",$_FILES["foto"]["name"]);
$exten=end($array_nombre);
$nombre_unico=md5(uniqid(uniqid(),true)); 
$nombre_nuevo=$nombre_unico;
if(count($array_nombre)>1){
      $nombre_nuevo.= ".".$exten; 
}


@$var =move_uploaded_file($_FILES["foto"]["tmp_name"],"imagenes/".$nombre_nuevo);

if($var){
    echo "<h3>La imagen ha sido movida con exito</h3>";
    echo"<p><img src='imagenes/".$nombre_nuevo."'/></p>";
}else{
    echo"<p>Error no tiene permiso para moverse </p>";
}
}

?>


</body>

</html>