<?php 
if(isset($_POST["btnReset"])){
    header("Location:index.php");
    exit;
}

function LetraNIF($dni) 
{  
     return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23, 1); 
} 

 if(isset($_POST["btnEnviar"]))
 {
  $error_nombre=$_POST["nombre"]=="";
  $error_usuario=$_POST["usuario"]=="";
  $error_dni=$_POST["dni"]==""|| strlen($_POST["dni"])<9 || !is_numeric(substr($_POST["dni"],0,8)) || !ctype_alpha(substr($_POST["dni"],-1)) ||LetraNIF($_POST["dni"],-1)!=substr($_POST["dni"],8,1);
  $error_contraseña=$_POST["contraseña"]=="" ;
  $error_sexo=!isset($_POST["sexo"]);
  $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"]>500000);

  $errores=$error_nombre || $error_apellidos ||$error_dni ||   $error_contraseña  ||  $error_sexo ;//|| $error_foto;
 }
    ?> 

<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejemplo de Formulario</title>
<meta charset="UTF-8"/>
</head>

<body>
    <h2>Rellena tu CV</h2>
    <form action="index.php" method="post" entype="multifile/file data">
        <label for="nombre">Nombre:</label><br/>
        <input type="text" name="nombre" id="nombre" placeholder="Nombre..." value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"] ?>"/>
        
<?php
if(isset($_POST["btnEnviar"])&& $error_nombre)
{
    echo "* Campo vacio *";
}
?>

<br/>
<br/>


        <label for="usuario">Usuario:</label><br/>
        <input type="text" name="usuario" placeholder="Usuario..." value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"] ?>" id="usuario"/>
        <?php
if(isset($_POST["btnEnviar"])&& $error_usuario)
{
    echo "* Campo vacio *";
}
?>
        
        
        <br/>
        <br/>

        <label for="contraseña">Contraseña:</label><br/>
        <input type="password"  name="contraseña" id="contraseña" placeholder="Contraseña..." value=""/>
<?php
        if(isset($_POST["btnEnviar"])&& $error_contraseña)
{
    echo "* Campo vacio *";
}
?>

<br/>
<br/>

        <label for="dni">DNI</label><br/>
        <input type="text" size="10" name="dni" id="dni" placeholder="DNI: 11223344Z" value="<?php if(isset($_POST["dni"])) echo $_POST["dni"] ?>"/>

        <?php
        if(isset($_POST["btnEnviar"])&& $_POST["dni"]=="")
{
    echo "* Campo vacio *";
}else if(isset($_POST["btnEnviar"])&& strlen($_POST["dni"])<9){
    echo "Debes rellenar el DNI con 8 digitos seguido de una letra";
}else if(isset($_POST["btnEnviar"])&& $error_dni){
    echo "DNI no valido";
}
?>

<br/>
<br/>

        <label>Sexo</label><br/>
        <input type="radio" name="sexo" id="hombre" value="hombre" <?php if(isset($_POST["sexo"]) && $_POST["sexo"]=="hombre") echo "checked"; ?>/> <label for="hombre"> hombre </label>
        <input type="radio" name="sexo" id="mujer" value="mujer" <?php if(isset($_POST["sexo"]) && $_POST["sexo"]=="mujer") echo "checked";   ?>/> <label for="mujer"> mujer </label>


        <?php
        if(isset($_POST["btnEnviar"])&& $error_sexo)
{
    echo "* Campo vacio *";
}
?>
        <br/>
        <br/>

        <label for="foto" >Incluir mi foto (Archivo de tipo imagen MAX 500KB)</label>
        <input type="file" name="foto" accept="image/*"/> <br/>
        <?php
        
        if(isset($_POST["bntSubir"]) && $error_foto){
           if($_FILES["foto"]["error"]){
               echo "ha habido un error en la subida del archivo";
                }elseif(!getimagesize($_FILES["foto"]["tmp_name"])){
               echo"no has selecionado un archivo imagen";
                }else{
               echo "El archivo seleccionado es mayor de 500 KB";
                }    
           
        }
    
    ?>
        
        
    

    <br/>
    <br/>
   

        <input type="checkbox" name="subcribirse" id="subs" /> <label for="subs">Suscribirse al boletin de Novedades</label>
        <br/>
        <br/>
        <input type="submit" value="Guardar Cambios" name="btnEnviar"/>
        <input type="submit" value="borrar datos" name="btnReset" />
        
    </form>
   
    <?php
    if(isset($_POST["btnEnviar"])&& !$errores)
    {
    
    ?>
<!DOCTYPE html>
<html lang="es" >

<head>
<title> Ejemplo de Formulario</title>
<meta charset="UTF-8"/>
</head>

<body>
    <h2>Recibiendo datos...</h2>
    
    <?php
        echo "<p><strong>Nombre:  </strong>".$_POST["nombre"]."</p>";
        echo "<p><strong>Contraseña:  </strong>".$_POST["contraseña"]."</p>";
        echo "<p><strong>DNI:  </strong>".$_POST["dni"]."</p>";
        if(isset($_POST["sexo"])){
        echo "<p><strong>Sexo:  </strong>".$_POST["sexo"]."</p>";
        }
        echo "<p><strong>Subcrito al boletin:  </strong>";
        if($_POST["subs"]){
        echo "si";
        }else{
        echo "no";
        }
        echo "</p>";

        if($_FILES["foto"]["name"]!=""){
        echo "<h2>Informacion de la imagen saleccionada</h2>";
        echo"<p><strong>Nombre de la imagen: </strong>".$_FILES["foto"]["name"]."</p>";
        echo"<p><strong>Error en la subida: </strong>".$_FILES["foto"]["error"]."</p>";
        echo"<p><strong>Dirección del archivo: </strong>".$_FILES["foto"]["tmp_name"]."</p>";
        echo"<p><strong>Tamaño del archivo: </strong>".$_FILES["foto"]["size"]."</p>";
        echo"<p><strong>Tipo del archivo: </strong>".$_FILES["foto"]["type"]."</p>";
        }else
            echo "<p><strong>Foto: </strong> no seleccionada</p>";
        

        
        
        $array_nombre=explode(".",$_FILES["foto"]["name"]);
        $exten=end($array_nombre);
        
        
        if(count($array_nombre)==1){
              $exten="";
        }else{
            $exten=".".end($array_nombre);  
        }
        $nombre_unico=md5(uniqid(uniqid(),true)); 
            @$var =move_uploaded_file($_FILES["foto"]["tmp_name"],"imagenes/".$nombre_unico.$exten);

        
       
        
        if($var){
            echo "<h3>La imagen ha sido subida con exito</h3>";
            echo"<p><img src='imagenes/".$nombre_unico."'/></p>";
        }else{
            echo"<p>Error no tiene permiso para moverse en la carpeta destino </p>";
        }
        
    ?>
</html>

<?php
    }
?>
</body>

</html>