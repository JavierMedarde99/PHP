<?php
require "config_bd.php";

function obtener_usuarios()
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        $consulta="select * from usuarios";
        $sentencia=$conexion->prepare($consulta);
        if($sentencia->execute())
        {
           /* $usuarios=$sentencia->fetchAll(PDO::FETCH_ASSOC);
            if($usuarios==null)
                $respuesta["usuarios"]=array();
            else*/
            $respuesta["usuarios"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
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

function insertar_usuario($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        $consulta="insert into usuarios (nombre,usuario,clave,email) values(?,?,?,?)";
        $sentencia=$conexion->prepare($consulta);
        if($sentencia->execute($datos))
        {
            $respuesta["ult_id"]=$conexion->lastInsertId();
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

function login_usuario($datos)
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

function actualizar_usuario($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));

        if($datos["clave"]=="")
        {
            $consulta="update usuarios set nombre=?, usuario=?, email=? where id_usuario=?";
            $datos_param=[$datos["nombre"],$datos["usuario"],$datos["email"],$datos["id_usuario"]];
        }
        else
        {
            $consulta="update usuarios set nombre=?, usuario=?,clave=?, email=? where id_usuario=?";
            $datos_param=[$datos["nombre"],$datos["usuario"],md5($datos["clave"]),$datos["email"],$datos["id_usuario"]];
        }
        
        $sentencia=$conexion->prepare($consulta);
        if($sentencia->execute($datos_param))
        {
           $respuesta["mensaje"]="El usuario ".$datos["id_usuario"]." ha sido actualizado con &eacute;xito";
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

function borrar_usuario($id_usuario)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));

        $consulta="delete from usuarios where id_usuario=?";
        
        $sentencia=$conexion->prepare($consulta);
        if($sentencia->execute([$id_usuario]))
        {
           $respuesta["mensaje"]="El usuario ".$id_usuario." ha sido borrado con &eacute;xito";
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