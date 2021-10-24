<?php 
    function mi_in_array($valor,$arr){
        $encontrado =false;
        foreach($arr as $elemento){
            if($elemento==$valor){
                $encontrado=true;
                break;
            }
        }
        return $encontrado;
    }



 if(isset($_POST["btnEnviar"]))
 {
  $error_nombre=$_POST["nombre"]=="";
  $error_sexo=!isset($_POST["sexo"]);
  $errores= $error_nombre || $error_sexo;
 }

if(isset($_POST["btnEnviar"])&& !$errores)
{
    ?>
<!DOCTYPE html>
<html lang="es" >

<head>
<title> Recogida</title>
<meta charset="UTF-8"/>
</head>

<body>
    <h1>Estos son los datos envidados:</h1>
    
     <?php
    echo "<p><strong>El nombre enviado ha sido:  </strong>".$_POST["nombre"]."</p>";
    echo "<p><strong>Ha nacido en:  </strong>".$_POST["nacido"]."</p>";
    echo "<p><strong>El sexo es:  </strong>".$_POST["sexo"]."</p>";

        if(isset($_POST["aficiones"])){
            if(count($_POST["aficiones"])==1){
               echo "<p><strong>La aficion seleccionada ha sido:  </strong></p> <br/>"; 
            }else{
                echo "<p><strong>La aficiones seleccionada ha sido: </strong></p> <br/>"; 
            }
            echo "<ol>";
            foreach($_POST["aficiones"] as &$valor){
echo " <li>".$valor. "</li>";
            }
               echo "</ol>";         
    
    }else{
        echo "<p><strong>no has seleccionado ninguna aficcion</strong></p>";
        }
        if($_POST["comentarios"] !=""){
  echo "<p><strong>El comentario enviado ha sido:  </strong>".$_POST["comentarios"]."</p>";
        }else{
            echo "<p><strong>No se ha escrito ningun comentario</strong></p>";
        }
?>
</html>
<?php
} else{
    ?>

<!DOCTYPE html>
<html lang="es">

<head>
<title>Mi primera pagina PHP</title>
<meta charset="UTF-8"/>
</head>

<body>
    <h1>Esta es mi super pagina</h1>
    <form action="index.php" method="post" entype="multifile/file data">
    
    <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"] ?>"/>
        
<?php
if(isset($_POST["btnEnviar"])&& $error_nombre)
{
    echo "* Campo vacio *";
}
?>

</br>
        <label for="nacido"> Nacido en: </label>
    <select name="nacido" id="nacido">
        <option value="malaga" <?php if(isset($_POST["nacido"]) && $_POST["nacido"]=="malaga") echo "selected"; ?> >Malaga</option>
        <option value="estepona" <?php if(isset($_POST["nacido"]) && $_POST["nacido"]=="estepona") echo "selected"; ?> >Estepona</option>
        <option value="marbella" <?php if(isset($_POST["nacido"]) && $_POST["nacido"]=="marbella") echo "selected"; ?> >Marbella</option>
    </select></br>

    <label>Sexo:</label>
        <input type="radio" name="sexo" id="hombre" value="hombre" <?php if(isset($_POST["sexo"]) && $_POST["sexo"]=="hombre") echo "checked"; ?>/> <label for="hombre"> hombre </label>
        <input type="radio" name="sexo" id="mujer" value="mujer" <?php if(isset($_POST["sexo"]) && $_POST["sexo"]=="mujer") echo "checked";   ?>/> <label for="mujer"> mujer </label>


        <?php
        if(isset($_POST["btnEnviar"])&& $error_sexo)
{
    echo "* Campo vacio *";
}
?>
        <br/>

        <label for="aficiones">Aficiones:</label>
       <label> <input type="checkbox" name="aficiones[]" id="deportes" value="deportes" <?php if(isset($_POST["aficiones"]) && in_array("deportes", $_POST["aficiones"])) echo "checked";  ?> /> deportes</label>
       <label> <input type="checkbox" name="aficiones[]" id="lectura" value="lectura" <?php if(isset($_POST["aficiones"]) && in_array("lectura", $_POST["aficiones"])) echo "checked";  ?> /> lectura</label>
       <label> <input type="checkbox" name="aficiones[]" id="otro" value="otro" <?php if(isset($_POST["aficiones"]) && mi_in_array("otro", $_POST["aficiones"])) echo "checked";  ?> /> otro</label>


    <br/>
    <label for="comentarios">Comentarios:</label>
    <textarea name="comentarios" id="comentarios" rows="3" cols="40"><?php if(isset($_POST["comentarios"])) echo $_POST["comentarios"] ?></textarea><br/>

</br>
        <input type="submit" value="Enviar" name="btnEnviar"/>
    
    </form>
   
</body>

</html>
<?php
}

?>