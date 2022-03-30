<?php
require "config_bd.php";

function inicio_sesion($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        $consulta="select * from usuarios where usuario=? and clave=?";
        $sentencia=$conexion->prepare($consulta);
        if($sentencia->execute($datos))
        {
            if($sentencia->rowCount()>0)
                $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
            else
                $respuesta["mensaje"]="El usuario no se encuentra registrado en la BD";
        }
        else
        {
            $respuesta["error"]= "Error en la consulta. Error n&uacute;mero:".$sentencia->errorInfo()[1]." : ".$sentencia->errorInfo()[2];
        }
        $sentencia=null;
        $conexion=null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}

function obtener_usuario($id_usuario)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));

        
        
        $consulta="select * from usuarios where id_usuario=?";

        
        $sentencia=$conexion->prepare($consulta);
        if($sentencia->execute([$id_usuario]))
        {
            if($sentencia->rowCount()>0)
                $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
            else
                $respuesta["mensaje"]="El usuario no se encuentra registrado en la BD";

        }
        else
        {
            $respuesta["error"]= "Error en la consulta. Error n&uacute;mero:".$sentencia->errorInfo()[1]." : ".$sentencia->errorInfo()[2];
        }
        $sentencia=null;
        $conexion=null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}

function usuarios_guardia($dia,$hora)
{
    try{
$conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
$consulta = "select usuario from horario_lectivo where dia=? and hora=?";
$sentencia=$conexion->prepare($consulta);
if($sentencia->execute([$dia],[$hora])){
    if($sentencia->rowCount()>0)
        $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
        else
        $respuesta["mensaje"]="El usuario no se encuentra registrado en la BD";

    
}
else
{
    $respuesta["error"]= "Error en la consulta. Error n&uacute;mero:".$sentencia->errorInfo()[1]." : ".$sentencia->errorInfo()[2];
}
$sentencia=null;
$conexion=null;
    }catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}

function guardia($dia,$hora,$id_usuario)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        $consulta = "select usuario from horario_lectivo where dia=? and hora=?";
        $sentencia=$conexion->prepare($consulta);
        if($sentencia->execute([$dia],[$hora])){
            if($sentencia->rowCount()>0)
            if($sentencia->fetch(PDO::FETCH_ASSOC)==$id_usuario)
                $respuesta["usuario"]=true;
                else
                $respuesta["usuario"]=false;
            
        }
        else
        {
            $respuesta["error"]= "Error en la consulta. Error n&uacute;mero:".$sentencia->errorInfo()[1]." : ".$sentencia->errorInfo()[2];
        }
        $sentencia=null;
        $conexion=null;
            }catch(PDOException $e){
                $respuesta["error"]="Imposible conectar:".$e->getMessage();
            }
            return $respuesta;
}

function repetido($tabla,$columna,$valor,$columna_id=null,$valor_id=null)
{

    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));

        $clausula="";
        $valor_param[]=$valor;
        if(isset($columna_id))
        {
            $clausula=" AND ".$columna_id."<>?";
            $valor_param[]=$valor_id;
        }
        $consulta="select ".$columna." from ".$tabla." where ".$columna."=?".$clausula;

        
        $sentencia=$conexion->prepare($consulta);
        if($sentencia->execute($valor_param))
        {
          $respuesta["repetido"]=$sentencia->rowCount()>0;
        }
        else
        {
            $respuesta["error"]= "Error en la consulta. Error n&uacute;mero:".$sentencia->errorInfo()[1]." : ".$sentencia->errorInfo()[2];
        }
        $sentencia=null;
        $conexion=null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;

}


?>
