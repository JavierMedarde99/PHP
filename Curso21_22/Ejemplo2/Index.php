<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejemplo de Formulario</title>
<meta charset="UTF-8"/>
</head>

<body>
    <h2>Rellena tu CV</h2>
    <form action="recepcion_datos.php" method="post" >
        <label for="nombre">Nombre</label><br/>
        <input type="text" name="nombre" id="nombre"/><br/>

        <label for="apellidos">Apellidos</label><br/>
        <input type="text" size="50" name="apellidos" id="apellidos"/><br/>

        <label for="contraseña">Contraseña</label><br/>
        <input type="password"  name="contraseña" id="contraseña"/><br/>

        <label for="dni">DNI</label><br/>
        <input type="text" size="10" name="dni" id="dni"/><br/>

        <br/>
        <br/>
        <input type="submit" value="Guardar Cambios"/>
    </form>
   
</body>

</html>