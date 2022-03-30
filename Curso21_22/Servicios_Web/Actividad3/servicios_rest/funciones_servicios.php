<?php
require "config_bd.php";

function obtener_productos()
{
    @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
    if(!$conexion)
        $respuesta["error"]="Imposible conectar. Error Número: ".mysqli_connect_errno(). ":".mysqli_connect_error();
    else
    {
        mysqli_set_charset($conexion,"utf8");
        $consulta="select * from producto";
        $resultado=mysqli_query($conexion,$consulta);
        if($resultado)
        {
            $productos=array();
            while($fila=mysqli_fetch_assoc($resultado))
                $productos[]=$fila;
            
            $respuesta["productos"]=$productos;
            mysqli_free_result($resultado);
        }
        else
              $respuesta["error"]="Imposible realizar la consulta. Error Número: ".mysqli_errno($conexion). ":".mysqli_error($conexion);
        
        mysqli_close($conexion);
    }

    return $respuesta;
}

function obtener_producto($cod)
{
    @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
    if(!$conexion)
        $respuesta["error"]="Imposible conectar. Error Número: ".mysqli_connect_errno(). ":".mysqli_connect_error();
    else
    {
        mysqli_set_charset($conexion,"utf8");
        $consulta="select * from producto where cod='".$cod."'";
        $resultado=mysqli_query($conexion,$consulta);
        if($resultado)
        {
            if(mysqli_num_rows($resultado)>0)
                $respuesta["producto"]=mysqli_fetch_assoc($resultado);  
            else
                $respuesta["mensaje"]="No existe ningún producto con el código: ".$cod;
            
            mysqli_free_result($resultado);
        }
        else
              $respuesta["error"]="Imposible realizar la consulta. Error Número: ".mysqli_errno($conexion). ":".mysqli_error($conexion);
        
        mysqli_close($conexion);
    }

    return $respuesta;
}

function insertar_producto($datos)
{
    @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
    if(!$conexion)
        $respuesta["error"]="Imposible conectar. Error Número: ".mysqli_connect_errno(). ":".mysqli_connect_error();
    else
    {
        mysqli_set_charset($conexion,"utf8");
        $consulta="insert into producto (cod,nombre,nombre_corto,descripcion,PVP,familia) values ('".$datos["cod"]."','".$datos["nombre"]."','".$datos["nombre_corto"]."','".$datos["descripcion"]."',".$datos["PVP"].",'".$datos["familia"]."')";
        $resultado=mysqli_query($conexion,$consulta);
        if($resultado)
            $respuesta["mensaje"]="Producto insertado con éxito";

        else
            $respuesta["error"]="Imposible realizar la consulta. Error Número: ".mysqli_errno($conexion). ":".mysqli_error($conexion);
        
        mysqli_close($conexion);
    }

    return $respuesta;
}

function actualizar_producto($datos)
{
    @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
    if(!$conexion)
        $respuesta["error"]="Imposible conectar. Error Número: ".mysqli_connect_errno(). ":".mysqli_connect_error();
    else
    {
        mysqli_set_charset($conexion,"utf8");
        $consulta="update producto set nombre='".$datos["nombre"]."', nombre_corto='".$datos["nombre_corto"]."', descripcion='".$datos["descripcion"]."', PVP=".$datos["PVP"]." , familia='".$datos["familia"]."' where cod='".$datos["cod"]."'";
        $resultado=mysqli_query($conexion,$consulta);
        if($resultado)
            $respuesta["mensaje"]="Producto actualizado con éxito";

        else
            $respuesta["error"]="Imposible realizar la consulta. Error Número: ".mysqli_errno($conexion). ":".mysqli_error($conexion);
         
        
        mysqli_close($conexion);
    }

    return $respuesta;
}

function borrar_producto($cod)
{
    @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
    if(!$conexion)
        $respuesta["error"]="Imposible conectar. Error Número: ".mysqli_connect_errno(). ":".mysqli_connect_error();
    else
    {
        mysqli_set_charset($conexion,"utf8");
        $consulta="delete from producto where cod='".$cod."'";
        $resultado=mysqli_query($conexion,$consulta);
        if($resultado)
            $respuesta["mensaje"]="Producto borrado con éxito";

        else
            $respuesta["error"]="Imposible realizar la consulta. Error Número: ".mysqli_errno($conexion). ":".mysqli_error($conexion);
         
        
        mysqli_close($conexion);
    }

    return $respuesta;
}

function obtener_familias()
{
    @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
    if(!$conexion)
        $respuesta["error"]="Imposible conectar. Error Número: ".mysqli_connect_errno(). ":".mysqli_connect_error();
    else
    {
        mysqli_set_charset($conexion,"utf8");
        $consulta="select * from familia";
        $resultado=mysqli_query($conexion,$consulta);
        if($resultado)
        {
            $familia=array();
            while($fila=mysqli_fetch_assoc($resultado))
                $familia[]=$fila;
            
            $respuesta["familias"]=$familia;
            mysqli_free_result($resultado);
        }
        else
              $respuesta["error"]="Imposible realizar la consulta. Error Número: ".mysqli_errno($conexion). ":".mysqli_error($conexion);
        
        mysqli_close($conexion);
    }

    return $respuesta;
}

function repetido($tabla,$columna,$valor,$columna_id=null,$valor_id=null)
{
    @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
    if(!$conexion)
        $respuesta["error"]="Imposible conectar. Error Número: ".mysqli_connect_errno(). ":".mysqli_connect_error();
    else
    {
        mysqli_set_charset($conexion,"utf8");
        
        $clausula="";
        if(isset($columna_id))
        {
            $clausula=" AND ".$columna_id."<>'".$valor_id."'";
        }
        $consulta="select ".$columna." from ".$tabla." where ".$columna."='".$valor."'".$clausula;

        $resultado=mysqli_query($conexion,$consulta);
        if($resultado)
        {
            $respuesta["repetido"]=mysqli_num_rows($resultado)>0;
            mysqli_free_result($resultado);
        }
        else
              $respuesta["error"]="Imposible realizar la consulta. Error Número: ".mysqli_errno($conexion). ":".mysqli_error($conexion);
        
        mysqli_close($conexion);
    }

    return $respuesta;
}

?>