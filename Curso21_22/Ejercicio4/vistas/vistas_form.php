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
        <input type="text" name="nombre" id="nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"] ?>"/>
        
<?php
if(isset($_POST["btnEnviar"])&& $error_nombre)
{
    echo "* Campo vacio *";
}
?>

<br/>

        <label for="apellidos">Apellidos</label><br/>
        <input type="text" size="50" name="apellidos" value="<?php if(isset($_POST["apellidos"])) echo $_POST["apellidos"] ?>" id="apellidos"/>
        <?php
if(isset($_POST["btnEnviar"])&& $error_apellidos)
{
    echo "* Campo vacio *";
}
?>
        
        
        <br/>

        <label for="contraseña">Contraseña</label><br/>
        <input type="password"  name="contraseña" id="contraseña" value="<?php if(isset($_POST["contraseña"])) echo $_POST["contraseña"] ?>" id="contraseña"/>
<?php
        if(isset($_POST["btnEnviar"])&& $error_contraseña)
{
    echo "* Campo vacio *";
}
?>
<br/>
        <label for="dni">DNI</label><br/>
        <input type="text" size="10" name="dni" id="dni" value="<?php if(isset($_POST["dni"])) echo $_POST["dni"] ?>"/>

        <?php
        if(isset($_POST["btnEnviar"])&& $error_dni)
{
    echo "* Campo vacio *";
}
?>
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

        <label for="foto" >Incluir mi foto</label>
        <input type="file" name="foto" accept="image/*"/> <br/>

    <label for="nacido"> Necido en: </label>
    <select name="nacido" id="nacido">
        <optgroup label="malaga">
        <option value="malaga" <?php if(isset($_POST["nacido"]) && $_POST["nacido"]=="malaga") echo "selected" ?> >Malaga</option>
        <option value="estepona" <?php if(isset($_POST["nacido"]) && $_POST["nacido"]=="estepona") echo "selected" ?> >Estepona</option>
        <option value="marbella" <?php if(isset($_POST["nacido"]) && $_POST["nacido"]=="marbella") echo "selected" ?> >Marbella</option>
</optgroup>
<optgroup label="granada">
        <option value="motril" <?php if(isset($_POST["nacido"]) && $_POST["nacido"]=="motril") echo "selected" ?> >Motril</option>
        <option value="granada" <?php if(isset($_POST["nacido"]) && $_POST["nacido"]=="granada") echo "selected" ?> >Granada</option>
</optgroup>

    </select>

    <br/>
    <label for="comentarios">Comentarios:</label>
    <textarea name="comentarios" id="comentarios" rows="5" cols="30"><?php if(isset($_POST["comentarios"])) echo $_POST["comentarios"] ?></textarea><br/>

    <?php
        if(isset($_POST["btnEnviar"])&& $error_comentarios)
{
    echo "* Campo vacio *";
}
?>

        <input type="checkbox" name="subcribirse" id="subs" <?php if(isset($_POST["subs"]) || !isset($_POST["btnEnviar"])) echo "checked" ?>/> <label for="subs">Suscribirse al boletin de Novedades</label>
        <br/>
        <br/>
        <input type="submit" value="Guardar Cambios" name="btnEnviar"/>
        <input type="submit" value="borrar datos" name="btnReset" />
        
    </form>
   
</body>

</html>