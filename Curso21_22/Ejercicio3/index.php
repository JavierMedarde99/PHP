<?php 
 if(isset($_POST[/*"nombre"*/"btnEnviar"])){

    $nombre=$_POST["nombre"];
    $apellidos=$_POST["apellidos"];
    $contraseña=$_POST["contraseña"];
    $dni=$_POST["dni"];
    $comentarios=$_POST["comentarios"];
    $nacido=$_POST["nacido"];
    if(isset($_POST["sexo"])){
        $sexo=$_POST["sexo"];
    } 
    if(isset($_POST["subs"])){
        $subs=$_POST["subs"];
    } 
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
    
    /*
    //array asociativo (por nombre)
     //esto es para el metodo GET

        $nombre=$_GET["nombre"];
        $apellidos=$_GET["apellidos"];
        $contraseña=$_GET["contraseña"];
        $dni=$_GET["dni"];

        echo "<p><strong>Nombre:  </strong>".$nombre."</p>";
        echo "<p><strong>Apellidos:  </strong>".$apellidos."</p>";
        echo "<p><strong>Contraseña:  </strong>".$contraseña."</p>";
        echo "<p><strong>DNI:  </strong>".$dni."</p>";

*/

        //para el metodo post 

       

        echo "<p><strong>Nombre:  </strong>".$nombre."</p>";
        echo "<p><strong>Apellidos:  </strong>".$apellidos."</p>";
        echo "<p><strong>Contraseña:  </strong>".$contraseña."</p>";
        echo "<p><strong>DNI:  </strong>".$dni."</p>";
        if(isset($sexo)){
        echo "<p><strong>Sexo:  </strong>".$sexo."</p>";
        }
        echo "<p><strong>Subcrito al boletin:  </strong>";
        if($subs){
        echo "si";
        }else{
        echo "no";
        }
        echo "</p>";
        echo "<p><strong>Comentarios:  </strong>".$comentarios."</p>";
        echo "<p><strong>Nacido:  </strong>".$nacido."</p>";
    ?>
</html>
<?php
} else{
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
        <label for="nombre">Nombre</label><br/>
        <input type="text" name="nombre" id="nombre"/><br/>

        <label for="apellidos">Apellidos</label><br/>
        <input type="text" size="50" name="apellidos" id="apellidos"/><br/>

        <label for="contraseña">Contraseña</label><br/>
        <input type="password"  name="contraseña" id="contraseña"/><br/>

        <label for="dni">DNI</label><br/>
        <input type="text" size="10" name="dni" id="dni"/><br/>

        <label>Sexo</label><br/>
        <input type="radio" name="sexo" id="hombre" value="hombre"/> <label for="hombre"> hombre </label>
        <input type="radio" name="sexo" id="mujer" value="mujer"/> <label for="mujer"> mujer </label>

        <br/>

        <label for="foto" >Incluir mi foto</label>
        <input type="file" name="foto" accept="image/*"/> <br/>

    <label for="nacido"> Necido en: </label>
    <select name="nacido" id="nacido">
        <optgroup label="malaga">
        <option value="malaga">Malaga</option>
        <option value="estepona">Estepona</option>
        <option value="marbella">Marbella</option>
</optgroup>
<optgroup label="granada">
        <option value="motril">Motril</option>
        <option value="granada">Granada</option>
</optgroup>

    </select>

    <br/>
    <label for="comentarios">Comentarios:</label>
    <textarea name="comentarios" id="comentarios" rows="5" cols="30"></textarea><br/>

        <input type="checkbox" name="subcribirse" id="subs" checked/> <label for="subs">Suscribirse al boletin de Novedades</label>
        <br/>
        <br/>
        <input type="submit" value="Guardar Cambios" name="btnEnviar"/>
        <input type="reset" value="borrar datos" name="btnBorrar"/>
    </form>
   
</body>

</html>
    <?php
}

?>


