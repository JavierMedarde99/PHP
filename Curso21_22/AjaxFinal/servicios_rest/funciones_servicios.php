<?php
require "config_bd.php";
define('MINUTOS', 10);

function seguridad()
{

    if (isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["ultimo_acceso"])) {
        if (time() - $_SESSION["ultimo_acceso"] > MINUTOS * 60) {
            $respuesta["time"] = "Tiempo de sesión caducado";
        } else {
            try {
                $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
                $consulta = "select * from usuarios where usuario=? and clave=?";
                $sentencia = $conexion->prepare($consulta);
                if ($sentencia->execute([$_SESSION["usuario"], $_SESSION["clave"]])) {
                    if ($sentencia->rowCount() > 0) {
                        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
                        $_SESSION["ultimo_acceso"] = time();
                    } else
                        $respuesta["baneo"] = "El usuario no se encuentra registrado en la BD";
                } else {
                    $respuesta["error"] = "Error en la consulta. Error n&uacute;mero:" . $sentencia->errorInfo()[1] . " : " . $sentencia->errorInfo()[2];
                }
                $sentencia = null;
                $conexion = null;
            } catch (PDOException $e) {
                $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
            }
        }
    } else {
        $respuesta["no_login"] = "No está logueado";
    }
    return $respuesta;
}

function login_usuario($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $consulta = "select * from usuarios where usuario=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        if ($sentencia->execute($datos)) {
            if ($sentencia->rowCount() > 0) {
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
                $_SESSION["usuario"] = $datos[0];
                $_SESSION["clave"] = $datos[1];
                $_SESSION["ultimo_acceso"] = time();
            } else
                $respuesta["mensaje"] = "El usuario no se encuentra registrado en la BD";
        } else {
            $respuesta["error"] = "Error en la consulta. Error n&uacute;mero:" . $sentencia->errorInfo()[1] . " : " . $sentencia->errorInfo()[2];
        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}


/*FUNCIONES PARA LOS HORARIOS DE LA APLICACIÓN*/

function obtener_usuarios()
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $consulta = "select * from usuarios where tipo = 'normal'";
        $sentencia = $conexion->prepare($consulta);

        if ($sentencia->execute()) {

            $respuesta["usuarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } else {

            $respuesta["error"] = "Error en la consulta realizada";
        }
        $conexion = null;
        $sentencia = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "Error en la conexión realizada: " . $e->getMessage();
    }

    return $respuesta;
}

function obtener_horario($id_usuario)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $consulta = "select dia, hora, grupos.id_grupo, grupos.nombre as grupo, aulas.id_aula, aulas.nombre as aula 
        from horario_lectivo, grupos, aulas where horario_lectivo.grupo = grupos.id_grupo and horario_lectivo.aula = aulas.id_aula and horario_lectivo.usuario = ?";
        $sentencia = $conexion->prepare($consulta);

        if ($sentencia->execute([$id_usuario])) {

            $respuesta["horario"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } else {

            $respuesta["error"] = "Error en la consulta realizada";
        }
        $conexion = null;
        $sentencia = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "Error en la conexion realizada: " . $e->getMessage();
    }

    return $respuesta;
}

function obtener_grupos($datos)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $consulta = "select grupos.id_grupo, grupos.nombre as grupo from grupos, horario_lectivo 
        where horario_lectivo.grupo = grupos.id_grupo and dia = ? and hora = ? and usuario = ?";
        $sentencia = $conexion->prepare($consulta);

        if ($sentencia->execute($datos)) {

            $respuesta["grupos"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } else {

            $respuesta["error"] = "Error en la consulta realizada";
        }
        $conexion = null;
        $sentencia = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "Error al realizar la conexion realizada: " . $e->getMessage();
    }

    return $respuesta;
}

function tiene_grupo($datos)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $consulta = "select * from horario_lectivo where dia = ? and hora = ? and usuario = ?";
        $sentencia = $conexion->prepare($consulta);

        if ($sentencia->execute($datos)) {

            $respuesta["tiene_grupo"] = $sentencia->rowCount() > 0;
        } else {

            $respuesta["error"] = "Error en la consulta realizada";
        }
        $conexion = null;
        $sentencia = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "Error al realizar la conexion realizada: " . $e->getMessage();
    }

    return $respuesta;
}

