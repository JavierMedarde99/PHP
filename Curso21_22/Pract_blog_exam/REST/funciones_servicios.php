<?php
require "config_bd.php";
function login($datos){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        $consulta="SELECT * FROM usuarios WHERE usuario=? AND clave=?";
        $sentencia=$conexion->prepare($consulta);
        if($sentencia->execute($datos)){
            if($sentencia->rowCount()>0){
                $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
            }else{
                $respuesta["mensaje"]="El usuario no se encuentra registrado en la BD";
            }
        }else{
            $respuesta["error"]="Error en la consulta. Error n&uacute;mero:".$sentencia->errorInfo()[1]." : ".$sentencia->errorInfo()[2];
        }
        $sentencia=null;
        $conexion=null;

    }catch(PDOException $e){
        $respuesta["error"]="Imposible conectar: ".$e->getMessage();
    }
    return $respuesta;
}
function obtener_comentarios()
{
    try{
    $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
   $consulta="SELECT comentarios.comentario,comentarios.idComentario,noticias.titulo,usuarios.usuario,comentarios.estado,noticias.idNoticia FROM usuarios,comentarios,noticias 
   WHERE usuarios.idUsuario=comentarios.idUsuario AND comentarios.idNoticia=noticias.idNoticia";
   $sentencia=$conexion->prepare($consulta);
   if($sentencia->execute()){
    $respuesta["tabla"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
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
function noticia_ver($noticia){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
       $consulta="SELECT noticias.titulo,noticias.cuerpo,usuarios.usuario,categorias.valor FROM usuarios,categorias,noticias 
       WHERE noticias.idNoticia=? AND usuarios.idUsuario=noticias.idUsuario AND categorias.idCategoria=noticias.idCategoria ";
       $sentencia=$conexion->prepare($consulta);
       if($sentencia->execute([$noticia])){
        $respuesta["noticia"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
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

function comentarios_ver($noticia){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
       $consulta="SELECT usuarios.usuario,comentarios.comentario,usuarios.idUsuario FROM usuarios,comentarios,noticias 
       WHERE noticias.idNoticia=".$noticia." AND usuarios.idUsuario=comentarios.idUsuario AND comentarios.idNoticia=noticias.idNoticia ";
       $sentencia=$conexion->prepare($consulta);
       if($sentencia->execute()){
        $respuesta["noticia"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
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

function insertar_comentarios($datos){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        $consulta="INSERT INTO comentarios (comentario,idUsuario,idNoticia,estado) VALUES (?,?,?,?)";
        $sentencia=$conexion->prepare($consulta);
        if($sentencia->execute($datos)){
            $respuesta["ult_id"]=$conexion->lastInsertId();
        }else{
            $respuesta["error"]="Error en la consulta. Error n&uacute;mero:".$sentencia->errorInfo()[1]." : ".$sentencia->errorInfo()[2];
        }
        $sentencia=null;
        $conexion=null;

    }catch(PDOException $e){
        $respuesta["error"]="Imposible conectar: ".$e->getMessage();
    }
    return $respuesta;
}

function aprobar_comentario($idComentario){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        $consulta="UPDATE comentarios SET estado = 'apto' WHERE comentarios.idComentario=".$idComentario."";
        $sentencia=$conexion->prepare($consulta);
        if($sentencia->execute()){
            $respuesta["apto"]="estado cambiado";
    
            
        }else{
            $respuesta["error"]="Error en la consulta. Error n&uacute;mero:".$sentencia->errorInfo()[1]." : ".$sentencia->errorInfo()[2];
        }
        $sentencia=null;
        $conexion=null;

    }catch(PDOException $e){
        $respuesta["error"]="Imposible conectar: ".$e->getMessage();
    }
    return $respuesta;
}

function borrar_comentario($idComentario){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        $consulta="DELETE FROM comentarios WHERE idComentario=".$idComentario."";
        $sentencia=$conexion->prepare($consulta);
        if($sentencia->execute()){
            $respuesta["borrado"]="borrado";
    
            
        }else{
            $respuesta["error"]="Error en la consulta. Error n&uacute;mero:".$sentencia->errorInfo()[1]." : ".$sentencia->errorInfo()[2];
        }
        $sentencia=null;
        $conexion=null;

    }catch(PDOException $e){
        $respuesta["error"]="Imposible conectar: ".$e->getMessage();
    }
    return $respuesta;
}

function editar_comentario($idComentario,$datos){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        $consulta="UPDATE comentarios SET comentario = ? WHERE comentarios.idComentario=".$idComentario."";
        $sentencia=$conexion->prepare($consulta);
        if($sentencia->execute($datos)){
            $respuesta["actualizado"]="comentario actualizado";
    
            
        }else{
            $respuesta["error"]="Error en la consulta. Error n&uacute;mero:".$sentencia->errorInfo()[1]." : ".$sentencia->errorInfo()[2];
        }
        $sentencia=null;
        $conexion=null;

    }catch(PDOException $e){
        $respuesta["error"]="Imposible conectar: ".$e->getMessage();
    }
    return $respuesta;
}
?>
