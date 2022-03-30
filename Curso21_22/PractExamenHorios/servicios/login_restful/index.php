<?php

require "funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

$app->post('/login',function($request){
    $datos[]=$request->getParam('usuario');
    $datos[]=$request->getParam('clave');
    echo json_encode( inicio_sesion($datos), JSON_FORCE_OBJECT);
});

$app->get('/usuario/{id_usuario}',function($request){
    echo json_encode( obtener_usuario($request->getAttribute('id_usuario')), JSON_FORCE_OBJECT);
});

$app->get('/usuariosGuardia/{dia}/{hora}',function($request){
    
    echo json_encode( usuarios_guardia($request->getAttribute('dia'),$request->getAttribute('hora')), JSON_FORCE_OBJECT);
});

$app->get('/deGuardia/{dia}/{hora}/{id_usuario}',function($request){
    echo json_encode( guardia($request->getAttribute('dia'),$request->getAttribute('hora'),$request->getAttribute('id_usuario')), JSON_FORCE_OBJECT);
});

// Una vez creado servicios los pongo a disposición
$app->run();
?>
