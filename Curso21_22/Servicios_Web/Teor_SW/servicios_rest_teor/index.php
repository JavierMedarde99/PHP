<?php

require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

$app->get('/saludo',function(){
    $resp["msj"]="Saludo General";
    echo json_encode( $resp, JSON_FORCE_OBJECT);//{'msj':'Saludo General'}
});

$app->post('/nuevo_saludo',function($request){
    $saludo1=$request->getParam("saludos1");
    $saludo2=$request->getParam("saludos2");
    $resp["msj"]="Datos recibidos: ".$saludo1." y ".$saludo2;
    echo json_encode( $resp, JSON_FORCE_OBJECT);
});

$app->delete('/borrar_saludo/{id}', function($request){
    $dato=$request->getAttribute('id');
    $resp["msj"]="Borrado el saludo con id:".$dato;
    echo json_encode( $resp, JSON_FORCE_OBJECT);
});

$app->put('/modificar_saludo/{id}/{nuevo_valor}',function($request) {

    $resp["msj"]="El saludo con el id: ".$request->getAttribute('id'). " ha sido cambiado a :".$request->getAttribute('nuevo_valor');
    echo json_encode( $resp, JSON_FORCE_OBJECT);
});

$app->put('/modificar_saludo/{id}',function($request) {

    $resp["msj"]="El saludo con el id: ".$request->getAttribute('id'). " ha sido cambiado a :".$request->getParam('nuevo_valor');
    echo json_encode( $resp, JSON_FORCE_OBJECT);
});

// Una vez creado servicios los pongo a disposición
$app->run();
?>