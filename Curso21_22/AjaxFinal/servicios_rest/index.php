<?php
session_name("practFinal_login_21_22");
session_start();

require "funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

$app->get('/logueado',function(){
    echo json_encode( seguridad(), JSON_FORCE_OBJECT);
});


$app->get('/salir',function(){
    session_destroy();
    echo json_encode( array("nada"=>"nada"), JSON_FORCE_OBJECT);
});

$app->post('/login',function($request){
    $datos[]=$request->getParam('usuario');
    $datos[]=$request->getParam('clave');
    
    echo json_encode( login_usuario($datos), JSON_FORCE_OBJECT);
});


///// Servicios para la aplicación

$app->get("/usuarios", function(){

    echo json_encode(obtener_usuarios(), JSON_FORCE_OBJECT);
});

$app->get("/horario/{id_usuario}", function($request){

    echo json_encode(obtener_horario($request->getAttribute("id_usuario")), JSON_FORCE_OBJECT);
});

$app->get("/tieneGrupo/{dia}/{hora}/{id_usuario}", function($request){

    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");
    $datos[] = $request->getAttribute("id_usuario");

    echo json_encode(tiene_grupo($datos), JSON_FORCE_OBJECT);
});

$app->get("/grupos/{dia}/{hora}/{id_usuario}", function($request){

    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");
    $datos[] = $request->getAttribute("id_usuario");

    echo json_encode(obtener_grupos($datos), JSON_FORCE_OBJECT);
});

$app->delete("/borrarGrupo/{dia}/{hora}/{id_usuario}/{id_grupo}", function($request){

    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");
    $datos[] = $request->getAttribute("id_usuario");
    $datos[] = $request->getAttribute("id_grupo");

    echo json_encode(borrar_grupo($datos), JSON_FORCE_OBJECT);
});

$app->get("/gruposLibres/{dia}/{hora}/{id_usuario}", function($request){

    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");
    $datos[] = $request->getAttribute("id_usuario");

    echo json_encode(grupos_libres($datos), JSON_FORCE_OBJECT);
});

$app->get("/aulasLibres/{dia}/{hora}", function($request){

    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");

    echo json_encode(aulas_libres($datos), JSON_FORCE_OBJECT);
});

$app->post("/insertarGrupo/{dia}/{hora}/{id_usuario}/{id_grupo}/{id_aula}", function($request){

    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");
    $datos[] = $request->getAttribute("id_usuario");
    $datos[] = $request->getAttribute("id_grupo");
    $datos[] = $request->getAttribute("id_aula");

    echo json_encode(insertar_grupo($datos), JSON_FORCE_OBJECT);
});

$app->put("/actualizarAula/{aula}/{dia}/{hora}/{id_usuario}", function($request){

    $datos[] = $request->getAttribute("aula");
    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");
    $datos[] = $request->getAttribute("id_usuario");

    echo json_encode(actualizar_aula($datos), JSON_FORCE_OBJECT);
});

$app->get("/aulasOcupadas/{dia}/{hora}", function($request){

    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");

    echo json_encode(aulas_ocupadas($datos), JSON_FORCE_OBJECT);
});

$app->get("/comprobar_al_aniadir/{dia}/{hora}/{aula}", function($request){

    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");
    $datos[] = $request->getAttribute("aula");

    echo json_encode(comprobar_aniadir($datos), JSON_FORCE_OBJECT);
});



// Una vez creado servicios los pongo a disposición
$app->run();
