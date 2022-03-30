<?php

require "funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

$app->get('/usuarios',function(){

    echo json_encode( obtener_usuarios(), JSON_FORCE_OBJECT);
});

$app->post('/crearUsuario',function($request){
    $datos[]=$request->getParam('nombre');
    $datos[]=$request->getParam('usuario');
    $datos[]=$request->getParam('clave');
    $datos[]=$request->getParam('email');
    echo json_encode( insertar_usuario($datos), JSON_FORCE_OBJECT);
});

$app->post('/login',function($request){
    $datos[]=$request->getParam('usuario');
    $datos[]=$request->getParam('clave');
    
    echo json_encode( login_usuario($datos), JSON_FORCE_OBJECT);
});

$app->put('/actualizarUsuario/{id_usuario}',function($request){
    $datos["nombre"]=$request->getParam('nombre');
    $datos["usuario"]=$request->getParam('usuario');
    $datos["clave"]=$request->getParam('clave');
    $datos["email"]=$request->getParam('email');
    $datos["id_usuario"]=$request->getAttribute('id_usuario');
    
    echo json_encode( actualizar_usuario($datos), JSON_FORCE_OBJECT);
});

$app->delete('/borrarUsuario/{id_usuario}',function($request){
    
    
    echo json_encode( borrar_usuario($request->getAttribute('id_usuario')), JSON_FORCE_OBJECT);
});

// Una vez creado servicios los pongo a disposición
$app->run();
?>