<?php
require "config_bd.php";


function conexion_pdo()
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        $respuesta["mensaje"]="Conexi&oacute;n a la BD realizada con &eacute;xito";
        
        $conexion=null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}


function conexion_mysqli()
{
    @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
    if(!$conexion)
        $respuesta["error"]="Imposible conectar:".mysqli_connect_errno(). " : ".mysqli_connect_error();
    else
    {
        mysqli_set_charset($conexion,"utf8");
        $respuesta["mensaje"]="Conexi&oacute;n a la BD realizada con &eacute;xito";
        mysqli_close($conexion);
    }
    return $respuesta;
}


function loginUsuario($datos){

    try{

        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        $consulta = "select * from usuarios where usuario = ? and clave= ?";
        $sentencia = $conexion->prepare($consulta);
        if($sentencia->execute($datos)){

            if($sentencia->rowCount() > 0){

                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
            }else{

                $respuesta["error"] = "Usuario no se encuentra en la BD";
            }
        }else{

            $respuesta["error"] = "Error en la consulta. Error num: ".$sentencia->errorInfo()[1]." Error: ".$sentencia->errorInfo()[2];
        }
        $sentencia = null;
        $conexion = null;
    }catch(PDOException $e){

        $respuesta["error"] = "Imposible conectar: ".$e->getMessage();
    }

    return $respuesta;
}


function obtenerHorarioUsuario($id_usuario){

    try{

        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        $consulta = "select horario_lectivo.dia, horario_lectivo.hora, grupos.nombre from usuarios, horario_lectivo, grupos where usuarios.id_usuario = horario_lectivo.usuario and horario_lectivo.grupo = grupos.id_grupo and usuarios.id_usuario = ?";
        $sentencia = $conexion->prepare($consulta);
        if($sentencia->execute([$id_usuario])){

            $respuesta["horario"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        }else{

            $respuesta["error"] = "Error en la consulta. Error num: ".$sentencia->errorInfo()[1]." Error: ".$sentencia->errorInfo()[2];
        }
        $sentencia = null;
        $conexion = null;
    }catch(PDOException $e){

        $respuesta["error"] = "Imposible conectar: ".$e->getMessage();
    }

    return $respuesta;
}

function usuarios(){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        $consulta="SELECT * FROM usuarios WHERE tipo<>'admin'";
        $sentencia = $conexion->prepare($consulta);
        if($sentencia->execute()){
            $respuesta["usuarios"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        }else
        $respuesta["error"] = "Error en la consulta. Error num: ".$sentencia->errorInfo()[1]." Error: ".$sentencia->errorInfo()[2];
        $sentencia = null;
        $conexion = null;
    }catch(PDOException $e){

        $respuesta["error"]= "Imposible conectar: ".$e->getMessage();
    }
    return $respuesta;
}

function obtener_grupo($datos){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        $consulta="SELECT grupos.* FROM horario_lectivo,grupos WHERE horario_lectivo.grupo=grupos.id_grupo
        AND horario_lectivo.dia=? AND horario_lectivo.hora=? AND horario_lectivo.usuario=?";
         $sentencia = $conexion->prepare($consulta);
         if($sentencia->execute($datos)){
            $respuesta["grupos"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
         }else
            $respuesta["error"] = "Error en la consulta. Error num: ".$sentencia->errorInfo()[1]." Error: ".$sentencia->errorInfo()[2];
            $sentencia = null;
            $conexion = null;
         
    }catch(PDOException $e){

        $respuesta["error"]= "Imposible conectar: ".$e->getMessage();
    }
    return $respuesta;
}

function borrar_grupo($datos){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        $consulta="DELETE FROM horario_lectivo WHERE dia=? AND hora=? AND usuario=? AND grupo=?";
        $sentencia = $conexion->prepare($consulta);
        if($sentencia->execute($datos)){
            $respuesta["mensaje"]="Borrado con exito";
        }else
        $respuesta["error"] = "Error en la consulta. Error num: ".$sentencia->errorInfo()[1]." Error: ".$sentencia->errorInfo()[2];
        $sentencia = null;
        $conexion = null;
    }catch(PDOException $e){

        $respuesta["error"]= "Imposible conectar: ".$e->getMessage();
    }
    return $respuesta;
}

function anadir_grupo($datos){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        $consulta="INSERT INTO horario_lectivo (dia,hora,usuario,grupo,aula) VALUE (?,?,?,?,'4')";
        $sentencia = $conexion->prepare($consulta);
        if($sentencia->execute($datos)){
            $respuesta["mensaje"]="Insertado con exito";
        }else
        $respuesta["error"] = "Error en la consulta. Error num: ".$sentencia->errorInfo()[1]." Error: ".$sentencia->errorInfo()[2];
        $sentencia = null;
        $conexion = null;
    }catch(PDOException $e){

        $respuesta["error"]= "Imposible conectar: ".$e->getMessage();
    }
    return $respuesta; 
}

function grupos_libres($datos){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
     $consulta="SELECT DISTINCT  grupos.* FROM horario_lectivo,grupos WHERE horario_lectivo.grupo=grupos.id_grupo
        AND horario_lectivo.dia=? AND horario_lectivo.hora=? AND horario_lectivo.usuario<>?";
         $sentencia = $conexion->prepare($consulta);
         if($sentencia->execute($datos)){
            $respuesta["gruposLibres"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
         }else
            $respuesta["error"] = "Error en la consulta. Error num: ".$sentencia->errorInfo()[1]." Error: ".$sentencia->errorInfo()[2];
            $sentencia = null;
            $conexion = null;
    }catch(PDOException $e){
        $respuesta["error"]= "Imposible conectar: ".$e->getMessage();
    }
    return $respuesta; 
}