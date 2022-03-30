<?php
if(isset($_POST["btnComp"])){
    $url=DIR_SERV."/deGuardia/".urlencode($_POST["dia"])."/".urlencode($_POST["hora"])."/".urlencode($_SESSION["usuario"]);
    $respuesta=consumir_servicios_REST($url,"GET");
    $obj=json_decode($respuesta);
    if(!$obj)
    {
        session_destroy();
        die(error_page("Actividad Examen","<h1>Actividad Examen</h1><p>Error consumiendo el servicio: ".$url."</p>".$respuesta ));
    }
    if(isset($obj->error))
    {
        session_destroy();
        die(error_page("Actividad Examen","<h1>Actividad Examen</h1><p>".$obj->error."</p>"));
    }else{
        $_SESSION["pase"] = $obj->usuario;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Guardias</title>
</head>
<body>
    <h1>Gestion de guardias</h1>
    <p>Bienvenido <?php echo $_SESSION["usuario"]?> - 
<form action="index.php" method="post">
    <input type="submit" value="salir" name="btnCerrarSesion">
</form>
</p>

<h1>Equipos de Guardia del IES Mar de Alborán</h1>

<table>
    <tr>
        <th></th>
        <th>Lunes</th>
        <th>Martes</th>
        <th>Miercoles</th>
        <th>Jueves</th>
        <th>Viernes</th>
    </tr>
    <?php
    echo "<tr>";
    echo "<td>1º Hora</td>";
    for($i=1; $i<=5;$i++){
echo "<td><form action='index.php' method='post'>
<input type='hidden' name='hora' value=1>
<input type='hidden' name='dia' value=".$i.">
<input type='submit' value='Equipo".$i."' name='btnComp'>
</form></td>";   
    } echo "</tr>";

    echo "<tr>";
    echo "<td>2º Hora</td>";
    for($i=6; $i<=10;$i++){
        echo "<td><form action='index.php' method='post'>
        <input type='hidden' name='hora' value=1>
        <input type='hidden' name='dia' value=".($i-5).">
        <input type='submit' value='Equipo".$i."' name='btnComp'>
        </form></td>";   
    } echo "</tr>";

    echo "<tr>";
    echo "<td>3º Hora</td>";
    for($i=11; $i<=15;$i++){
        echo "<td><form action='index.php' method='post'>
        <input type='hidden' name='hora' value=1>
        <input type='hidden' name='dia' value=".($i-10).">
        <input type='submit' value='Equipo".$i."' name='btnComp'>
        </form></td>";     
    } echo "</tr>";
echo "<tr>
<td colspan='6'>Recreo</td>
</tr>";
    echo "<tr>";
    echo "<td>4º Hora</td>";
    for($i=16; $i<=20;$i++){
        echo "<td><form action='index.php' method='post'>
        <input type='hidden' name='hora' value=1>
        <input type='hidden' name='dia' value=".($i-15).">
        <input type='submit' value='Equipo".$i."' name='btnComp'>
        </form></td>";   
    } echo "</tr>";

    echo "<tr>";
    echo "<td>5º Hora</td>";
    for($i=21; $i<=25;$i++){
        echo "<td><form action='index.php' method='post'>
        <input type='hidden' name='hora' value=1>
        <input type='hidden' name='dia' value=".($i-20).">
        <input type='submit' value='Equipo".$i."' name='btnComp'>
        </form></td>";     
    } echo "</tr>";

    echo "<tr>";
    echo "<td>5º Hora</td>";
    for($i=26; $i<=30;$i++){
        echo "<td><form action='index.php' method='post'>
        <input type='hidden' name='hora' value=1>
        <input type='hidden' name='dia' value=".($i-25).">
        <input type='submit' value='Equipo".$i."' name='btnComp'>
        </form></td>";      
    } echo "</tr>";
    ?>
    
</table>

<?php
if(isset($_POST["btnComp"])){
  
    if( $_SESSION["pase"]){
          echo "Esta";
    }else{
        echo "<h1>Equipo de</h1>";
    echo "No pertenece a estwe grupo";
    }
    
}
?>
</body>
</html>