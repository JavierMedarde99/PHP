<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría PDO</title>
</head>
<body>
<?php
    define("SERVIDOR_BD","localhost");
    define("USUARIO_BD","jose");
    define("CLAVE_BD","josefa");
    define("NOMBRE_BD","bd_cv");

    /*
    @$conexion = mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
    if(!$conexion)
        die("Imposible conectar. Error número:".mysqli_connect_errno().":".mysqli_connect_error());
    mysqli_set_charset($conexion,"utf8");

    echo "<p>Conexión correcta</p>";


    $usuario="masantos";
    $clave=md5("123456");

    $consulta="select * from usuarios where usuario='".$usuario."' AND clave='".$clave."'"; 
    
    $resultado=mysqli_query($conexion,$consulta);

    if($resultado)
    {
        $datos=array();
        if(mysqli_num_rows($resultado)>0)
            $datos=mysqli_fetch_assoc($resultado);

        mysqli_free_result($resultado);
        var_dump($datos);
    }
    else
    {
        $error="Error en la consulta. Error número:".mysqli_errno($conexion)." : ".mysqli_error($conexion);
        mysqli_close($conexion);
        die($error);
    }

    
    mysqli_close($conexion);

    */

try{
    $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
}
catch(PDOException $e){
    die("Imposible conectar:".$e->getMessage());
}
echo "<p>Conexión correcta</p>";

$usuario="masantos";
$clave=md5("123456");

$consulta="select * from usuarios where usuario=? AND clave=?";

$sentencia=$conexion->prepare($consulta);

if($sentencia->execute([$usuario,$clave]))
{
    $datos=array();
    if($sentencia->RowCount()>0)
            $datos=$sentencia->fetch(PDO::FETCH_ASSOC);

    $sentencia=null;
    var_dump($datos);
}
else{
    $error="Error en la consulta. Error número:".$sentencia->errorInfo()[1]." : ".$sentencia->errorInfo()[2];
    $sentencia=null;
    $conexion=null;
    die($error);
}


echo "<hr/>";
$consulta="select * from usuarios";
$sentencia=$conexion->prepare($consulta);

if($sentencia->execute())
{
    $respuesta=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    foreach($respuesta as $fila)
    {
        echo $fila["usuario"]." - ".$fila["dni"]."<br/>";
    }

    echo "<hr/>";
    for($i=0; $i<count($respuesta);$i++)
    {
        echo $respuesta[$i]["usuario"]." - ".$respuesta[$i]["dni"]."<br/>";
    }
    
    echo "<hr/>";
    echo $respuesta[2]["usuario"]." - ".$respuesta[2]["dni"]."<br/>";

    $sentencia=null;
}
else{
    $error="Error en la consulta. Error número:".$sentencia->errorInfo()[1]." : ".$sentencia->errorInfo()[2];
    $sentencia=null;
    $conexion=null;
    die($error);
}

$conexion=null;

/*$consulta="INSERT into usuarios (usuario, clave, dni, sexo, foto) values(?,?,?,?,?)";
$sentencia=$conexion->prepare($consulta);
if($sentencia->execute([$usuario,$clave,$dni,$sexo,$foto]))*/
?>
    
</body>
</html>