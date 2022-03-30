<?php
require "config_bd.php";

function obtener_peliculas()
{
    try{
    $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
   $consulta="SELECT * FROM peliculas";
   $sentencia=$conexion->prepare($consulta);
   if($sentencia->execute()){
    $respuesta["peliculas"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
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

function crear_usuario($datos)
{
   try{
    $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
  $consulta="INSERT INTO usuarios (DNI,usuario,clave,telefono,email) VALUES (?,?,?,?,?)";
  $sentencia=$conexion->prepare($consulta);
  if($sentencia->execute($datos)){
    $respuesta["ult_id"]=$conexion->lastInsertId();
    if($respuesta["ult_id"]){
        echo "insertar";
    }
  }else{
    $respuesta["error"]= "Error en la consulta. Error n&uacute;mero:".$sentencia->errorInfo()[1]." : ".$sentencia->errorInfo()[2];
   }
   $sentencia=null;
   $conexion=null;
   }catch(PDOException $e){
       $respuesta["error"]="Imposible conectar: ".$e->getMessage();
   }
   return $respuesta;
}

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

function usuario_dni($DNI){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
      $consulta="SELECT * FROM usuarios WHERE DNI='".$DNI."'";
      $sentencia=$conexion->prepare($consulta);
      if($sentencia->execute()){
            if($sentencia->rowCount()>0){
                $respuesta["usuario"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
            }else{
                $respuesta["mensaje"]="El usuario no se encuentra en la BD";
      
            }
      }
      $conexion=null;
      $consulta=null;
    }catch(PDOException $e){
        $respuesta["error"]= "Imposible conectar: ".$e->getMessage();
    }
    return $respuesta;
}

function usuario_nombre($nombre){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
      $consulta="SELECT * FROM usuarios WHERE usuario='".$nombre."'";
      $sentencia=$conexion->prepare($consulta);
      if($sentencia->execute()){
            if($sentencia->rowCount()>0){
                $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
            }else{
                $respuesta["mensaje"]="El usuario no se encuentra en la BD";
      
            }
      }
      $conexion=null;
      $consulta=null;
    }catch(PDOException $e){
        $respuesta["error"]= "Imposible conectar: ".$e->getMessage();
    }
    return $respuesta;
}
?>
