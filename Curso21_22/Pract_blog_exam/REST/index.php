<?php

require "funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

$app->post('/login',function($request){
    $datos[]=$request->getParam('usuario');
    $datos[]=$request->getParam('clave');
    echo json_encode( login($datos), JSON_FORCE_OBJECT);
});

$app->get('/obtenerComentarios',function($request){
    echo json_encode( obtener_comentarios(), JSON_FORCE_OBJECT);
});

$app->get('/noticiaVer/{idNoticia}',function($request){

    echo json_encode( noticia_ver($request->getAttribute('idNoticia')), JSON_FORCE_OBJECT);
});

$app->put('/insertarComentario',function($request){
    $datos[]=$request->getParam('comentario');
    $datos[]=$request->getParam('idUsuario');
    $datos[]=$request->getParam('idNoticia');
    $datos[]=$request->getParam('estado');
    echo json_encode( insertar_comentarios($datos), JSON_FORCE_OBJECT);
});

$app->get('/comentariosVer/{idNoticia}',function($request){

    echo json_encode( comentarios_ver($request->getAttribute('idNoticia')), JSON_FORCE_OBJECT);
});

$app->put('/aprobarComentario/{idComentario}',function($request){
    echo json_encode( aprobar_comentario($request->getAttribute('idComentario')), JSON_FORCE_OBJECT);
});


$app->delete('/borrarComentario/{idComentario}',function($request){

    echo json_encode( borrar_comentario($request->getAttribute('idComentario')), JSON_FORCE_OBJECT);
});

$app->put('/editarComentario/{idComentario}',function($request){
    $datos[]=$request->getParam('comentario');
    echo json_encode( editar_comentario($request->getAttribute('idComentario'),$datos), JSON_FORCE_OBJECT);
});

// Una vez creado servicios los pongo a disposición
$app->run();
?>