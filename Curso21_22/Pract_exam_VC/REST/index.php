<?php

require "funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

$app->get('/obtenerPeliculas',function(){

    echo json_encode( obtener_peliculas(), JSON_FORCE_OBJECT);
});

$app->post('/crearUsuario',function($request){
$datos[]=$request->getParam('DNI');
$datos[]=$request->getParam('usuario');
$datos[]=$request->getParam('clave');
$datos[]=$request->getParam('telefono');
$datos[]=$request->getParam('email');
    echo json_encode( crear_usuario($datos), JSON_FORCE_OBJECT);
});

$app->post('/login',function($request){
    $datos[]=$request->getParam('usuario');
    $datos[]=$request->getParam('clave');
    echo json_encode( login($datos), JSON_FORCE_OBJECT);
});


$app->get('/usuarioDni/{DNI}',function($request){
    echo json_encode( usuario_dni($request->getAttribute('DNI')), JSON_FORCE_OBJECT);
});


$app->get('/usuarioNombre/{nombre}',function($request){

    echo json_encode( usuario_nombre($request->getAttribute('nombre')), JSON_FORCE_OBJECT);
});

// Una vez creado servicios los pongo a disposición
$app->run();
?>