function grupos_libres($datos)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $consulta = "select grupos.id_grupo, grupos.nombre as grupo from grupos 
        where (grupos.id_grupo) not in (select grupos.id_grupo from grupos, horario_lectivo where grupos.id_grupo = horario_lectivo.grupo and dia = ? and hora = ? and usuario = ?)";
        $sentencia = $conexion->prepare($consulta);

        if ($sentencia->execute($datos)) {

            $respuesta["grupos"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } else {

            $respuesta["error"] = "Error en la consulta realizada";
        }
        $conexion = null;
        $sentencia = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "Error al realizar la conexion realizada: " . $e->getMessage();
    }

    return $respuesta;
}

function borrar_grupo($datos)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $consulta = "delete from horario_lectivo where dia = ? and hora = ? and usuario = ? and grupo = ?";
        $sentencia = $conexion->prepare($consulta);

        if ($sentencia->execute($datos)) {

            $respuesta["mensaje"] = "Grupo borrado con éxito";
        } else {

            $respuesta["error"] = "Error en la consulta realizada";
        }
        $conexion = null;
        $sentencia = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "Error al realizar la conexion realizada: " . $e->getMessage();
    }

    return $respuesta;
}

function insertar_grupo($datos)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $consulta = "insert into horario_lectivo (dia, hora, usuario, grupo, aula) values (?, ?, ?, ?, ?)";
        $sentencia = $conexion->prepare($consulta);

        if ($sentencia->execute($datos)) {

            $respuesta["mensaje"] = "Grupo insertado con éxito";
        } else {

            $respuesta["error"] = "Error en la consulta realizada";
        }
        $conexion = null;
        $sentencia = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "Error al realizar la conexion realizada: " . $e->getMessage();
    }

    return $respuesta;
}

function aulas_libres($datos)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $consulta = "select aulas.id_aula, aulas.nombre as aula from aulas where (aulas.id_aula, aulas.nombre) not in 
        (select aulas.id_aula, aulas.nombre from aulas, horario_lectivo where aulas.id_aula = horario_lectivo.aula and dia = ? and hora = ?)";
        $sentencia = $conexion->prepare($consulta);

        if ($sentencia->execute($datos)) {

            $respuesta["aulas_libres"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } else {

            $respuesta["error"] = "Error en la consulta realizada";
        }
        $conexion = null;
        $sentencia = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "Error al realizar la conexion realizada: " . $e->getMessage();
    }

    return $respuesta;
}

function aulas_ocupadas($datos){

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $consulta = "select distinct aulas.id_aula, aulas.nombre as aula from aulas, horario_lectivo where aulas.id_aula = horario_lectivo.aula and dia = ? and hora = ? and aulas.id_aula <> 64";
        $sentencia = $conexion->prepare($consulta);

        if ($sentencia->execute($datos)) {

            $respuesta["aulas_ocupadas"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } else {

            $respuesta["error"] = "Error en la consulta realizada";
        }
        $conexion = null;
        $sentencia = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "Error al realizar la conexion realizada: " . $e->getMessage();
    }

    return $respuesta;
}


function comprobar_aniadir($datos){

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $consulta = "select horario_lectivo.usuario, horario_lectivo.grupo, grupos.nombre as nombre_grupo from horario_lectivo, grupos 
        where horario_lectivo.grupo = grupos.id_grupo and dia = ? and hora = ? and aula = ?"; //and like '%[0-9]%'";
        $sentencia = $conexion->prepare($consulta);

        if ($sentencia->execute($datos)) {

            if($sentencia->rowCount() > 0){

                $respuesta["ocupada"] = true;
                $respuesta["profesor"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            }else{

                $respuesta["ocupada"] = false;
            }
            
        } else {

            $respuesta["error"] = "Error en la consulta realizada";
        }
        $conexion = null;
        $sentencia = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "Error al realizar la conexion realizada: " . $e->getMessage();
    }

    return $respuesta;
}

function actualizar_aula($datos){

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $consulta = "update horario_lectivo set aula = ? where dia = ? and hora = ? and usuario = ?";
        $sentencia = $conexion->prepare($consulta);

        if ($sentencia->execute($datos)) {

            $respuesta["mensaje"] = "Aula actualizada con éxito";            
        } else {

            $respuesta["error"] = "Error en la consulta realizada";
        }
        $conexion = null;
        $sentencia = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "Error al realizar la conexion realizada: " . $e->getMessage();
    }

    return $respuesta;
}