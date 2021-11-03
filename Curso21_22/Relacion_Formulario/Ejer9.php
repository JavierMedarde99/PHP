<?php
if(isset($_POST["btnEnviar"])){
    $errorTitulo=$_POST["titulo"]=="";
    $errorActores=$_POST["actores"]=="";
    $errorDirector=$_POST["director"]=="";
    $errorGuion=$_POST["guion"]=="";
    $errorProduccion=$_POST["produccion"]=="";
    $errorAnyo=$_POST["anyo"]=="" || count($_POST["anyo"])<5;
    $errorNacionalidad=$_POST["nacionalidad"]=="";
    $errorDuraccion=$_POST["duracion"]=="" || count($_POST["duracion"])<4;
   
    $errorEdad = !isset($_POST["edad"]);
    $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"]>500000);
    $errores=$errorTitulo||$errorActores||$errorDirector||$errorGuion||$errorProduccion|| $errorAnyo||$errorNacionalidad||$errorDuraccion||$errorEdad||$error_foto;
}

if(isset($_POST["btnEnviar"]) && !$errores){
    ?>

<!DOCTYPE html>
<html lang="es" >

<head>
<title> Ejemplo de Formulario</title>
<meta charset="UTF-8"/>
</head>

<body>
    <h2>La pelicula introduccida es:</h2>
    <?php
    echo "<p><strong>Titulo:</strong>".$_POST["titulo"]."</p>";
    echo "<p><strong>Actores:</strong>".$_POST["actores"]."</p>";
    echo "<p><strong>Director:</strong>".$_POST["director"]."</p>";
    echo "<p><strong>Guion:</strong>".$_POST["guion"]."</p>";
    echo "<p><strong>Producción:</strong>".$_POST["produccion"]."</p>";
    echo "<p><strong>Año:</strong>".$_POST["anyo"]."</p>";
    echo "<p><strong>Nacionalidad:</strong>".$_POST["Nacionalidad"]."</p>";
    echo "<p><strong>Género:</strong>".$_POST["generos"]."</p>";
    echo "<p><strong>Duraccion:</strong>".$_POST["duraccion"]."</p>";
    echo "<p><strong>Restricciones de edad:</strong>".$_POST["edad"]."</p>";
    echo "<p><strong>Carátula</strong></p>";

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

</body>
    </html>
    <?php
}else{
?>


<!DOCTYPE html>
<html>
<head>
<title>Ejer9</title>
<meta charset="UTC-8"/>
<style>
#izquierda{
float:left;
margin-right: 20px;
}
#derecha{
float:left;
}

#abajo{
clear:both;

}
</style>
</head>

<body>
    <h1>Formulario - Ejercicio9</h1>
    <h2>cinem@a</h2>
<form action="Ejer9.php" method="post" enctype="multipart/form-data">
<div id="izquierda">
<label for="titulo">Titulo</label> <br/>
<input type="text" name="titulo" id="titulo" value=""/>



<br/>
<label for="director">Director</label> <br/>
<input type="text" name="director" id="director" value=""/>

<br/>
<label for="produccion">Produccion</label> <br/>
<input type="text" name="produccion" id="produccion" value=""/>

<br/>
<label for="nacionalidad">Nacionalidad</label> <br/>
<input type="text" name="nacionalidad" id="nacionalidad" value=""/>

<br/>
<label for="duracion">Duracion</label> <br/>
<input type="text" name="duracion" id="duracion" value=""/>(minutos)
</div>


<div id="derecha">
<label for="actores">Actores</label> <br/>
<input type="text" name="actores" id="actores" value=""/>

<br/>
<label for="guion">Guion</label> <br/>
<input type="text" name="guion" id="guion" value=""/>

<br/>
<label for="anyo">año</label> <br/>
<input type="text" name="anyo" id="anyo" value=""/>

<br/>
<label for="generos">Genero</label><br/>
<select for="generos">
<option value="comedia">Comedia</option>
<option value="drama">Drama</option>
<option value="accion">Acción</option>
<option value="terror">Terror</option>
<option value="suspense">Suspense</option>
<option value="otros">Otras</option>
</select>

<br/>
<label>Restricciones de edad</label><br/>
<input type="radio" name="edad" id="todo" value="">
<label for="todo">Todos los públicos</label>

<input type="radio" name="edad" id="adolescentes" value="">
<label for="adolescentes">Mayores de 7 años</label>

<input type="radio" name="edad" id="mayores" value="">
<label for="mayores">Mayores de 18 años</label>
</div>
<div id="abajo">
    <br/>
<label for="sinopsis">sinopsis</label><br/>
<textarea></textarea>

<br/>
<br/>
<label for="foto" >Carátula</label>
        <input type="file" name="foto" accept="image/*"/> <br/>
</div>
<br/>
<div id="izquierda">
<input type="submit" name="btnEnviar" value="enviar"/>
</div>
<div id="derecha">
<input type="submit" name="btnBorrar" value="borrar"/>
</div>
</form>
<?php
}
?>
</body>
</html>