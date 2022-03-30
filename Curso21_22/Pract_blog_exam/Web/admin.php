<?php

session_name("web_exam");
session_start();
require "src/funciones_servicios.php";

if(isset($_POST["btnNoticia"])){
$_SESSION["noticiaId"]=$_POST["idNoticia"];
}
if(isset($_POST["btnSalir"])){
    session_destroy();
    header("Location:index.php");
    exit;
}
if(isset($_POST["btnVolver"])){
   unset($_SESSION["noticiaId"]);
    header("Location:admin.php");
    exit;
}
if(isset($_POST["btnEnviar"])){
    $error_comentario=!isset($_POST["comentario"]);
    if(!$error_comentario){
        $datosInser["comentario"]=$_POST["comentario"];
        $datosInser["idUsuario"]=$_SESSION["usuarioId"];
        $datosInser["idNoticia"]=$_SESSION["noticiaId"];
        $datosInser["estado"]="sin validar";
        $url=DIR_SERV."/insertarComentario";
        $respuesta=consumir_servicios_REST($url,"PUT",$datosInser);
        $obj=json_decode($respuesta);
if(!$obj){
    session_destroy();
    die(error_page("Login","<p>Error consumiendo el servicio: ".$url."</p>".$respuesta));
}

if(isset($obj->error)){
    session_destroy();
    die(error_page("Login","<p>".$obj->error."</p>"));
}

if(isset($obj->ult_id)){
    $_SESSION["accion"]="insertado";
}
    }
}

if(isset($_POST["btnAprobar"])){
    $url=DIR_SERV."/aprobarComentario/".urlencode($_POST["idComentario"]);
    $respuesta=consumir_servicios_REST($url,"PUT");
    $obj=json_decode($respuesta);
    if(!$obj){
        session_destroy();
        die(error_page("Login","<p>Error consumiendo el servicio: ".$url."</p>".$respuesta));
    }
    
    if(isset($obj->error)){
        session_destroy();
        die(error_page("Login","<p>".$obj->error."</p>"));
    }

    if(isset($obj->apto)){
        $_SESSION["accion"]="Actualizado a apto";
    }
}

if(isset($_POST["btnBorrarCont"])){
    $url=DIR_SERV."/borrarComentario/".urlencode($_POST["idComentario"]);
    $respuesta=consumir_servicios_REST($url,"DELETE");
    $obj=json_decode($respuesta);
    if(!$obj){
        session_destroy();
        die(error_page("Login","<p>Error consumiendo el servicio: ".$url."</p>".$respuesta));
    }
    
    if(isset($obj->error)){
        session_destroy();
        die(error_page("Login","<p>".$obj->error."</p>"));
    }

    if(isset($obj->borrado)){
        $_SESSION["accion"]="Borrado";
    }
}

