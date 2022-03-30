<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;



$app->get('/conexion_PDO',function($request){

    echo json_encode( conexion_pdo(), JSON_FORCE_OBJECT);
});

$app->get('/conexion_MYSQLI',function($request){
    
    echo json_encode( conexion_mysqli(), JSON_FORCE_OBJECT);
});

$app->post("/login", function($request){

    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");

    echo json_encode(loginUsuario($datos), JSON_FORCE_OBJECT);
});

$app->get("/horario/{id_usuario}", function($request){

    echo json_encode(obtenerHorarioUsuario($request->getAttribute("id_usuario")), JSON_FORCE_OBJECT);
});

$app->get("/usuarios",function($request){

    echo json_encode(usuarios(),JSON_FORCE_OBJECT);
});

$app->get("/grupos/{dia}/{hora}/{id_usuario}",function($request){
    $datos[]=$request->getAttribute("dia");
    $datos[]=$request->getAttribute("hora");
    $datos[]=$request->getAttribute("id_usuario");
    echo json_encode(obtener_grupo($datos),JSON_FORCE_OBJECT);
});

$app->delete("/borrarGrupo/{dia}/{hora}/{id_usuario}/{grupo}",function($request){
    $datos[]=$request->getAttribute("dia");
    $datos[]=$request->getAttribute("hora");
    $datos[]=$request->getAttribute("id_usuario");
    $datos[]=$request->getAttribute("grupo");
    echo json_encode(borrar_grupo($datos),JSON_FORCE_OBJECT);
});

$app->post("/insertarGrupo/{dia}/{hora}/{id_usuario}/{grupo}",function($request){
    $datos[]=$request->getAttribute("dia");
    $datos[]=$request->getAttribute("hora");
    $datos[]=$request->getAttribute("id_usuario");
    $datos[]=$request->getAttribute("grupo");
    echo json_encode(anadir_grupo($datos),JSON_FORCE_OBJECT);
});

$app->get("/gruposLibres/{dia}/{hora}/{id_usuario}",function($request){
    $datos[]=$request->getAttribute("dia");
    $datos[]=$request->getAttribute("hora");
    $datos[]=$request->getAttribute("id_usuario");
    echo json_encode(grupos_libres($datos),JSON_FORCE_OBJECT);
});

// Una vez creado servicios los pongo a disposición
$app->run();
?>