if(isset($_POST["btnEditarCont"])){
    $dato_act["comentario"]=$_POST["comentario2"];
    $url=DIR_SERV."/editarComentario/".urlencode($_POST["idComentario"]);
    $respuesta=consumir_servicios_REST($url,"PUT",$dato_act);
    $obj=json_decode($respuesta);
    if(!$obj){
        session_destroy();
        die(error_page("Login","<p>Error consumiendo el servicio: ".$url."</p>".$respuesta));
    }
    
    if(isset($obj->error)){
        session_destroy();
        die(error_page("Login","<p>".$obj->error."</p>"));
    }

    if(isset($obj->actualizado)){
        $_SESSION["accion"]="actualizado";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de usuario</title>
</head>
<body>
    <h1>GESTIÓN DE COMENTARIOS</h1>
    <p>Bienvenido: <strong><?php echo $_SESSION["usuario"]?></strong>-
    <form action="admin.php" method="post">
        <input type="submit" value="Salir" name="btnSalir">
    </form>

<?php
if(isset($_SESSION["accion"])){
    echo "<p>".$_SESSION["accion"]."</p>";
    unset($_SESSION["accion"]);
}


if(isset($_SESSION["noticiaId"])){
    $url=DIR_SERV."/noticiaVer/".urlencode($_SESSION["noticiaId"]);
    $respuesta=consumir_servicios_REST($url,"GET");
$obj=json_decode($respuesta);
if(!$obj){
    session_destroy();
    die(error_page("Login","<p>Error consumiendo el servicio: ".$url."</p>".$respuesta));
}

if(isset($obj->error)){
    session_destroy();
    die(error_page("Login","<p>".$obj->error."</p>"));
}
if(isset($obj->noticia)){   
  
    foreach($obj->noticia as $fila){
    echo "<h1>".$fila->titulo."</h1>";
    echo "<p>Publicado por <strong>".$fila->usuario."</strong> en <i>".$fila->valor."</i></p>";
    echo "<p>".$fila->cuerpo."</p>";
    }
}

$url=DIR_SERV."/comentariosVer/".urlencode($_SESSION["noticiaId"]);
    $respuesta=consumir_servicios_REST($url,"GET");
$obj=json_decode($respuesta);
if(!$obj){
    session_destroy();
    die(error_page("Login","<p>Error consumiendo el servicio: ".$url."</p>".$respuesta));
}

if(isset($obj->error)){
    session_destroy();
    die(error_page("Login","<p>".$obj->error."</p>"));
}
if(isset($obj->noticia)){   
  echo "<h2>Comentarios</h2>";
    foreach($obj->noticia as $fila){
    echo "<p>Publicado por <strong>".$fila->usuario."</strong> dijo:</p>";
    echo "<p><i>".$fila->comentario."</i></p>";
    }
}

echo "<form action='admin.php' method='post'>
<label for='comentario'>Dejar un comentario</label>
<textarea id='comentario' name='comentario'></textarea><br/>
        <p><input type='submit' value='volver' name='btnVolver'> <input type='submit' value='Enviar' name='btnEnviar'></p>
    </form>";
}else{
    echo "<h2>Todos los Comentario</h2>";
    $url=DIR_SERV."/obtenerComentarios";
    $respuesta=consumir_servicios_REST($url,"GET");
    $obj=json_decode($respuesta);
    if(!$obj){
        session_destroy();
        die(error_page("Login","<p>Error consumiendo el servicio: ".$url."</p>".$respuesta));
    }
    
    if(isset($obj->error)){
        session_destroy();
        die(error_page("Login","<p>".$obj->error."</p>"));
    }
    
    if(isset($obj->tabla)){
        echo "<table>";
        echo "<tr><th>ID</th><th>Comentarios</th><th>Opción</th></tr>";
        foreach($obj->tabla as $fila){
            echo "<tr>";
            echo "<td>".$fila->idComentario."</td>";
            echo "<td><p>".$fila->comentario."</p><p>Dijo ".$fila->usuario." en  
            <form action='admin.php' method='post'> 
            <input type='hidden' name='idNoticia' value='".$fila->idNoticia."'>
            <input type='submit' value='".$fila->titulo."' name='btnNoticia'>
            </form>
            </p></td>";
            if($fila->estado=="apto"){
                 echo "<td>
                 <form action='admin.php' method='post'> 
                 <input type='hidden' name='idComentario' value='".$fila->idComentario."'>
                 <input type='hidden' name='Comentario' value='".$fila->comentario."'>
                 <input type='submit' value='Editar' name='btnEditar'>
                 </form>
                 -
                 <form action='admin.php' method='post'> 
                 <input type='hidden' name='idComentario' value='".$fila->idComentario."'>
                 <input type='submit' value='Borrar' name='btnBorrar'>
                 </form></td>";
            }else{
                echo "<td> <form action='admin.php' method='post'> 
                <input type='hidden' name='idComentario' value='".$fila->idComentario."'>
                <input type='submit' value='Aprobado' name='btnAprobar'>
                </form>
                -
                <form action='admin.php' method='post'> 
                <input type='hidden' name='idComentario' value='".$fila->idComentario."'>
                <input type='hidden' name='Comentario' value='".$fila->comentario."'>
                <input type='submit' value='Editar' name='btnEditar'>
                </form>
                -
                <form action='admin.php' method='post'> 
                <input type='hidden' name='idComentario' value='".$fila->idComentario."'>
                <input type='submit' value='Borrar' name='btnBorrar'>
                </form></td>";
            }
           
            echo "</tr>";
        }
        echo "</table>";
    }

    if(isset($_POST["btnBorrar"])){
      echo "  <form action='admin.php' method='post'> 
                <input type='hidden' name='idComentario' value='".$_POST["idComentario"]."'>
                <p>¿Esta seguro que quiere borrar el comentario?</p>
                <p><input type='submit' value='volver' name='btnVolver'> <input type='submit' value='Borrar' name='btnBorrarCont'></p>
                </form>";
    }

    if(isset($_POST["btnEditar"])){
        echo "<form action='admin.php' method='post'> 
        <input type='hidden' name='idComentario' value='".$_POST["idComentario"]."'>
        <label for='comentario2'>Comentario</label>
        <textarea id='comentario2' name='comentario2'>".$_POST["Comentario"]."</textarea>
        <p><input type='submit' value='volver' name='btnVolver'> <input type='submit' value='Editar' name='btnEditarCont'></p>
        </form>";
    }
}

?>
</body>
</html>